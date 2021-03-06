<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DecodeIt') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
        <!--bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="{{ asset('css//config.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/border.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/elements.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/index.css') }}" media="screen">


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        
    </head>
    <body class="font-sans antialiased d-flex flex-col">
      <div class="background">

        <header class="navbar-default sticky-top layer-1">
          <nav class="navbar navbar-expand-lg navbar-light container">
            <a href="{{ route('studentDashboard') }}" class="logo navbar-header navbar-nav ">
                <img src="{{ asset('img/logo.png') }}">
            </a>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
          <ul class="nav nav-horizontal my-2 my-lg-0">
              <li class="nav-item "><a class="nav-link animate-h" href="{{ route('studentDashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link animate-h" href="{{ route('course_studentIndex') }}">Courses</a></li>
              <li class="nav-item"><a class="nav-link animate-h" href="{{ route('student_studentShow') }}">My Account</a></li>
              <li class="nav-item">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <a class="nav-link animate-h" href="route('logout')" 
                        onclick="event.preventDefault();this.closest('form').submit();">Log Out</a>
                </form>

              </li>
              <!--<li class="nav-item"><label class="switch"><input type="checkbox" onchange="toggleTheme()"><span class="slider round"></span></label></li>-->
          </ul>
      </div>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
  </nav>

  <!-- off canvas -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">DecodeIt</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
          <div class="dropdown mt-3">
              <ul >
              <li><a href="{{ route('studentDashboard') }}">Dashboard</a></li>
              <li><a href="{{ route('course_studentIndex') }}">Courses</a></li>
              <li><a href="{{ route('student_studentShow') }}">My Account</a></li>
              <li>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <a href="route('logout')" 
                        onclick="event.preventDefault();this.closest('form').submit();">Log Out</a>
                </form>

              </li>
          </ul>
          </div>
      </div>
  </div>
        </header>
        <!-- Page Content -->
        <main  class="container" style="padding-bottom: 175px;">
            @yield('content')
        </main>
		</div>
        <x-footer></x-footer>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/scrollToTop.js') }}"></script>
        <script src="{{ asset('js/responsive.js') }}" ></script>
        @yield('scripts')

    </body>
</html>
