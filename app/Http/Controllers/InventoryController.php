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
        $data = Inventory::orderBy('date', 'asc')->get();

        return view('admin.inventory.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = "Buat Persediaan";
        return view('admin.inventory.create', compact('title'));
    }
    public function update($id)
    {
        $title = "Update Persediaan";
        $data = Inventory::find($id);
        return view('admin.inventory.update', compact('title', 'data'));
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
            'date' => $request->date,
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
    
    public function updatepost(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
    
    
        $priceIn = str_replace(['Rp', ' ', '.'], '', $request->price);
        $totalIn = str_replace(['Rp', ' ', '.'], '', $request->total);
        $priceOut = str_replace(['Rp', ' ', '.'], '', $request->priceout ?? 0);
        $totalOut = str_replace(['Rp', ' ', '.'], '', $request->totalout ?? 0);
    
        $inventory->update([
            'code' => $request->code,
            'name' => $request->name,
            'date' => $request->date,
        ]);
    
        // --- Update atau buat ulang Persediaan Masuk ---
        $stockIn = $inventory->stockIn()->first();
        if ($stockIn) {
            $stockIn->update([
                'qty' => $request->qty,
                'price' => $priceIn,
                'total' => $totalIn,
                'unit' => $request->unit,
            ]);
        } else {
            $inventory->stockIn()->create([
                'qty' => $request->qty,
                'price' => $priceIn,
                'total' => $totalIn,
                'unit' => $request->unit,
            ]);
        }
    
        $totalQtyIn = $inventory->stockIn()->sum('qty');
        $totalQtyOut = $request->qtyout ?? 0;
    
        if ($totalQtyOut > $totalQtyIn) {
            return redirect()->back()->with('error', 'Jumlah keluar tidak boleh melebihi jumlah masuk.');
        }
    
        $stockOut = $inventory->stockOut()->first();
        if ($stockOut) {
            $stockOut->update([
                'qty' => $totalQtyOut,
                'price' => $priceOut,
                'total' => $totalOut,
                'unit' => $request->unitout ?? $inventory->unit,
            ]);
        } elseif ($totalQtyOut > 0) {
            $inventory->stockOut()->create([
                'qty' => $totalQtyOut,
                'price' => $priceOut,
                'total' => $totalOut,
                'unit' => $request->unitout ?? $inventory->unit,
            ]);
        }
    
        return redirect()->route('inventory')->with('success', 'Data persediaan berhasil diperbarui.');
    }


    public function invout(Request $request, $id)
    {
        $data = Inventory::find($id);

        $totalIn = SupplyIn::where('inventory_id', $id)->sum('qty');
        $totalOut = SupplyOut::where('inventory_id', $id)->sum('qty');

        $sisa = $totalIn - $totalOut;
        if ($request->qtyout > $sisa) {
            return redirect()->back()->with([
                'error' => 'Jumlah keluar melebihi stok tersedia (' . $sisa . ').'
            ]);
        }
        $request['priceout'] = str_replace(['Rp ', '.'], '', $request['priceout']);
        $request['totalout'] = str_replace(['Rp ', '.'], '', $request['totalout']);

        SupplyOut::create([
            'inventory_id' => $data->id,
            // 'date' => $request->dateout,
            'unit' => $request->unit,
            'proof_number' => $request->proof_numberout,
            'qty' => $request->qtyout,
            'price' => $request->priceout,
            'total' => $request->priceout * $request->qtyout,
        ]);

        return redirect('inventory')->with('success', 'Persediaan keluar berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $data = Inventory::find($id);
        $data->delete();
        return redirect('inventory')->with('success', 'Persediaan berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = Inventory::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        if ($request->ajax()) {
            return view('admin.inventory._table', compact('data'))->render();
        }

        return view('admin.inventory.index', [
            'title' => 'Persediaan',
            'data' => $data,
        ]);
    }
}
