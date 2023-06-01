<?php

namespace App\Http\Controllers;

use App\Transaksi;
use App\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('transaksi', compact('transaksi'));
    }

    public function detail($id)
    {
        $transaksi = TransaksiDetail::with(['produk','transaksi'])->where('transaksi_id', $id)->get();
        return response()->json($transaksi);

    }
}
