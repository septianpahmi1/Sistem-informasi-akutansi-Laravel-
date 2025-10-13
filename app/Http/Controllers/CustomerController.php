<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $title = "Customer";
        $data = Customer::all();
        return view('admin.customer.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = Customer::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Customer berhasil dihapus.');
    }

    public function post(Request $request)
    {

        $emailExist = Customer::where('email', $request->email)->exists();
        $phoneExist = Customer::where('phone', $request->phone)->exists();
        if ($emailExist) {
            return redirect()->back()->with('error', 'Customer dengan email' . ' ' . $request->email . ' ' . 'sudah terdaftar.');
        }
        if ($phoneExist) {
            return redirect()->back()->with('error', 'Customer dengan no. Telp' . ' ' . $request->phone . ' ' . 'sudah terdaftar.');
        }

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Customer berhasil didaftarkan.');
    }

    public function update(Request $request, $id)
    {
        $data = Customer::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect()->back()->with('success', 'Customer berhasil didaftarkan.');
    }
}
