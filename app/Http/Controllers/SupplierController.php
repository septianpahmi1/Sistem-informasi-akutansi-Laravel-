<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $title = "Supplier";
        $data = Supplier::all();
        return view('admin.supplier.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = Supplier::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Supplier berhasil dihapus.');
    }

    public function post(Request $request)
    {

        $emailExist = Supplier::where('email', $request->email)->exists();
        $phoneExist = Supplier::where('phone', $request->phone)->exists();
        if ($emailExist) {
            return redirect()->back()->with('error', 'Supplier dengan email' . ' ' . $request->email . ' ' . 'sudah terdaftar.');
        }
        if ($phoneExist) {
            return redirect()->back()->with('error', 'Supplier dengan no. Telp' . ' ' . $request->phone . ' ' . 'sudah terdaftar.');
        }

        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Supplier berhasil didaftarkan.');
    }

    public function update(Request $request, $id)
    {
        $data = Supplier::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect()->back()->with('success', 'Supplier berhasil didaftarkan.');
    }
}
