<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index()
    {
        $title = "Account";
        $data = Account::orderBy('code', 'asc')
            ->get();
        return view('admin.account.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = Account::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }

    public function post(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
        ]);

        $dataExist = Account::where('code', $request->code)->exists();
        if ($dataExist) {
            return redirect()->back()->with('error', 'Akun dengan code' . ' ' . $request->code . ' ' . 'sudah terdaftar.');
        }

        Account::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'opening_balance' => $request->opening_balance
        ]);

        return redirect()->back()->with('success', 'Akun berhasil didaftarkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
        ]);
        $totalOut = str_replace(['Rp', ' ', '.'], '', $request->opening_balance ?? 0);
        $data = Account::find($id);
        $data->code = $request->code;
        $data->name = $request->name;
        $data->type = $request->type;
        $data->opening_balance = $totalOut;
        $data->save();
        return redirect()->back()->with('success', 'Akun berhasil didaftarkan.');
    }


    public function getData(Request $request)
    {
        $start = $request->input('start_date', date('Y-m-d'));
        $end = $request->input('end_date', date('Y-m-d'));

        $data = Account::with(['journalEntries' => function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        }])->orderBy('code', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total_debit', function ($item) {
                $total = $item->journalEntries->where('type', 'debit')->sum('total');
                return 'Rp. ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('total_credit', function ($item) {
                $total = $item->journalEntries->where('type', 'credit')->sum('total');
                return 'Rp. ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('total', function ($item) {
                $debit = $item->journalEntries->where('type', 'debit')->sum('total');
                $credit = $item->journalEntries->where('type', 'credit')->sum('total');
                $total = $debit - $credit;
                return 'Rp. ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('opening_balance', function ($item) {
                return 'Rp. ' . number_format($item->opening_balance, 0, ',', '.');
            })
            ->addColumn('action', function ($item) {
                return '
                <div class="btn-group btn-block">
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#account' . $item->id . '">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button url="' . route('account.delete', $item->id) . '" type="button" class="btn btn-sm btn-danger delete" data-id="' . $item->id . '">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
