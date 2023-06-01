@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
    <div class="site-blocks-cover" data-aos="fade">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto order-md-2 align-self-start">
                    <div class="site-block-cover-content">
                        {{-- <h2 class="sub-title">#New Summer Collection 2019</h2> --}}
                        <h1>Toko Berkah</h1>
                        <p><a href="{{ route('shop.index') }}" class="btn btn-black rounded-0">Belanja Sekarang</a></p>
                    </div>
                </div>
                <div class="col-md-6 order-1 align-self-end">
                    <img src="https://images.unsplash.com/photo-1617500603321-bcd6286973b7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80"
                        alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>


    <div class="site-section custom-border-bottom" data-aos="fade">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="block-16">
                        <figure>
                            <img src="https://images.unsplash.com/photo-1543168256-418811576931?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                                alt="Image placeholder" class="img-fluid rounded">
                            {{-- <a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo"><span class="icon-play"></span></a> --}}

                        </figure>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">


                    <div class="site-section-heading pt-3 mb-4">
                        <h2 class="text-black">toko berkah</h2>
                    </div>
                    <p>
                        Toko berkah menjual berbagai Macam Produk Sembako, dengan harga murah seperti: gula pasir, minyak
                        goreng, tepung terigu, minuman kemasan, bumbu penyedap, dan berbagai jenis sembako lainnya.
                    </p>
                    <h5>Hubungi Kontak Kami 089677708233</h5>
                </div>
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
                    <img src="https://images.unsplash.com/photo-1588964895597-cfccd6e2dbf9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80"
                        alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection
