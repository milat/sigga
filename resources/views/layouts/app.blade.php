<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sigga') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/mask.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Chart.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('images/logo_bk2.png') }}" width="100px" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @can('request')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('request.index') }}">{{$language::get('requests')}}</a>
                            </li>
                        @endcan

                        @can('citizen')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('citizen.index') }}">{{$language::get('citizens')}}</a>
                            </li>
                        @endcan

                        @can('organization')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('organization.index') }}">{{$language::get('organizations')}}</a>
                            </li>
                        @endcan

                        @can('document')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('document.index') }}">{{$language::get('documents')}}</a>
                            </li>
                        @endcan

                        @can('config')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{$language::get('configs')}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('user')
                                        <a class="dropdown-item" href="{{ route('user.index') }}">{{$language::get('users')}}</a>
                                    @endcan
                                    @can('role')
                                        <a class="dropdown-item" href="{{ route('role.index') }}">{{$language::get('roles')}}</a>
                                    @endcan
                                    @can('category')
                                        <a class="dropdown-item" href="{{ route('category.index') }}">{{$language::get('categories')}}</a>
                                    @endcan
                                </div>
                            </li>
                        @endcan
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{Auth::user()->email}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.password') }}">
                                    {{$language::get('password_update')}}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{$language::get('logout')}}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            <div class="row fader">
                <div class="col">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <center>{!! \Session::get('success') !!}</center>
                        </div>
                    @endif

                    @if (\Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            <center>{!! \Session::get('error') !!}</center>
                        </div>
                    @endif

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <center>{{$error}}</center>
                        </div>
                    @endforeach
                </div>
            </div>

            @yield('content')
        </main>
    </div>
</body>
</html>
