<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $title = "Account";
        $data = Account::all();
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
        $data = Account::find($id);
        $data->code = $request->code;
        $data->name = $request->name;
        $data->type = $request->type;
        $data->opening_balance = $request->opening_balance;
        $data->save();
        return redirect()->back()->with('success', 'Akun berhasil didaftarkan.');
    }
}
