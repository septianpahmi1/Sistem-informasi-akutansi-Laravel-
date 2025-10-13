<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $title = "Faktur Pembelian";
        $data = Purchase::all();
        return view('admin.purchase.index', compact('data', 'title'));
    }

    public function create()
    {
        $title = "Buat Faktur Pembelian";
        $data = Supplier::all();
        return view('admin.purchase.create', compact('data', 'title'));
    }

    public function post(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
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

        Purchase::create($validated);

        return redirect('purchase')->with('success', 'Faktur penjualan berhasil dibuat.');
    }

    public function update($id)
    {
        $title = "Update Faktur Penjualan";
        $data = Purchase::find($id);
        $supplier = Supplier::all();
        return view('admin.purchase.update', compact('data', 'supplier', 'title'));
    }

    public function updatepost(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
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

        $sales = Purchase::findOrFail($id);
        $sales->update($validated);

        return redirect('sales')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $data = Purchase::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data penjualan berhasil dihapus.');
    }

    public function invoice($id)
    {
        $data = Purchase::findOrFail($id);
        return view('admin.purchase.invoice', compact('data'));
    }
}
