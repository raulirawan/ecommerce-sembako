<?php

namespace App\Http\Controllers\Owner;

use App\Produk;
use App\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::all();
        return view('owner.produk.index', compact('produk'));
    }

    public function store(Request $request)
    {
        $data = new Produk();
        $data->nama_produk = $request->nama_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->kategori_id = $request->kategori_id;
        $data->deskripsi = $request->deskripsi;
        $dataHarga = [];
        foreach ($request->harga as $key => $harga) {
            $dataHarga[] = [
                'keterangan' => $request->keterangan[$key],
                'stok' => $request->stok[$key],
                'harga' => $harga,
            ];
        }
        $harga = json_encode($dataHarga);
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/produk/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload, $nama_file);

            $data->gambar = $tujuan_upload . $nama_file;
        }
        $data->harga = $harga;
        $data->save();

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                return redirect()->route('owner.produk.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('owner.produk.index')->with('error', 'Data Gagal di Tambah');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.produk.index')->with('success', 'Data Berhasil di Tambah');
            } else {
                return redirect()->route('admin.produk.index')->with('error', 'Data Gagal di Tambah');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $data = Produk::findOrFail($id);

        $data->nama_produk = $request->nama_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->kategori_id = $request->kategori_id;
        $data->deskripsi = $request->deskripsi;

        $dataHarga = [];
        foreach ($request->harga as $key => $harga) {
            $dataHarga[] = [
                'keterangan' => $request->keterangan[$key],
                'stok' => $request->stok[$key],
                'harga' => $harga,
            ];
        }

        $harga = json_encode($dataHarga);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/produk/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload, $nama_file);
            if (file_exists($data->gambar)) {
                unlink($data->gambar);
            }
            $data->gambar = $tujuan_upload . $nama_file;
        }
        $data->harga = $harga;
        $data->save();

        if (Auth::user()->roles == 'OWNER') {
            if ($data != null) {
                return redirect()->route('owner.produk.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('owner.produk.index')->with('error', 'Data Gagal di Update');
            }
        } else {
            if ($data != null) {
                return redirect()->route('admin.produk.index')->with('success', 'Data Berhasil di Update');
            } else {
                return redirect()->route('admin.produk.index')->with('error', 'Data Gagal di Update');
            }
        }
    }

    public function delete($id)
    {
        $data = Produk::findOrFail($id);

        if (Auth::user()->roles == 'OWNER') {

            $kategori_id = $data->kategori_id;
            if ($data != null) {
                if (file_exists($data->gambar)) {
                    unlink($data->gambar);
                }
                $data->delete();
                return redirect()->route('owner.produk.index', $kategori_id)->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('owner.produk.index', $kategori_id)->with('error', 'Data Gagal di Hapus');
            }
        }else {
            $kategori_id = $data->kategori_id;
            if ($data != null) {
                if (file_exists($data->gambar)) {
                    unlink($data->gambar);
                }
                $data->delete();
                return redirect()->route('admin.produk.index', $kategori_id)->with('success', 'Data Berhasil di Hapus');
            } else {
                return redirect()->route('admin.produk.index', $kategori_id)->with('error', 'Data Gagal di Hapus');
            }
        }
    }
}
