<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id);
        $carts = $carts->get();
        $total = $carts->sum('total_harga');
        return view('cart', compact('carts', 'total'));
    }
    public function addCart(Request $request, $id, $variant)
    {
        $produk = Produk::where('id', $id)->first();
        $dataHarga = json_decode($produk->harga, true);

        $dataHarga = collect($dataHarga)->where('keterangan', $variant)->first();

        $harga = intval($dataHarga['harga']);
        $stok =  intval($dataHarga['stok']);

        if ($stok < $request->qty) {
            return redirect()->back()->with('error', 'Stok Barang Tidak Cukup!');
        }

        $cart = new Cart();
        $dataCart = Cart::where('produk_id', $id)->where('user_id', Auth::user()->id)->where('variant', $variant)->first();

        if ($dataCart != null) {
            if ($dataCart->variant == $variant) {
                $dataCart->total_harga = $dataCart->total_harga + $harga * $request->qty;
                $dataCart->qty = $dataCart->qty + $request->qty;
                $dataCart->save();
            } else {
                $cart->produk_id = $id;
                $cart->harga = $harga;
                $cart->total_harga = $harga * $request->qty;
                $cart->user_id = Auth::user()->id;
                $cart->qty = $request->qty;
                $cart->variant = $variant;
                $cart->save();
            }
        } else {
            $cart->produk_id = $id;
            $cart->harga = $harga;
            $cart->total_harga = $harga * $request->qty;
            $cart->user_id = Auth::user()->id;
            $cart->qty = $request->qty;
            $cart->variant = $variant;
            $cart->save();
        }

        if ($cart != null || $dataCart != null) {
            return redirect()->route('cart.index')->with('success', 'Data Cart Berhasil Di Tambahkan');
        } else {
            return redirect()->back()->with('error', 'Data Cart Gagal Di Tambahkan');
        }
    }

    public function delete($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart != null) {
            $cart->delete();
            return redirect()->route('cart.index')->with('success', 'Data Cart Berhasil Di Hapus');
        } else {
            return redirect()->route('cart.index')->with('success', 'Data Cart Gagal Di Hapus');
        }
    }
}
