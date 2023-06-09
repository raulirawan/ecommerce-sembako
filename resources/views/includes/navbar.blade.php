<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand"
                @php
$route = (Auth::user()->roles == 'OWNER') ? 'owner.dashboard.index' : ((Auth::user()->roles == 'ADMIN') ? 'admin.dashboard.index' : 'kurir.dashboard.index'); @endphp
                href="{{ route($route) }}"><img src="{{ asset('/') }}images/logo.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset('/') }}images/logo2.png"
                    alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">

            </div>

            <div class="user-area dropdown float-right d-flex">
                <h6 style="margin-top: 15px;
                margin-right: 10px;
            ">{{ Auth::user()->name }}
                    | {{ Auth::user()->roles }}</h6>
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{ asset('/') }}images/admin.jpg" alt="User Avatar">
                </a>
            </div>

        </div>

    </div>
</header>
