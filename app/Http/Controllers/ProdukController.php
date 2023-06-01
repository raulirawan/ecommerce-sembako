<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Kategori;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ProdukController extends Controller
{
    public function detail($slug)
    {
        $produk = Produk::where('slug', $slug)->first();
        // $produk = Kategori::with(['produk'])->has('produk')->where('slug',$slug)->first();
        return view('product', compact('produk'));
    }

    public function search(Request $request)
    {
        // $produk = Kategori::with(['produk'])->whereHas('produk', function($item) use ($request){
        //     $item->where('nama_produk', 'like', '%' . $request->input('nama_produk') . '%');
        // })->get();
        $produk = Produk::where('nama_produk', 'like', '%' . $request->input('nama_produk') . '%')->get();

        return view('search', compact('produk'));
    }
}
