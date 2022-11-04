
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="apple-touch-icon" href="{{asset('admin/css/icons.css')}}">
    <meta name="theme-color" content="#317EFB"/>
    <meta name="apple-mobile-web-app-status-bar" content="#317EFB"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>ورود به پنل کاربری</title>
    <!--favicon-->
    <link rel="icon" href="{{asset('admin/images/favicon.ico')}}" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{asset('admin/css/lobibox.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Custom Style-->
    <link href="{{asset('admin/css/app-style.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/css/app-style-rtl.css')}}" rel="stylesheet"/>
   <link rel="manifest" href="{{asset('manifest.json')}}"/>
    <style>
        .mr-auto, .mx-auto {
            margin-left: auto!important;
            margin-right: auto!important;
        }
        [class*="icheck-material"] > input:first-child:checked + label::after, [class*="icheck-material"] > input:first-child:checked + input[type="hidden"] + label::after {
            left: auto;
            right: 13px;
        }
        [class*="icheck-material"] > input:first-child + label::before, [class*="icheck-material"] > input:first-child + input[type="hidden"] + label::before{
            right: 0;
        }
        [class*="icheck-material"] > label{
            padding-right: 29px !important;
            padding-left: 0;
        }
         .Lobibox-custom-class{
             width: auto !important;
         }
        .hide-close-icon .lobibox-close{
            display: none;
        }
        .Lobibox-custom-class-confirm{
            text-align: right;
            color: #555;
        }
        .Lobibox-custom-class-confirm .btn-close{
            float: left!important;
        }
 .invalid-feedback{
            text-align: right;
        }
        input::placeholder {
            text-align: right;
        }
    </style>
</head>

<body>

{{--
<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
<!-- end loader -->
--}}

<!-- Start wrapper-->
<div id="wrapper">

    <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="{{asset(setting()['logo'])}}" alt="logo icon">
                </div>
                <div class="card-title text-uppercase text-center py-3">ورود به پنل</div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername" class="sr-only">Username</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="exampleInputUsername"  name="email" class="form-control input-shadow  @error('email') is-invalid @enderror" placeholder="ایمیل را وارد کنید" value="{{ old('email') }}">
                            <div class="form-control-position">
                                <i class="icon-user"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Password</label>
                        <div class="position-relative has-icon-left">
                            <input type="password" id="exampleInputPassword" class="form-control input-shadow @error('password') is-invalid @enderror" name="password" placeholder="رمز عبور را وارد کنید">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row" style="text-align: right;direction: rtl;">
                        <div class="form-group col-12">
                            <div class="icheck-material-primary">
                                <input type="checkbox" name="remember" id="user-checkbox" {{ old('remember') ? 'checked' : '' }} />
                                <label for="user-checkbox">مرا به خاطر بسپار</label>
                            </div>
                        </div>
<!--                        <div class="form-group col-6 text-right">
                            <a href="authentication-reset-password.html">Reset Password</a>
                        </div>-->
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">ورود</button>



                </form>
            </div>
        </div>

    </div>


</div><!--wrapper-->
<div class="offline-back">
    <div class="offline">
        <div class="spinner-grow text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span>در حال اتصال...</span>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
<script src="{{asset('admin/js/lobibox.min.js')}}"></script>
<script src="{{asset('admin/js/popper.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>

<!-- sidebar-menu js -->
<script src="{{asset('admin/js/sidebar-menu.js')}}"></script>

<!-- Custom scripts -->
<script src="{{asset('admin/js/app-script.js')}}"></script>
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js');
    }
    window.addEventListener("online",function(){
        $('.offline-back').hide();
        Lobibox.notify('success', {
            size: 'mini',
            showClass: 'Lobibox-custom-class hide-close-icon',
            iconSource: "fontAwesome",
            delay:3000,
            soundPath: '{{asset('admin/sounds/sounds/')}}',
            position: 'center bottom', //or 'center bottom'
            msg: 'اتصال برقرار شد',
        });

    });
    window.addEventListener("offline",function(){
        $('.offline-back').show();
        Lobibox.notify('error', {
            size: 'mini',
            showClass: 'Lobibox-custom-class hide-close-icon',
            iconSource: "fontAwesome",
            delay:3000,
            soundPath: '{{asset('admin/sounds/sounds/')}}',
            position: 'center bottom', //or 'center bottom'
            msg: 'عدم اتصال به اینترنت',
        });
    })
</script>
@if(session('role-error-login'))
    <script>
        Lobibox.notify('error', {
            size: 'mini',
            showClass: 'Lobibox-custom-class hide-close-icon',
            iconSource: "fontAwesome",
            delay:5000,
            soundPath: '{{asset('admin/sounds/sounds/')}}',
            position: 'left top', //or 'center bottom'
            msg: '{{session('role-error-login')}}',
        });
    </script>
@endif
</body>
</html>
@php
    session()->forget('role-error-login');
@endphp
