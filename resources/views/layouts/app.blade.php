<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>{{ $title }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('website/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>

@yield('stylesheet')

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('app.app_name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard', app()->getLocale()) }}">{{ __('app.dashboard') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index', app()->getLocale()) }}">{{ __('app.manage_category') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('authors.index', app()->getLocale()) }}">{{ __('app.manage_author') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index', app()->getLocale()) }}">{{ __('app.manage_post') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.index', app()->getLocale()) }}">{{ __('app.manage_page') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subjects.index', app()->getLocale()) }}">{{ __('app.manage_subject') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('photos.index', app()->getLocale()) }}">{{ __('app.manage_photo') }}</a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            {{-- @if (Route::has('login')) --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{ __('app.user_login') }}</a>
                                </li>
                            {{-- @endif --}}
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{ __('app.user_register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                {{-- Admin Logout --}}
                                @if (\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('admin.logout', app()->getLocale()) }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('admin-logout-form').submit();">
                                            {{ __('app.admin_logout') }}
                                        </a>

                                        <form id="admin-logout-form" action="{{ route('admin.logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @else
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('user.logout', app()->getLocale()) }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('user-logout-form').submit();">
                                            {{ __('app.user_logout') }}
                                        </a>

                                        <form id="user-logout-form" action="{{ route('user.logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @endif

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('includes.flash')
            @yield('content')
        </main>

    </div>

    @yield('javascript')

</body>
</html>
