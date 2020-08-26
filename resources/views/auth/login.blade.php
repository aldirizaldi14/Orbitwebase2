<!--<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <meta name="description" content="{{ env('APP_DESC') }}">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/metronic/style.bundle.css') }}" rel="stylesheet">
    
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />
</head>
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url({{ asset('images/bg.jpg') }});">
            <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                <div class="m-login__container">
                    <div style="text-align: center;">
                        <a href="#">
                            <img src="{{ asset('images/logo.png') }}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">
                                ORBIT
                            </h3>
                        </div>
                        <form class="m-login__form m-form"  method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="{{ __('Username') }}" name="user_username" autocomplete="off" value="{{ old('user_username') }}" autofocus required>
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                            </div>
                            <div class="form-group m-form__group" style="text-align: center;">
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                       <span class="form-control-feedback" role="alert"><strong>{{ $error }}</strong></span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
</body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ env('APP_NAME') }}</title>
  <meta name="description" content="{{ env('APP_DESC') }}">

  <link rel="stylesheet" type="text/css" href="css/login/css/video.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 

  <link rel="icon" type="image/png" href="css/login/images/icons/icon.png"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/login/vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="css/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/login/css/util.css">
  <link rel="stylesheet" type="text/css" href="css/login/css/main.css">

</head>

<!------ Include the above in your HEAD tag ---------->

<!-- <div class="wrap" style="background-image: url('http://localhost/orbit_test/login/images/bg.jpg');"
  style="background-image: url({{ asset('images/bg.jpg') }});"
> -->

<div class="wrap" style="background-image: url({{ asset('images/bg.jpg') }});"> 
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->

      <!-- Icon -->
      <div class="logogobel">
        <img src="http://137.40.52.103/orbit_test/public/images/gobel_w.png" id="icongobel">
      </div>
      <div class="textgobel">
        Panasonic
      </div>

      <div class="fadeIn first">
        <!--<img src="http://localhost/orbit_test/login/images/logo.png" id="icon" alt="User Icon" class="center"/>-->

        <img src="{{ asset('images/logo.png') }}" id="icon" alt="User Icon" class="center">
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <!--<div class="loginspace">
          <input type="text" id="login" class="fadeIn second" name="login" placeholder="Login">
        </div>-->

        <div class="wrap-input100 validate-input" data-validate = "Username is required">
            <input class="input100" placeholder="{{ __('Username') }}" name="user_username" autocomplete="off" value="{{ old('user_username') }}" autofocus required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100" type="password" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

        <!--<div class="passwordspace">
          <input type="text" id="password" class="fadeIn third" name="login" placeholder="Password">
        </div>-->
        <input type="submit" class="fadeIn fourth" value="Sign In">

        <div class="form-group m-form__group" style="text-align: center;">
           @if($errors->any())
           @foreach ($errors->all() as $error)
           <span class="form-control-feedback" role="alert">
            <strong>{{ $error }}</strong>
           </span>
            @endforeach
            @endif
         </div>
      </form>
      

      <!-- Remind Passowrd -->
      <div id="formFooter">
        <a class="underlineHover" href="#">O R B I T</a>
      </div>

    </div>
  </div>
</div>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
</html>