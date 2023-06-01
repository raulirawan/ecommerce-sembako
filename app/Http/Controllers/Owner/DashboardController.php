<?php

namespace App\Http\Controllers\Owner;

use App\User;
use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
            $pendapatan = Transaksi::where('status', 'SELESAI')->sum('harga');
            $pendapatan = intval($pendapatan);
            $produk = Produk::count();
            $success = Transaksi::where('status', 'SELESAI')->count();
            $customer = User::where('roles', 'CUSTOMER')->count();
            return view('owner.dashboard', compact('pendapatan', 'produk', 'success', 'customer'));
    }
}
