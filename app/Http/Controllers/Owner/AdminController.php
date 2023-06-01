<?php

namespace App\Http\Controllers\Owner;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('roles','ADMIN')->get();
        return view('owner.admin.index', compact('admin'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'unique:users,email'
            ],
            [
                'email.unique' => 'Email Sudah Terdaftar'
            ]
        );
        $data = new User();
        $data->name = $request->nama_admin;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->password = bcrypt($request->password);
        $data->roles = 'ADMIN';
        $data->save();

        if($data != null) {
            return redirect()->route('owner.admin.index')->with('success','Data Berhasil di Tambah');
        } else {
            return redirect()->route('owner.admin.index')->with('error','Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_admin;
        $data->no_hp = $request->no_hp;
        $data->save();

        if($data != null) {
            return redirect()->route('owner.admin.index')->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('owner.admin.index')->with('error','Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if($data != null) {
            $data->delete();
            return redirect()->route('owner.admin.index')->with('success','Data Berhasil di Hapus');
        } else {
            return redirect()->route('owner.admin.index')->with('error','Data Gagal di Hapus');
        }
    }
}
