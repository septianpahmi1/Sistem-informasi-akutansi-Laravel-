<?php

namespace App\Http\Controllers;

use App\Models\Dapur;
use Illuminate\Http\Request;

class DapurController extends Controller
{
    public function index()
    {
        $title = "Data Dapur";
        $data = Dapur::orderBy('created_at', 'asc')
            ->get();

        return view('admin.dapur.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = Dapur::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function post(Request $request)
    {
        $exitingName = Dapur::where('name', $request->name)->exists();
        if ($exitingName) {
            return redirect()->back()->with('error', 'Data berhasil sudah ada.');
        }
        Dapur::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('success', 'Data berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $data = Dapur::find($id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }
}
