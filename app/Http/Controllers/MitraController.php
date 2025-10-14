<?php

namespace App\Http\Controllers;

use App\Models\investor;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $title = "Investor/ Mitra";
        $data = investor::all();
        return view('admin.mitra.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = investor::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function post(Request $request)
    {
        $totalPercentage = Investor::sum('percentage') + $request->percentage;

        if ($totalPercentage > 100) {
            return redirect()->back()->with('error', 'Jumlah persentase investor melebihi 100%.');
        }
        investor::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);

        return redirect()->back()->with('success', 'Data berhasil didaftarkan.');
    }

    public function update(Request $request, $id)
    {
        $totalPercentage = Investor::sum('percentage') + $request->percentage;

        if ($totalPercentage > 100) {
            return redirect()->back()->with('error', 'Jumlah persentase investor melebihi 100%.');
        }
        $data = investor::find($id);
        $data->name = $request->name;
        $data->percentage = $request->percentage;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil didaftarkan.');
    }
}
