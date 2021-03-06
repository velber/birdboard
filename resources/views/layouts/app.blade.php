<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="theme-light bg-page">
    <div id="app">
        <nav class="bg-header">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2">
                    <h1>
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </h1>
                    <div>
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <div class="flex items-center ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @else
                                <theme-switcher></theme-switcher>
                                <dropdown align="" width="200px">
                                    <template slot="trigger">
                                        <button type="button" id="navbarDropdown" class="nav-link dropdown-toggle">
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </button>
                                    </template>
                                    <a class="dropdown-menu-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </dropdown>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
