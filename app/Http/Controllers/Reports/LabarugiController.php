<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\investor;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabarugiController extends Controller
{
    public function index()
    {
        $title = "Laporan Laba Rugi";
        return view('admin.reports.labarugi', compact('title'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);
        $title = "Laporan Laba Rugi";
        $periodStart = Carbon::parse($request->start_date)->startOfDay();
        $periodEnd   = Carbon::parse($request->end_date)->endOfDay();

        // Ambil semua journal entries dalam periode
        $entries = JournalEntry::with('account')
            ->whereHas('journal', function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('created_at', [$periodStart, $periodEnd]);
            })
            ->get();

        // Pisahkan berdasarkan tipe akun untuk Laba/Rugi
        $revenues = $entries->filter(fn($e) => $e->account->type === 'income')
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])->values()->toArray();

        $cogs = $entries->filter(
            fn($e) =>
            str_contains(strtolower($e->account->name), 'pokok') ||
                str_contains(strtolower($e->account->name), 'harga pokok')
        )->map(fn($e) => [
            'name' => $e->account->name,
            'amount' => $e->type === 'debit' ? $e->total : -$e->total,
        ])->values()->toArray();

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

        $investors = investor::all();
        if ($investors == null) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        return view('admin.reports.printable.laba', [
            'companyName' => 'KOPERASI CIPTA USAHA SENTOSA',
            'companyAddress' => 'Jl. Pd. Bambu Kuning No.8, RT.3/RW.4, Bojong Baru, Kecamatan Bojonggede, Kabupaten Bogor, Jawa Barat 16920',
            'periodStart' => $periodStart,
            'periodEnd'   => $periodEnd,
            'currency'    => 'Indonesian Rupiah',

            'revenues'            => $revenues,
            'cogs'                => $cogs,
            'operationalExpenses' => $operationalExpenses,
            'nonOperatingIncome'  => $nonOperatingIncome,
            'nonOperatingExpenses' => $nonOperatingExpenses,
            'investors' => $investors,
            'title' => $title,
        ]);
    }
}
