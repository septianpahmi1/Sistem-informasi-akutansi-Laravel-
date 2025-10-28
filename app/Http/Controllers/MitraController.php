<?php

namespace App\Http\Controllers;

use App\Models\Dapur;
use App\Models\investor;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $title = "Investor/ Mitra";
        $data = investor::all();
        $dapur = Dapur::orderBy('created_at', 'asc')
            ->get();
        return view('admin.mitra.index', compact('title', 'data', 'dapur'));
    }

    public function delete($id)
    {
        $data = investor::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function post(Request $request)
    {
        $totalPercentage = Investor::where('dapur_id', $request->dapur_id)->sum('percentage') + $request->percentage;

        if ($totalPercentage > 100) {
            return redirect()->back()->with('error', 'Jumlah persentase melebihi 100%.');
        }
        investor::create([
            'name' => $request->name,
            'dapur_id' => $request->dapur_id,
            'percentage' => $request->percentage,
        ]);

        return redirect()->back()->with('success', 'Data berhasil didaftarkan.');
    }

    public function update(Request $request, $id)
    {
        $totalPercentage = Investor::where('dapur_id', $request->dapur_id)->sum('percentage') + $request->percentage;

        if ($totalPercentage > 100) {
            return redirect()->back()->with('error', 'Jumlah persentase melebihi 100%.');
        }
        $data = investor::find($id);
        $data->name = $request->name;
        $data->dapur_id = $request->dapur_id;
        $data->percentage = $request->percentage;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil didaftarkan.');
    }
}
