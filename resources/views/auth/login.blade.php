<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard | Login</title>
  <!-- General CSS Files -->
  @yield('style')
  <link rel="stylesheet" href="{{url('assets/css/app.min.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{url('assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{url('assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{url('assets/img/favicon.ico')}}" />
  <style type="text/css">
      .logo-header
      {
        display: block;
        text-align: center;
      }
      .logo-header img
      {
        height: 50px;
        margin-top: 10px;
      }
      .panel-heading
      {
        padding-left: 10px;
      }
      .panel-heading h1
      {
        font-size: 24px;
      }
      .navbar-bg
      {
          position:relative;
      }
  </style>
</head>
<body>
<div id="app">
<div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg">
          <a href="{{url('/')}}">
            <div class="logo-header">
              <img alt="image" src="{{asset('assets/img/footer-logo.png')}}" class="header-logo">
            </div>
            </a>
      </div>
<section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                     {{ csrf_field() }}
                        @if($errors->has('invalid'))
                        <div class="alert alert-danger">
                          {{ $errors->first('invalid') }}
                        </div>
                        @endif
                  <div class="form-group">
                    <label for="email">Email</label>
                     <input id="username" type= "text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                     <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>
</body>
</html>
