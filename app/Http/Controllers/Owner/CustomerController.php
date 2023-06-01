<?php

namespace App\Http\Controllers\Owner;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = User::where('roles', 'CUSTOMER')->get();
        return view('owner.customer.index', compact('customer'));
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
        $data->name = $request->nama_customer;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->password = bcrypt($request->password);
        $data->save();

        if (Auth::user()->roles == 'OWNER') {

            if ($data != null) {
                return redirect()->route('owner.customer.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('owner.customer.index')->with('error', 'Data Gagal di Tambah');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.customer.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('admin.customer.index')->with('error', 'Data Gagal di Tambah');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_customer;
        $data->no_hp = $request->no_hp;
        $data->save();

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                return redirect()->route('owner.customer.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('owner.customer.index')->with('error', 'Data Gagal di Update');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.customer.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('admin.customer.index')->with('error', 'Data Gagal di Update');
            }
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                $data->delete();
                return redirect()->route('owner.customer.index')->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('owner.customer.index')->with('error', 'Data Gagal di Hapus');
            }
        } else {
            if ($data != null) {
                $data->delete();
                return redirect()->route('admin.customer.index')->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('admin.customer.index')->with('error', 'Data Gagal di Hapus');
            }
        }
    }
}
