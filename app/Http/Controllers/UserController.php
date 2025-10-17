<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $title = "Data Pengguna";
        $data = User::all();
        return view('admin.users.index', compact('title', 'data'));
    }

    public function delete($id)
    {
        $data = User::find($id);
        if ($data->id == Auth::id()) {
            return redirect()->back()->with('error', 'Saat ini anda tidak bisa menghapus akun anda sendiri');
        }
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus pengguna.');
    }

    public function post(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Bendahara',
        ]);

        $emailExist = User::where('email', $request->email)->exists();
        if ($emailExist) {
            return redirect()->back()->with('error', 'Pengguna dengan email' . ' ' . $request->email . ' ' . 'sudah terdaftar.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Berhasil membuat pengguna baru.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Bendahara',
        ]);

        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->role = $request->role;
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil diperbaharui.');
    }
}
