<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kurir.dashboard');
    }

    public function kirim(Request $request, $transaksi_id)
    {
        $request->validate(
            [
                'bukti_pengiriman' => 'required|mimes:png,jpg,bmp,jpeg'
            ],
            [
                'bukti_pengiriman.mimes' => 'Gambar Harus Bertipe png,jpg,bmp,jpeg',
            ]
        );
        $transaksi = Transaksi::find($transaksi_id);
        if ($request->hasFile('bukti_pengiriman')) {
            $file = $request->file('bukti_pengiriman');
            $tujuan_upload = 'image/bukti-pengiriman/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload, $nama_file);

            $transaksi->bukti_pengiriman = $tujuan_upload . $nama_file;
            $transaksi->status = 'SELESAI';
            $transaksi->save();

            if ($transaksi) {
                return redirect()->route('kurir.dashboard.index')->with('success', 'Data Berhasil di Kirim');
            } else {
                return redirect()->route('kurir.dashboard.index')->with('error', 'Data Gagal di Kirim, Coba Lagi!');
            }
        } else {
            return redirect()->route('kurir.dashboard.index')->with('error', 'Data Gagal di Kirim, Coba Lagi!');
        }
    }
}
