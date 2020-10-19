<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Palang Krapyak Stone') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/kustom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/nice-select.css') }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
</head>
<body onload="myFunction()">
  <div id="loader"></div>
  <div style="display:none;" id="myDiv" class="animate-bottom">
  <header class="mb-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="{{ route('front.index') }}">Palang Krapyak Stone</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="margin-bottom: 10px;">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Kategori
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach($categories as $category)
              <a class="dropdown-item" href="{{ route('front.category', $category->slug) }}">{{ $category->nama }}</a>
              @endforeach
            </div>
          </li>
        </ul>
        <form action="{{ url('/') }}" method="get" class="form-inline my-lg-0 mr-auto">
          <input class="form-control mr-sm-2 search" type="text" name="cari" placeholder="Cari..." value="{{ request()->cari }}" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
        </form>
        <div id="angkacart" class="d-flex">
          <a id="shoppingcart" href="{{ route('front.list_cart') }}" class="my-auto mr-auto" rel="popover" data-placement="bottom" data-original-title="Keranjang Belanja" data-trigger="hover">
          @if ($totalcart < 100)
            <span id="spanangka" class="angkacart">{{ $totalcart }}</span>
          @else
            <span id="spanangka" class="angkacart">{{ \Str::limit(999, 2, '+') }}</span>
          @endif
            <img class="unf-header-menu__icon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxkZWZzPjxwYXRoIGQ9Ik0yMC40NyA1YTEuNSAxLjUgMCAwIDEgMS40OCAxLjlsLTEuODMgNi41MkEzLjU4IDMuNTggMCAwIDEgMTYuNjYgMTZIOC45M2MtLjk0IDAtMS43Ni0uNjMtMS45OS0xLjUyTDQuMjYgNEgzLjAyQzIuNDYgNCAyIDMuNTUgMiAzcy40Ni0xIDEuMDItMUg1LjFjLjQ3IDAgLjg4LjMxLjk5Ljc2TDYuNjUgNWgxMy44MnpNOSAxNy41YTIgMiAwIDEgMSAwIDQgMiAyIDAgMCAxIDAtNHptOCAwYTIgMiAwIDEgMSAwIDQgMiAyIDAgMCAxIDAtNHoiIGlkPSJhIi8+PC9kZWZzPjxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PHBhdGggZD0iTTAgMGgyNHYyNEgweiIvPjxtYXNrIGlkPSJiIiBmaWxsPSIjZmZmIj48dXNlIHhsaW5rOmhyZWY9IiNhIi8+PC9tYXNrPjx1c2UgZmlsbD0iIzlGQTZCMCIgeGxpbms6aHJlZj0iI2EiLz48ZyBtYXNrPSJ1cmwoI2IpIiBmaWxsPSIjNkM3MjdDIiBmaWxsLXJ1bGU9Im5vbnplcm8iPjxwYXRoIGQ9Ik0xIDFoMjJ2MjJIMXoiLz48L2c+PC9nPjwvc3ZnPg==">
          </a>
        </div>
        <div class="line-cart"></div>
        <div class="navbar-nav">
        @guest
          <li class="nav-item ml-1">
              <a class="btn btn-outline-info mr-sm-1" href="{{ route('login') }}">{{ __('Masuk') }}</a>
          </li>
        </div>
        <div class="navbar-nav">
          @if (Route::has('register'))
              <li class="nav-item">
                  <a class="btn btn-info" href="{{ route('register') }}">{{ __('Daftar') }}</a>
              </li>
          @endif
          @else
            <ul class="navbar-nav dropdown ">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->nama }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('pelanggan.dashboard') }}">Dasboard</a>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
            </ul>
            @endguest
            {{-- <a href="{{ route('login') }}" class="btn btn-outline-info mr-sm-1" role="button">Login</a>
            <a href="{{ route('register') }}" class="btn btn-info" role="button">Register</a> --}}
        </div>
      </div>
    </nav>
    <div id="popover_content_cart" style="display: none">
      <span id="cart_details">
      </span>
    </div>
  </header>

  {{-- Content --}}
  @yield('content')

  {{-- JS --}}
  {{-- <script src="{{ asset('js/theme.js') }}"></script> --}}
  {{-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script> --}}
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.nice-select.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
  @yield('js')
  @yield('snap')

  {{-- Select2 --}}
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
</body>
</html>