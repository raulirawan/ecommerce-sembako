<div class="site-navbar bg-white py-2">

    <div class="search-wrap">
      <div class="container">
        <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
        <form action="{{ route('search.index') }}" method="get">
          <input type="text" class="form-control" name="nama_produk" placeholder="Search keyword and hit enter...">
        </form>
      </div>
    </div>

    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <div class="logo">
          <div class="site-logo">
            <a href="{{ url('/') }}" class="js-logo-clone">toko berkah</a>

          </div>
        </div>
        <div class="main-nav d-none d-lg-block">
          <nav class="site-navigation text-right text-md-center" role="navigation">
            <ul class="site-menu js-clone-nav d-none d-lg-block">
              <li><a href="{{ route('home.index') }}">Home</a></li>
              <li><a href="{{ route('shop.index') }}">Shop</a></li>
              <li class="has-children">
                <a href="#">Kategori</a>
                <ul class="dropdown">
                    @foreach (App\Kategori::all() as $item)
                        <li><a href="{{ route('kategori.index', $item->slug) }}">{{ $item->nama_kategori }}</a></li>
                    @endforeach
                </ul>

              </li>
              @auth
              <li class="has-children">
                <a href="#">My Account</a>
                <ul class="dropdown">
                  <li><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                  <li><a href="{{ route('profil.index') }}">Profil</a></li>
                  <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </li>
              <li><a href="#">Hai, {{ Auth::user()->name }}</a></li>
              @endauth
             @guest
             <li><a href="{{ route('login') }}">Login</a></li>
             <li><a href="{{ route('register') }}">Register</a></li>

             @endguest
            </ul>
          </nav>
        </div>
        <div class="icons">
          <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
          {{-- <a href="#" class="icons-btn d-inline-block"><span class="icon-heart-o"></span></a> --}}
        @auth
        <a href="{{ route('cart.index') }}" class="icons-btn d-inline-block bag mr-3">
            <span class="icon-shopping-bag"></span>
            <span class="number">{{ App\Cart::where('user_id', Auth::user()->id)->count() }}</span>
          </a>

        @endauth
          <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
        </div>
      </div>
    </div>
  </div>
