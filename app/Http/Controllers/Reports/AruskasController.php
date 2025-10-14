<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AruskasController extends Controller
{
    public function index()
    {
        $title = "Laporan Arus Kas";
        return view('admin.reports.cashflow', compact('title'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);
        $title = "Laporan Arus Kas";
        $periodStart = Carbon::parse($request->start_date)->startOfDay();
        $periodEnd   = Carbon::parse($request->end_date)->endOfDay();

        $entries = JournalEntry::with('account')
            ->whereHas('journal', fn($q) => $q->whereBetween('date', [$periodStart, $periodEnd]))
            ->get();

        // Aktivitas Operasi: akun tipe income & expense yang terkait operasional
        $operatingActivities = $entries->filter(fn($e) => in_array($e->account->type, ['income', 'expense']))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? $e->total : -$e->total
            ])->values()->toArray();

        // Aktivitas Investasi: akun asset tetap (misal 'Peralatan', 'Gedung', dsb)
        $investingActivities = $entries->filter(fn($e) => $e->account->type === 'asset' && !in_array($e->account->name, ['Kas', 'Bank']))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total
            ])->values()->toArray();

        // Aktivitas Pendanaan: liability & equity
        $financingActivities = $entries->filter(fn($e) => in_array($e->account->type, ['liability', 'equity']))
            ->map(fn($e) => [
                'name' => $e->account->name,
                'amount' => $e->type === 'debit' ? -$e->total : $e->total
            ])->values()->toArray();

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
        ));
    }
}
