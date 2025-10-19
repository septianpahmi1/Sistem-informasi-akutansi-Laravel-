<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\SupplyIn;
use App\Models\SupplyOut;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $title = "Persediaan";
        $data = Inventory::orderBy('created_at', 'asc')->get();

        return view('admin.inventory.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = "Buat Persediaan";
        return view('admin.inventory.create', compact('title'));
    }

    public function post(Request $request)
    {
        $codeExist = Inventory::where('code', $request->code)->exists();
        if ($codeExist) {
            return redirect()->back()->with('error', 'Barang dengan kode' . ' ' . $request->code . ' ' . 'Sudah terdaftar');
        }

        $inventory = Inventory::create([
            'code' => $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
        ]);
        SupplyIn::create([
            'inventory_id' => $inventory->id,
            'date' => $request->date,
            'unit' => $request->unit,
            'proof_number' => $request->proof_number,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->total,
        ]);
        if ($request->filled('dateout') && $request->filled('proof_numberout') && $request->filled('qtyout')) {
            SupplyOut::create([
                'inventory_id' => $inventory->id,
                'date' => $request->dateout,
                'unit' => $request->unit,
                'proof_number' => $request->proof_numberout,
                'qty' => $request->qtyout,
                'price' => $request->priceout ?? 0,
                'total' => ($request->qtyout ?? 0) * ($request->priceout ?? 0),
            ]);
        }
        return redirect('inventory')->with('success', 'Persediaan berhasil ditambahkan.');
    }
}
