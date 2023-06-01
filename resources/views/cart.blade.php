@extends('layouts.frontend')

@section('title','Halaman Cart')

@section('content')

<div class="bg-light py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ route('home.index') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row mb-5">
        <form class="col-md-12" method="post">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
          <div class="site-blocks-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="product-thumbnail">Image</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-quantity">Quantity</th>
                  <th class="product-variant">Variant</th>
                  <th class="product-total">Total</th>
                  <th class="product-remove">Remove</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($carts as $cart)
                <tr>
                    <td class="product-thumbnail">
                      <img src="{{ url($cart->produk->gambar) }}" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                      <h2 class="h5 text-black">{{ $cart->produk->nama_produk }}</h2>
                    </td>
                    <td>Rp{{ number_format($cart->harga) }}</td>
                    <td>
                        {{ $cart->qty }}
                    </td>
                    <td>{{ $cart->variant }}</td>
                    <td>Rp{{ number_format($cart->total_harga) }}</td>
                    <td><a href="{{ route('delete.cart', $cart->id) }}" onclick="return confirm('Yakin Hapus ?')" class="btn btn-primary height-auto btn-sm">X</a></td>
                  </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak Ada Data Cart</td>
                </tr>
                @endforelse


              </tbody>
            </table>
          </div>
        </form>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="row mb-5">
            {{-- <div class="col-md-6 mb-3 mb-md-0">
              <button class="btn btn-primary btn-sm btn-block">Update Cart</button>
            </div> --}}
            <div class="col-md-6">
              <a href="{{ route('home.index') }}" class="btn btn-primary btn-sm btn-block">Continue Shopping</a>
            </div>
          </div>
          {{-- <div class="row">
            <div class="col-md-12">
              <label class="text-black h4" for="coupon">Coupon</label>
              <p>Enter your coupon code if you have one.</p>
            </div>
            <div class="col-md-8 mb-3 mb-md-0">
              <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
            </div>
            <div class="col-md-4">
              <button class="btn btn-primary btn-sm px-4">Apply Coupon</button>
            </div>
          </div> --}}
        </div>
        @if (!$carts->isEmpty())

        <div class="col-md-6 pl-5">
          <div class="row justify-content-end">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-12 text-right border-bottom mb-5">
                  <h3 class="text-black h4 text-uppercase">Total Harga</h3>
                </div>
              </div>

              <div class="row mb-5">
                <div class="col-md-6">
                  <span class="text-black">Total</span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black">Rp{{ number_format($total) }}</strong>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-lg btn-block" onclick="window.location='/checkout'">Proceed To Checkout</button>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
