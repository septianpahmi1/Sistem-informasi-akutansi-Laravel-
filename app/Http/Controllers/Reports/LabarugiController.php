<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\Dapur;
use App\Models\investor;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabarugiController extends Controller
{
    public function index()
    {
        $title = "Laporan Laba Rugi";
        $dapur = Dapur::orderBy('created_at', 'asc')
            ->get();
        return view('admin.reports.labarugi', compact('title', 'dapur'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'dapur_id'   => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);
        $title = "Laporan Laba Rugi";
        $periodStart = Carbon::parse($request->start_date)->startOfDay();
        $periodEnd   = Carbon::parse($request->end_date)->endOfDay();
        $dapur = Dapur::where('id', $request->dapur_id)->first();
        // Ambil semua journal entries dalam periode
        $entries = JournalEntry::with('account')
            ->whereHas('journal', function ($q) use ($periodStart, $periodEnd, $request) {
                $q->whereBetween('date', [$periodStart, $periodEnd])
                    ->where('dapur_id', $request->dapur_id);
            })
            ->get();

        if ($entries->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk periode dan dapur yang dipilih.');
        }

        // Pisahkan berdasarkan tipe akun untuk Laba/Rugi
        $revenues = $entries->filter(fn($e) => $e->account->type === 'income')
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])->values()->toArray();

        $cost = $entries->filter(fn($e) => $e->account->type === 'cost')
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])->values()->toArray();

        $cogs = $entries->filter(
            fn($e) =>
            $e->account->type === 'expense' && str_contains(strtolower($e->account->name), 'pokok')
        )
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total,
            ])
            ->values()
            ->toArray();


        $operationalExpenses = $entries->filter(fn($e) => $e->account->type === 'expense' && !str_contains(strtolower($e->account->name), 'pokok'))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total,
            ])->values()->toArray();

        $nonOperatingIncome = $entries->filter(fn($e) => $e->account->type === 'income' && str_contains(strtolower($e->account->name), 'non'))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])->values()->toArray();

        $nonOperatingExpenses = $entries->filter(fn($e) => $e->account->type === 'expense' && str_contains(strtolower($e->account->name), 'non'))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total,
            ])->values()->toArray();
        return view('admin.reports.printable.laba', [
            'companyName' => 'KOPERASI CIPTA USAHA SENTOSA',
            'companyAddress' => 'Jl. Pd. Bambu Kuning No.8, RT.3/RW.4, Bojong Baru, Kecamatan Bojonggede, Kabupaten Bogor, Jawa Barat 16920',
            'periodStart' => $periodStart,
            'periodEnd'   => $periodEnd,
            'currency'    => 'Indonesian Rupiah',
            'dapur' => $dapur,
            'revenues'            => $revenues,
            'cogs'                => $cogs,
            'operationalExpenses' => $operationalExpenses,
            'nonOperatingIncome'  => $nonOperatingIncome,
            'nonOperatingExpenses' => $nonOperatingExpenses,
            'cost' => $cost,
            'title' => $title,
        ]);
    }
}
