<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
          //set konfigurasi midtrans
          Config::$serverKey = config('services.midtrans.serverKey');
          Config::$isProduction = config('services.midtrans.isProduction');
          Config::$isSanitized = config('services.midtrans.isSanitized');
          Config::$is3ds = config('services.midtrans.is3ds');

          //buat instance midtrans
          $notification = new Notification();

          //assign ke variable untuk memudahkan coding

          $status = $notification->transaction_status;

          $transaction = Transaksi::with(['detail'])->where('kode', $notification->order_id)->first();
          // handler notification status midtrans
          if ($status == "settlement") {
              $transaction->status = 'SUDAH BAYAR';

              foreach ($transaction->detail as $key => $item) {
                  $produk = Produk::findOrFail($item->produk_id);

                  $dataHarga = json_decode($produk->harga, true);

                  $dataKey = 0;
                  foreach($dataHarga as $key => $harga) {
                    if($harga['keterangan'] == $item->variant) {
                        $dataKey = $key;
                    }
                  }
                //   $dataHarga = collect($dataHarga)->where('keterangan', $item->variant)->first();
                //   dd($dataHarga);
                  $harga = $dataHarga;
                  $harga[$dataKey]['stok'] = $dataHarga[$dataKey]['stok'] - $item->qty;
                  $produk->harga = $harga;
                  $produk->save();
              }

              $transaction->save();

              return response()->json([
                  'meta' => [
                      'code' => 200,
                      'message' => 'Midtrans Payment Success'
                  ]
              ]);
          } else if ($status == "pending") {
              $transaction->status = 'PENDING';
              $transaction->save();
              return response()->json([
                  'meta' => [
                      'code' => 200,
                      'message' => 'Midtrans Payment Pending'
                  ]
              ]);
          } else if ($status == 'deny') {
              $transaction->status = 'BATAL';
              $transaction->save();
              return response()->json([
                  'meta' => [
                      'code' => 200,
                      'message' => 'Midtrans Payment Deny'
                  ]
              ]);
          } else if ($status == 'expired') {
              $transaction->status = 'BATAL';
              $transaction->save();
              return response()->json([
                  'meta' => [
                      'code' => 200,
                      'message' => 'Midtrans Payment Expired'
                  ]
              ]);
          } else if ($status == 'cancel') {
              $transaction->status = 'BATAL';
              $transaction->save();
              return response()->json([
                  'meta' => [
                      'code' => 200,
                      'message' => 'Midtrans Payment Cancel'
                  ]
              ]);
          } else {
              $transaction->status = 'BATAL';
              $transaction->save();
              return response()->json([
                  'meta' => [
                      'code' => 500,
                      'message' => 'Midtrans Payment Gagal'
                  ]
              ]);
          }
    }
}
