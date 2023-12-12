<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <title>@yield('title' ?? 'Home') | Flamingo Insights</title>

  <!-- General CSS Files -->

  <link rel="stylesheet" href="{{url('assets/css/app.min.css')}}">

  <link rel="stylesheet" href="{{url('assets/bundles/jqvmap/dist/jqvmap.min.css')}}">

  <link rel="stylesheet" href="{{url('assets/bundles/weather-icon/css/weather-icons.min.css')}}">

  <link rel="stylesheet" href="{{url('assets/bundles/weather-icon/css/weather-icons-wind.min.css')}}">

  <link rel="stylesheet" href="{{url('assets/bundles/summernote/summernote-bs4.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Template CSS -->

  <link rel="stylesheet" href="{{url('assets/css/style.css')}}">

  <link rel="stylesheet" href="{{url('assets/css/components.css')}}">

  <!-- Custom style CSS -->

  <link rel="stylesheet" href="{{url('assets/css/custom.css')}}">

  {{-- <link rel='shortcut icon' type='image/x-icon' href="{{url('assets/img/.png')}}" /> --}}
  <link rel='shortcut icon' type='image/x-icon' href="{{url('assets/img/favicon.ico')}}" />


  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @yield('head')

</head>

<body data-gr-c-s-loaded="true" class="light light-sidebar theme-white">

  <div id="app">

    <div class="main-wrapper main-wrapper-1">

      <div class="navbar-bg"></div>

      <nav class="navbar navbar-expand-lg main-navbar" style="background-color: #f7f6f2;">

        <div class="form-inline mr-auto">

          <ul class="navbar-nav mr-3">

            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i class="fas fa-bars"></i></a></li>

            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">

                <i class="fas fa-expand"></i>

              </a>

            </li>

          </ul>

        </div>

        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

              <img alt="image" src="https://flamingoinsights.com/assets/logo.png" class="user-img-radious-style">

              <span class="d-sm-none d-lg-inline-block"></span></a>

            <div class="dropdown-menu dropdown-menu-right">

              <div class="dropdown-title">Hello Flamingo Insights</div>

              <a href="#" class="dropdown-item has-icon">

                <i class="fas fa-cog"></i> Settings

              </a>

              <div class="dropdown-divider"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();"> Logout</a>
              </form>
              {{-- <a href="/logout" class="dropdown-item has-icon text-danger">

                <i class="fas fa-sign-out-alt"></i> Logout

              </a> --}}

            </div>

          </li>

        </ul>

      </nav>

      <div class="main-sidebar sidebar-style-2">

        <aside id="sidebar-wrapper">

          <div class="sidebar-brand" style="background-color: #d7d6d0;">

            <a href="{{url('')}}">

              <img alt="image" src="https://flamingoinsights.com/assets/logo.png" class="header-logo" />

            </a>

          </div>

          <ul class="sidebar-menu">
            <!--<li class="menu-header">Main</li>-->

            <li><a class="nav-link" href="{{url('/')}}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            </li>
            <li><a class="nav-link" href="{{url('projects')}}"><i class="fas fa-project-diagram"></i><span>Projects</span></a></li>
            <li><a class="nav-link" href="{{url('/industries')}}"><i class="fa fa-industry"></i><span>Industries</span></a>
            <li><a class="nav-link" href="{{url('surveys')}}"><i class="fa fa-poll"></i><span>Partner Surveys</span></a></li>
            <li><a class="nav-link" href="{{url('partners')}}"><i class="fa fa-address-card"></i><span>Partners</span></a></li>
            <li><a class="nav-link" href="{{url('/users')}}"><i class="fas fa-user"></i><span>Users</span></a></li>
          </ul>
        </aside>
      </div>
      <div class="wrapper">
        @include('layouts.notification')
        @yield('content')
      </div>
      <footer class="main-footer">

        <div class="footer-left">

          Copyright &copy; 2021 <div class="bullet"></div> Design By <a href="https://www.softication.com">Softcation</a>

        </div>

        <div class="footer-right">

        </div>

      </footer>

    </div>

  </div>

  <!-- General JS Scripts -->

  <script src="{{url('assets/js/app.min.js')}}"></script>

  <!-- JS Libraies -->

  <script src="{{url('assets/bundles/chartjs/chart.min.js')}}"></script>

  <script src="{{url('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>

  <!-- Page Specific JS File -->

  <script src="{{url('assets/js/page/index.js')}}"></script>

  <!-- Template JS File -->

  <script src="{{url('assets/js/scripts.js')}}"></script>

  <!-- Custom JS File -->

  <script src="{{url('assets/js/custom.js')}}"></script>

  @yield('js')

</body>

</html>