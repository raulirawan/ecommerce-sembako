<?php

namespace App\Http\Controllers\Owner;

use App\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('owner.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = new Kategori();
        $data->nama_kategori = $request->nama_kategori;
        $data->slug = Str::slug($request->nama_kategori);
        $data->save();

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                return redirect()->route('owner.kategori.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('owner.kategori.index')->with('error', 'Data Gagal di Tambah');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.kategori.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('admin.kategori.index')->with('error', 'Data Gagal di Tambah');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $data = Kategori::findOrFail($id);

        $data->nama_kategori = $request->nama_kategori;
        $data->slug = Str::slug($request->nama_kategori);
        $data->save();

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                return redirect()->route('owner.kategori.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('owner.kategori.index')->with('error', 'Data Gagal di Update');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.kategori.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('admin.kategori.index')->with('error', 'Data Gagal di Update');
            }
        }
    }

    public function delete($id)
    {
        $data = Kategori::findOrFail($id);

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                $data->delete();
                return redirect()->route('owner.kategori.index')->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('owner.kategori.index')->with('error', 'Data Gagal di Hapus');
            }
        }else {
            if ($data != null) {
                $data->delete();
                return redirect()->route('admin.kategori.index')->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('admin.kategori.index')->with('error', 'Data Gagal di Hapus');
            }
        }
    }
}
