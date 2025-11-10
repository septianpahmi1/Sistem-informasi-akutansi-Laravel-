<?php

namespace App\Http\Controllers\Reports;

use App\Exports\CashflowExport;
use Carbon\Carbon;
use App\Models\Dapur;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AruskasController extends Controller
{
    public function index()
    {
        $title = "Laporan Arus Kas";
        $dapur1 = Dapur::orderBy('created_at', 'asc')
            ->get();
        return view('admin.reports.cashflow', compact('title', 'dapur1'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'dapur_id'   => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);
        $dapur1 = Dapur::orderBy('created_at', 'asc')
            ->get();
        $dapur = Dapur::where('id', $request->dapur_id)->first();
        $title = "Laporan Arus Kas";
        $periodStart = Carbon::parse($request->start_date)->startOfDay();
        $periodEnd   = Carbon::parse($request->end_date)->endOfDay();

        $entries = JournalEntry::with('account')
            ->whereHas('journal', function ($q) use ($periodStart, $periodEnd, $request) {
                $q->whereBetween('date', [$periodStart, $periodEnd])
                    ->where('dapur_id', $request->dapur_id);
            })
            ->get();

        // Aktivitas Operasi: income & expense, tapi HPP (harga pokok) dikecualikan
        $operatingActivities = $entries
            ->filter(
                fn($e) =>
                in_array($e->account->type, ['income', 'expense']) &&
                    !str_contains(strtolower($e->account->name), 'pokok')
            )
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total,
            ])
            ->values()
            ->toArray();

        // Aktivitas Investasi: aset tetap selain Kas/Bank
        $investingActivities = $entries
            ->filter(
                fn($e) =>
                $e->account->type === 'asset' &&
                    !in_array($e->account->name, ['Kas', 'Bank'])
            )
            ->map(fn($e) => [
                'description' => $e->journal->description,
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])
            ->values()
            ->toArray();

        // Aktivitas Pendanaan: liability & equity
        $financingActivities = $entries
            ->filter(
                fn($e) =>
                in_array($e->account->type, ['liability', 'equity']) &&
                    !str_contains(strtolower($e->account->name), 'pokok')
            )
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])
            ->values()
            ->toArray();

        $totalOperating = array_sum(array_column($operatingActivities, 'amount'));
        $totalInvesting = array_sum(array_column($investingActivities, 'amount'));
        $totalFinancing = array_sum(array_column($financingActivities, 'amount'));

        return view('admin.reports.export.cashflow', compact(
            'periodStart',
            'periodEnd',
            'operatingActivities',
            'investingActivities',
            'financingActivities',
            'totalOperating',
            'totalInvesting',
            'totalFinancing',
            'title',
            'dapur',
            'dapur1',
        ));
    }

    public function getDataPrint(Request $request)
    {
        $request->validate([
            'dapur_id'   => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);
        $dapur1 = Dapur::orderBy('created_at', 'asc')
            ->get();
        $dapur = Dapur::where('id', $request->dapur_id)->first();
        $title = "Laporan Arus Kas";
        $periodStart = Carbon::parse($request->start_date)->startOfDay();
        $periodEnd   = Carbon::parse($request->end_date)->endOfDay();

        $entries = JournalEntry::with('account')
            ->whereHas('journal', function ($q) use ($periodStart, $periodEnd, $request) {
                $q->whereBetween('date', [$periodStart, $periodEnd])
                    ->where('dapur_id', $request->dapur_id);
            })
            ->get();

        // Aktivitas Operasi: income & expense, tapi HPP (harga pokok) dikecualikan
        $operatingActivities = $entries
            ->filter(
                fn($e) =>
                in_array($e->account->type, ['income', 'expense']) &&
                    !str_contains(strtolower($e->account->name), 'pokok')
            )
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total,
            ])
            ->values()
            ->toArray();

        // Aktivitas Investasi: aset tetap selain Kas/Bank
        $investingActivities = $entries
            ->filter(
                fn($e) =>
                $e->account->type === 'asset' &&
                    !in_array($e->account->name, ['Kas', 'Bank'])
            )
            ->map(fn($e) => [
                'description' => $e->journal->description,
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])
            ->values()
            ->toArray();

        // Aktivitas Pendanaan: liability & equity
        $financingActivities = $entries
            ->filter(
                fn($e) =>
                in_array($e->account->type, ['liability', 'equity']) &&
                    !str_contains(strtolower($e->account->name), 'pokok')
            )
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total,
            ])
            ->values()
            ->toArray();

        $totalOperating = array_sum(array_column($operatingActivities, 'amount'));
        $totalInvesting = array_sum(array_column($investingActivities, 'amount'));
        $totalFinancing = array_sum(array_column($financingActivities, 'amount'));

        return view('admin.reports.printable.cashflow', compact(
            'periodStart',
            'periodEnd',
            'operatingActivities',
            'investingActivities',
            'financingActivities',
            'totalOperating',
            'totalInvesting',
            'totalFinancing',
            'title',
            'dapur',
            'dapur1',
        ));
    }

    public function getDataPDF(Request $request)
    {
        $data = $this->getData($request);
        if ($data instanceof \Illuminate\Http\RedirectResponse) return $data;

        $pdf = PDF::loadView('admin.reports.pdf.cashflow', $data->getData())->setPaper('a4');
        return $pdf->download('Laporan_Aruskas.pdf');
    }

    public function getDataXls(Request $request)
    {
        return Excel::download(new CashflowExport($request), 'Laporan_Aruskas.xlsx');
    }
}
