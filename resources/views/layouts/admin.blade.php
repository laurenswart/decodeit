<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>


         <!--bootstrap-->
         <script class="u-script" type="text/javascript" src="js/jquery-1.9.1.min.js" defer=""></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="{{ asset('css//config.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/border.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/elements.css') }}" >
        

        <link rel="stylesheet" href="{{ asset('css/index.css') }}" media="screen">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}" >

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="home background antialiased">
        <div class="layer-2" id="top-bar">
            <button class="admin-toggler" type="button" style="visibility:hidden">
                <span><i class="fas fa-bars"></i></span>
            </button>
            <div>
            Hello {{auth()->guard('admin')->user()->username }}
            </div>
            <a hef="home.html">
                <img src="{{ asset('img/logo.png') }}" alt="merkery_logo" >
            </a>
        
        </div>
        <div class="row">
            <header class="col-md-2 col-sm-1 layer-1 slide-in" id="navigation">
                
                <ul class="nav flex-column" >
                    <button class="admin-toggler"><i class="fas fa-times"></i></button>

                    <li class="nav-item">
                        <a class="nav-link active animate-v" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate-v" href="#">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate-v" href="{{ route('adminSubscriptionsIndex') }}">Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate-v" href="#">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="nav-link animate-v" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </header>
            <div class="col main-content">
                <h1 class=" block-title  layer-2"> @yield('title')</h1>
                <!-- Page Content -->
                <main>
                @yield('content')
                </main>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/admin.js') }}"></script>
</html>
