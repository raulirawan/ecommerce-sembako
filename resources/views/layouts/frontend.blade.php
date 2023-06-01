<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @stack('up-style')
    @include('includes.frontend.style')
    @stack('down-style')

  </head>
  <body>

  <div class="site-wrap">


  @include('includes.frontend.navbar')

   @yield('content')

   @include('includes.frontend.footer')
  </div>

  @stack('up-script')
  @include('includes.frontend.script')
  @stack('down-script')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  @include('sweetalert::alert')

  </body>
</html>
