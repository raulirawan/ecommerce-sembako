<?php

namespace App\Http\Controllers\Owner;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = User::where('roles','KURIR')->get();
        return view('owner.kurir.index', compact('kurir'));
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
        $data->name = $request->nama_kurir;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->password = bcrypt($request->password);
        $data->roles = 'KURIR';
        $data->save();

        if($data != null) {
            return redirect()->route('owner.kurir.index')->with('success','Data Berhasil di Tambah');
        } else {
            return redirect()->route('owner.kurir.index')->with('error','Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_kurir;
        $data->no_hp = $request->no_hp;
        $data->save();

        if($data != null) {
            return redirect()->route('owner.kurir.index')->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('owner.kurir.index')->with('error','Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if($data != null) {
            $data->delete();
            return redirect()->route('owner.kurir.index')->with('success','Data Berhasil di Hapus');
        } else {
            return redirect()->route('owner.kurir.index')->with('error','Data Gagal di Hapus');
        }
    }
}
