<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalController extends Controller
{
    public function index()
    {
        $title = "Laporan Journal Umum";
        return view('admin.reports.journal', compact('title'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ]);
        $title = "Laporan Journal Umum";
        $start = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
        $end   = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

        $journals = Journal::with(['entries' => function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }, 'entries.account'])->get();
        return view('admin.reports.printable.journal', compact('journals', 'start', 'end', 'title'));
    }
}
