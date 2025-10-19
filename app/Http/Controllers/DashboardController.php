<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Purchase;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $debitTotal = JournalEntry::where('type', 'debit')->sum('total');
        $creditTotal = JournalEntry::where('type', 'credit')->sum('total');
        $salesTotal = Sales::sum('total');
        $purchaseTotal = Purchase::sum('total');

        $chartData = DB::table('journal_entries')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw("SUM(CASE WHEN type = 'debit' THEN total ELSE 0 END) as total_debit"),
                DB::raw("SUM(CASE WHEN type = 'credit' THEN total ELSE 0 END) as total_kredit")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $debits = [];
        $credits = [];

        foreach ($chartData as $row) {
            $months[] = \Carbon\Carbon::create()->month($row->month)->format('M');
            $debits[] = $row->total_debit;
            $credits[] = $row->total_kredit;
        }
        return view('admin.index', compact('title', 'debitTotal', 'creditTotal', 'salesTotal', 'purchaseTotal', 'months', 'debits', 'credits'));
    }
}
