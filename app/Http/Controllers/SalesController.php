<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $title = "Faktur Penjualan";
        $data = Sales::all();
        return view('admin.sales.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = "Buat Faktur Penjualan";
        $data = Customer::all();
        return view('admin.sales.create', compact('data', 'title'));
    }

    public function update($id)
    {
        $title = "Update Faktur Penjualan";
        $data = Sales::find($id);
        $customer = Customer::all();
        return view('admin.sales.update', compact('data', 'customer', 'title'));
    }

    public function updatepost(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'ket' => 'required|string|max:150',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:draft,paid,overdue',
        ]);

        $validated['price'] = str_replace('.', '', $validated['price']);
        $validated['total'] = str_replace('.', '', $validated['total']);

        $sales = Sales::findOrFail($id);
        $sales->update($validated);

        return redirect('sales')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $data = Sales::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data penjualan berhasil dihapus.');
    }
}
