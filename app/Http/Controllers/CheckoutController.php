<?php

namespace App\Http\Controllers;

use App\Cart;
use Exception;
use App\Produk;
use App\Transaksi;
use Midtrans\Snap;
use Midtrans\Config;
use App\TransaksiDetail;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::where('user_id', Auth::user()->id)->get()->isEmpty()) {
            Alert::error('Error', 'Keranjang Kosong!');
            return redirect()->route('home.index');
        }
        $carts = Cart::where('user_id', Auth::user()->id);
        $carts = $carts->get();
        $total = $carts->sum('total_harga');

        $response = ApiHelper::apiGet('https://api.rajaongkir.com/starter/province');
        $response = json_decode($response);
        $data = $response->rajaongkir->results;

        return view('checkout', compact('carts', 'total', 'data'));
    }

    public function getKota(Request $request)
    {
        $response = ApiHelper::apiGet('https://api.rajaongkir.com/starter/city?province=' . $request->province);
        $response = json_decode($response);
        $data = $response->rajaongkir->results;
        return response()->json($data);
    }

    public function ongkir(Request $request)
    {
        $body = [
            'json' => [
                'origin' => "151",
                'destination' => $request->kota_id,
                'weight' => 1000,
                'courier' => $request->kurir,
            ],
        ];

        $response = ApiHelper::apiPost('https://api.rajaongkir.com/starter/cost', $body);
        $response = json_decode($response);
        $data = $response->rajaongkir->results[0];

        return response()->json($data);
    }

    public function checkoutPost(Request $request)
    {
        $produkIds = [];
        $dataCart = Cart::where('user_id', Auth::user()->id)->get();
        foreach ($dataCart as $key => $cart) {
            $produk = Produk::findOrFail($cart->produk_id);
            $dataHarga = json_decode($produk->harga, true);
            $dataKey = 0;
            foreach ($dataHarga as $key => $harga) {
                if ($harga['keterangan'] == $cart->variant) {
                    $dataKey = $key;
                }
            }
            $harga = $dataHarga;
            $stok = $harga[$dataKey]['stok'];

            if ($stok <= $cart->qty) {
                $produkIds[] = $cart->produk_id;
            }
        }

        if ($produkIds) {
            // delete produk id
            Cart::whereIn('produk_id', $produkIds)->delete();
            return response()->json([
                'message' => 'Transaksi Gagal di Buat Stok Tidak Cukup',
                'status'  => 'gagal',
                'url' => url('/cart'),
            ]);
        }


        if ($request->jenis_transaksi == 'COD') {
            $kode = 'INV-' . mt_rand(00000, 99999);
            // $ongkir = $request->ongkir;
            $carts = Cart::where('user_id', Auth::user()->id);
            $carts = $carts->get();
            $harga = $carts->sum('total_harga');

            $total_harga = $harga;

            // insert ke transaction
            $transaksi = new Transaksi();
            $transaksi->user_id = Auth::user()->id;
            $transaksi->kode = $kode;
            $transaksi->harga = $harga;
            $transaksi->total_harga = $total_harga;
            $transaksi->alamat_pengiriman = $request->alamat;
            $transaksi->provinsi = $request->provinsi;
            $transaksi->kota = $request->kota;
            $transaksi->kecamatan = $request->kecamatan;
            $transaksi->kelurahan = $request->kelurahan;
            $transaksi->jenis_transaksi = $request->jenis_transaksi;
            $transaksi->status = 'SEDANG DIKIRIM';
            $transaksi->save();

            foreach ($carts as $key => $cart) {
                $transaksiDetail = new TransaksiDetail();
                $transaksiDetail->transaksi_id = $transaksi->id;
                $transaksiDetail->produk_id = $cart->produk->id;
                $transaksiDetail->harga = $cart->harga;
                $transaksiDetail->qty = $cart->qty;
                $transaksiDetail->total_harga = $cart->total_harga;
                $transaksiDetail->variant = $cart->variant;
                $transaksiDetail->save();

                $produk = Produk::findOrFail($cart->produk_id);

                $dataHarga = json_decode($produk->harga, true);

                $dataKey = 0;
                foreach ($dataHarga as $key => $harga) {
                    if ($harga['keterangan'] == $cart->variant) {
                        $dataKey = $key;
                    }
                }
                //   $dataHarga = collect($dataHarga)->where('keterangan', $item->variant)->first();
                //   dd($dataHarga);
                $harga = $dataHarga;
                $harga[$dataKey]['stok'] = $dataHarga[$dataKey]['stok'] - $cart->qty;
                $produk->harga = $harga;
                $produk->save();
            }

            if ($transaksi != null) {
                // delete cart

                Cart::where('user_id', Auth::user()->id)->delete();
                return response()->json([
                    'message' => 'Transaksi Berhasil di Buat',
                    'status'  => 'success',
                    'url' => url('/success'),
                ]);
            } else {
                return response()->json([
                    'message' => 'Transaksi Gagal di Buat, Coba Lagi Ya',
                    'status'  => 'gagal',
                    'url' => url('/'),
                ]);
            }
        }
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $kode = 'INV-' . mt_rand(00000, 99999);
        // $ongkir = $request->ongkir;
        $carts = Cart::where('user_id', Auth::user()->id);
        $carts = $carts->get();
        $harga = $carts->sum('total_harga');

        $total_harga = $harga;

        // insert ke transaction
        $transaksi = new Transaksi();
        $transaksi->user_id = Auth::user()->id;
        $transaksi->kode = $kode;
        $transaksi->harga = $harga;
        $transaksi->total_harga = $total_harga;
        $transaksi->alamat_pengiriman = $request->alamat;
        $transaksi->provinsi = $request->provinsi;
        $transaksi->kota = $request->kota;
        $transaksi->kecamatan = $request->kecamatan;
        $transaksi->kelurahan = $request->kelurahan;
        $transaksi->jenis_transaksi = $request->jenis_transaksi;
        $transaksi->status = 'PENDING';
        // midtrans
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $kode,
                'gross_amount' => (int) $total_harga,
            ],

            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'callbacks' => [
                'finish' => url('/success'),
            ],
            'enable_payments' => ['bca_va', 'permata_va', 'bni_va', 'bri_va', 'gopay'],
            'vtweb' => [],
        ];

        try {
            //ambil halaman payment midtrans

            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

            $transaksi->link_pembayaran = $paymentUrl;
            $transaksi->save();
            // insert ke detail
            foreach ($carts as $key => $cart) {
                $transaksiDetail = new TransaksiDetail();
                $transaksiDetail->transaksi_id = $transaksi->id;
                $transaksiDetail->produk_id = $cart->produk->id;
                $transaksiDetail->harga = $cart->harga;
                $transaksiDetail->qty = $cart->qty;
                $transaksiDetail->total_harga = $cart->total_harga;
                $transaksiDetail->variant = $cart->variant;
                $transaksiDetail->save();
            }
            if ($transaksi != null) {
                // delete cart
                Cart::where('user_id', Auth::user()->id)->delete();
                return response()->json([
                    'message' => 'Transaksi Berhasil di Buat',
                    'status'  => 'success',
                    'url' => $paymentUrl,
                ]);
            } else {
                return response()->json([
                    'message' => 'Transaksi Gagal di Buat, Coba Lagi Ya',
                    'status'  => 'gagal',
                    'url' => url('/'),
                ]);
            }
            //reditect halaman midtrans
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status'  => 'gagal',
                'url' => url('/'),
            ]);
        }
    }
}
