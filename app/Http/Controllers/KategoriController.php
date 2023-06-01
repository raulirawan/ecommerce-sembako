<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Produk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index($slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        $produk = Produk::where('kategori_id', $kategori->id)->get();
        return view('kategori', compact('produk','kategori'));
    }
}
