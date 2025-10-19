<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Journal;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $data = Journal::orderByDesc('created_at')->get();

        $title = "Journal";
        return view('admin.journal.index', compact('data', 'title'));
    }

    public function detail()
    {
        $data = Journal::orderByDesc('date')->get();
        $debitTotal = JournalEntry::where('type', 'debit')->sum('total');
        $creditTotal = JournalEntry::where('type', 'credit')->sum('total');
        $title = "Daftar Journal";
        return view('admin.journal.entries.index', compact('data', 'title', 'debitTotal', 'creditTotal'));
    }

    public function detailJournal($id)
    {
        $journal = Journal::find($id);
        $title = "Detail Journal";
        return view('admin.journal.detail', compact('journal', 'title'));
    }

    public function create()
    {
        $title = "Buat Journal Baru";
        $akun = Account::orderBy('code', 'asc')
            ->get();
        return view('admin.journal.create', compact('akun', 'title'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:150',
            'date' => 'required|date',
            // 'account_id' => 'required|array|min:2',
            // 'account_id.*' => 'exists:accounts,id',
            // 'type' => 'required|array',
            // 'type.*' => 'in:debit,kredit',
            // 'price' => 'required|array',
            // 'price.*' => 'numeric|min:0',
            // 'qty' => 'required|array',
            // 'qty.*' => 'integer|min:1',
            // 'total' => 'required|array',
            // 'total.*' => 'numeric|min:0',
        ]);

        $journal = Journal::create([
            'description' => $request->description,
            'date' => $request->date,
        ]);

        foreach ($request->account_id as $index => $accountId) {
            JournalEntry::create([
                'journal_id' => $journal->id,
                'account_id' => $accountId,
                'date' => $journal->date,
                'type' => $request->type[$index],
                'price' => str_replace(['Rp', '.', ' '], '', $request->price[$index]),
                'qty' => $request->qty[$index],
                'unit' => $request->unit[$index],
                'total' => str_replace(['Rp', '.', ' '], '', $request->total[$index]),
            ]);
        }

        return redirect('journal')->with('success', 'Journal berhasil dibuat.');
    }

    public function update($id)
    {
        $title = "Update Journal";
        $data = Journal::find($id);
        $akun = Account::orderBy('code', 'asc')
            ->get();
        return view('admin.journal.update', compact('data', 'akun', 'title'));
    }

    public function updatepost(Request $request, $id)
    {
        $request->validate([
            'description'   => 'required|string|max:150',
            'date'          => 'required|date',
        ]);

        $journal = Journal::findOrFail($id);

        $journal->update([
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        JournalEntry::where('journal_id', $journal->id)->delete();

        foreach ($request->account_id as $key => $accountId) {
            JournalEntry::create([
                'journal_id' => $journal->id,
                'account_id' => $accountId,
                'date' => $journal->date,
                'type'       => $request->type[$key],
                'price'      => $request->price[$key],
                'qty'        => $request->qty[$key],
                'qty'        => $request->unit[$key],
                'total'      => $request->total[$key],
            ]);
        }
        return redirect('journal')->with('success', 'Journal berhasil diperbarui.');
    }

    public function delete($id)
    {
        $data = Journal::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data penjualan berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = \App\Models\Journal::with('entries.account')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        if ($request->ajax()) {
            return view('admin.journal.entries._table', compact('data'))->render();
        }

        return view('admin.journal.entries.index', [
            'title' => 'Jurnal Umum',
            'data' => $data,
        ]);
    }
}
