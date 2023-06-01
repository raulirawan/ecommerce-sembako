@extends('layouts.frontend')

@section('title','Home')

@section('content')
{{-- <div class="site-blocks-cover" data-aos="fade">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ml-auto order-md-2 align-self-start">
          <div class="site-block-cover-content">
          <h2 class="sub-title">#New Summer Collection 2019</h2>
          <h1>Arrivals Sales</h1>
          <p><a href="#" class="btn btn-black rounded-0">Shop Now</a></p>
          </div>
        </div>
        <div class="col-md-6 order-1 align-self-end">
          <img src="{{ asset('/frontend') }}/images/model_3.png" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </div> --}}


  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="title-section mb-5 col-12">
          <h2 class="text-uppercase">List Data Semua Produk</h2>
        </div>
      </div>
      <div class="row">
        @forelse ($produk as $item)
        @php
            $dataHarga = json_decode($item->harga, true);
        @endphp
        <div class="col-lg-4 col-md-6 item-entry mb-4">
        <a href="{{ route('produk.detail', $item->slug) }}" class="product-item md-height bg-gray d-block">
          <img src="{{ url($item->gambar ?? '') }}" alt="Image" class="img-fluid">
        </a>
        <h2 class="item-title"><a href="#">{{ $item->nama_produk ?? '' }}</a></h2>
        <strong class="item-price">Rp{{ number_format($dataHarga[0]['harga']) }}</strong>
      </div>
        @empty
        <div class="text-center">Tidak Ada Data Produk</div>
        @endforelse
      </div>
    </div>
  </div>


  <div class="site-blocks-cover inner-page py-5" data-aos="fade">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ml-auto order-md-2 align-self-start">
          <div class="site-block-cover-content">
          {{-- <h2 class="sub-title">#New Summer Collection 2019</h2> --}}
          <h1>New Produk</h1>
          <p><a href="{{ route('shop.index') }}" class="btn btn-black rounded-0">Shop Now</a></p>
          </div>
        </div>
        <div class="col-md-6 order-1 align-self-end">
          <img src="https://images.unsplash.com/photo-1588964895597-cfccd6e2dbf9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
@endsection
