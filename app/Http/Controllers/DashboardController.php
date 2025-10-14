<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Purchase;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $debitTotal = JournalEntry::where('type', 'debit')->sum('total');
        $creditTotal = JournalEntry::where('type', 'credit')->sum('total');
        $salesTotal = Sales::where('status', 'paid')->sum('total');
        $purchaseTotal = Purchase::where('status', 'paid')->sum('total');
        return view('admin.index', compact('title', 'debitTotal', 'creditTotal', 'salesTotal', 'purchaseTotal'));
    }
}
