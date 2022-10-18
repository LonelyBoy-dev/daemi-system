<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="theme-color" content="#317EFB"/>
    <link rel="apple-touch-icon" href="{{asset('admin/css/icons.css')}}">
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{setting()['title']}}</title>
    <!--favicon-->
    <link rel="icon" href="{{asset('admin/images/favicon.ico')}}" type="image/x-icon"/>
    <!-- Vector CSS -->
    <link href="{{asset('admin/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
    <!-- simplebar CSS-->
    <link href="{{asset('admin/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
    <!-- Bootstrap core CSS-->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS-->
    <link href="{{asset('admin/css/sidebar-menu.css')}}" rel="stylesheet"/>
    <!-- Custom Style-->
    @yield('style_link')
    <link href="{{asset('admin/css/app-style.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/css/lobibox.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/css/app-style-rtl.css')}}" rel="stylesheet"/>
    <!-- skins CSS-->
    <link href="{{asset('admin/css/skins.css')}}" rel="stylesheet"/>
    <!-- skins CSS-->
    <link href="{{asset('admin/css/skins.css')}}" rel="stylesheet"/>
    @php $agent=new Jenssegers\Agent\Agent();@endphp
    @if ($agent->isMobile())
    <link href="{{asset('admin/css/table.mobile.css')}}" rel="stylesheet"/>
    @endif
    @yield('style')
    <link rel="manifest" href="{{asset('manifest.webmanifest')}}"/>
</head>
<style>
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
    table.dataTable tbody tr {
        background-color: #242526;
    }
    .numberToword{
        position: absolute;
        bottom: -9px;
        font-size: 13px;
    }
    .table.dataTable th:first-child,.table.dataTable td:first-child,.table.dataTable th:last-child,.table.dataTable td:last-child{
        padding: 5px 10px 5px 0;
        background: unset!important;
    }
    .checked-row{
        background-color: #fff!important;
        color: #000!important;
    }

</style>
<body>

<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
<!-- end loader -->

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">

        <div class="user-details">
            <div class="media align-items-center collapsed">
                <div class="media-body">
                    <h6 class="side-user-name">{{setting()['title']}}</h6>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu">
<!--            <li class="@if(@$Active=="dashboard")active @endif"><a href="/admin/dashboard" class="waves-effect">  <i class="zmdi zmdi-view-dashboard"></i> <span>داشبورد</span></a></li>-->
            <li class="@if(@$Active=="members")active @endif"><a href="/admin/members" class="waves-effect">  <i class="zmdi zmdi-account-box"></i> <span> لیست مشتری</span></a></li>
            <li class="@if(@$Active=="factors")active @endif"><a href="/admin/factors" class="waves-effect">  <i class="zmdi zmdi-layers"></i> <span>لیست فاکتور</span></a></li>
            <li class="@if(@$Active=="products")active @endif"><a href="/admin/products" class="waves-effect"><i class="icon-basket icons"></i><span>محصولات</span></a></li>
            <li class="@if(@$Active=="brands")active @endif"><a href="/admin/brands" class="waves-effect">  <i class="icon-tag icons"></i> <span>برندها</span></a></li>
    <li class="@if(@$Active=="categories")active @endif"><a href="/admin/categories" class="waves-effect">  <i class="icon-puzzle icons"></i> <span>دسته بندی ها</span></a></li>
            <li><a href="/logout" class="waves-effect">  <i class="fa fa-share"></i> <span>خروج</span></a></li>
        </ul>

    </div>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <header class="topbar-nav">
        <nav id="header-setting" class="navbar navbar-expand fixed-top">
            <ul class="navbar-nav align-items-center right-nav-link">
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                        <span class="user-profile">

                            <img @if(@Auth::user()->avatar!="") src="{{asset(Auth::user()->avatar)}}" @else src="{{asset('admin/images/user.png')}}" @endif class="img-circle" alt="user avatar">
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item user-details">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3" @if(@$item->avatar!="") src="{{asset(Auth::user()->avatar)}}" @else src="{{asset('admin/images/user.png')}}" @endif alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">{{Auth::user()->name}}</h6>
                                        <p class="user-subtitle">{{Auth::user()->email}}</p>
                                    </div>
                                </div>
                            </a>
                        </li>


                        <li class="dropdown-item">
                            <a style="display: block" href="/admin/profile">
                                <i class="icon-user"></i> پروفایل
                            </a>

                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item">
                            <a style="display: block" href="/admin/settings">
                                <i class="icon-settings mr-2"></i> تنضیمات
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item">
                            <a style="display: block" href="/logout">
                                <i class="icon-power mr-2"></i> خروج
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link toggle-menu" href="javascript:void();">
                        <i class="icon-menu menu-icon"></i>
                    </a>
                </li>
            </ul>


        </nav>
    </header>
    <!--End topbar header-->

    <div class="clearfix"></div>

    <div class="content-wrapper">
        @yield('content')
    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->



    <!--start color switcher-->
    <div class="right-sidebar">
        <div class="switcher-icon">
            <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
        </div>
        <div class="right-sidebar-content">


            <p class="mb-0">Header Colors</p>
            <hr>

            <div class="mb-3">
                <button type="button" id="default-header" class="btn btn-outline-primary">Default Header</button>
            </div>

            <ul class="switcher">
                <li id="header1"></li>
                <li id="header2"></li>
                <li id="header3"></li>
                <li id="header4"></li>
                <li id="header5"></li>
                <li id="header6"></li>
            </ul>

            <p class="mb-0">Sidebar Colors</p>
            <hr>

            <div class="mb-3">
                <button type="button" id="default-sidebar" class="btn btn-outline-primary">Default Sidebar</button>
            </div>

            <ul class="switcher">
                <li id="theme1"></li>
                <li id="theme2"></li>
                <li id="theme3"></li>
                <li id="theme4"></li>
                <li id="theme5"></li>
                <li id="theme6"></li>
            </ul>

        </div>
    </div>
    <!--end color switcher-->
    <div class="overlay toggle-menu"></div>
</div><!--End wrapper-->

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

<!-- simplebar js -->
<script src="{{asset('admin/plugins/simplebar/js/simplebar.js')}}"></script>
<!-- sidebar-menu js -->
<script src="{{asset('admin/js/sidebar-menu.js')}}"></script>
<!-- loader scripts -->
<script src="{{asset('admin/js/jquery.loading-indicator.js')}}"></script>
<!-- Custom scripts -->
<script src="{{asset('admin/js/app-script.js')}}"></script>
<!-- Chart js -->

<script src="{{asset('admin/plugins/Chart.js/Chart.min.js')}}"></script>

<!-- Vector map JavaScript -->
<script src="{{asset('admin/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('admin/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- Easy Pie Chart JS -->
<script src="{{asset('admin/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<!-- Sparkline JS -->
<script src="{{asset('admin/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('admin/plugins/notifications/js/notifications.min.js')}}"></script>
<script src="{{asset('admin/plugins/notifications/js/notification-custom-script.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-knob/excanvas.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.js')}}"></script>

@yield('script_link')
<script>
    $('#check_All').click(function(){
        if(this.checked){
            $('.checkBox').each(function(){
                this.checked = true;
            })
        }else{
            $('.checkBox').each(function(){
                this.checked = false;
                $('.checkBox').parents('tr').removeClass('checked-row');
            })
        }

    });
    $('.checkBox').click(function () {
        if(this.checked) {
            $(this).parents('tr').addClass('checked-row');
        }else {
            $(this).parents('tr').removeClass('checked-row');
        }
    });

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
<script>
    $(function() {
        $(".knob").knob();
    });
    function numberToword(item) {
        var number=$(item).val();
        if (number.length>3){
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.numberToword')}}';
            var data = {_token: CSRF_TOKEN, number: number};
            $.post(url, data, function (msg) {
                $(item).parent('.form-group').find('.numberToword').html(msg.word)
            })
        }else {
            $(item).parent('.form-group').find('.numberToword').html('')
        }

    }
</script>
<!-- Index js -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js');
        });
    }
</script>
@yield('script')

<script>
    function number_3_3(num, sep) {
        var number = typeof num === "number" ? num.toString() : num,
            separator = typeof sep === "undefined" ? ',' : sep;
        return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
    }

    function delete_all_items(table) {
        var ChkBox=document.getElementsByClassName("checkBox");
        if ($(ChkBox).is(':checked')){
            var id_row = new Array();
            $('input[name="delete"]:checked').each(function() {
                id_row.push(this.value);
            });
            Lobibox.alert('error', {
                title: 'پیغام',
                msg: 'آیا حذف شود',
                delayToRemove: 200,
                width : 311,
                top: 200,
                position: "bottom right",
                showClass:'Lobibox-custom-class-confirm',
                buttons: {
                    cancel: {
                        'class': 'btn btn-danger',
                        closeOnClick: true,
                        text:'لغو'
                    },
                    yes: {
                        'class': 'btn btn-success',
                        closeOnClick: true,
                        text:'بله، حذف شود'
                    },
                },
                callback: function(lobibox, type){
                    var btnType;
                    if (type === 'yes'){

                            var CSRF_TOKEN = '{{ csrf_token() }}';
                            var url = '{{route('Ajax.delete-all-items')}}';
                            var data = {_token: CSRF_TOKEN, id: id_row,table:table};
                            $.post(url, data, function (msg) {
                                if (msg == "deleted") {
                                    id_row.forEach(function (element) {
                                        $(ChkBox).parents('#item' + element).remove()
                                    });
                                    Lobibox.notify('success', {
                                        size: 'mini',
                                        showClass: 'Lobibox-custom-class hide-close-icon',
                                        iconSource: "fontAwesome",
                                        delay:3000,
                                        soundPath: '{{asset('admin/sounds/sounds/')}}',
                                        position: 'left top', //or 'center bottom'
                                        msg: 'عملیات حذف با موفقیت انجام شد',
                                    });
                                }

                            });
                    }

                }
            });

        }else{
            Lobibox.notify('warning', {
                size: 'mini',
                rounded: true,
                soundPath: '{{asset('admin/sounds/sounds/')}}',
                sound: 'soundssound6',
                iconSource: "fontAwesome",
                delay:3000,
                showClass: 'Lobibox-custom-class hide-close-icon',
                position: 'left top', //or 'center bottom'
                msg: 'شما چیزی برای حذف انتخاب نکرده اید',

            });
        }

    }

    function delete_solo_item(tag,id,table) {

        Lobibox.alert('error', {
            title: 'پیغام',
            msg: 'آیا حذف شود',
            delayToRemove: 200,
            width : 311,
            top: 200,
            position: "bottom right",
            showClass:'Lobibox-custom-class-confirm',
            buttons: {
                cancel: {
                    'class': 'btn btn-danger',
                    closeOnClick: true,
                    text:'لغو'
                },
                yes: {
                    'class': 'btn btn-success',
                    closeOnClick: true,
                    text:'بله، حذف شود'
                },
            },
            callback: function(lobibox, type){
                var btnType;
                if (type === 'yes'){
                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('Ajax.delete-solo-item')}}';
                    var data = {_token: CSRF_TOKEN, id: id,table:table};
                    $.post(url, data, function (msg) {
                        if (msg=="deleted"){

                            Lobibox.notify('success', {
                                size: 'mini',
                                showClass: 'Lobibox-custom-class hide-close-icon',
                                iconSource: "fontAwesome",
                                delay:3000,
                                soundPath: '{{asset('admin/sounds/sounds/')}}',
                                position: 'left top', //or 'center bottom'
                                msg: 'عملیات حذف با موفقیت انجام شد',
                            });
                            $(tag).parents('tr').remove();
                            get_price();


                        }

                    });
                }

            }
        });


    }
</script>
@if(session('session-insert-update'))
    <script>
        Lobibox.notify('success', {
            size: 'mini',
            showClass: 'Lobibox-custom-class hide-close-icon',
            iconSource: "fontAwesome",
            delay:3000,
            soundPath: '{{asset('admin/sounds/sounds/')}}',
            position: 'left top', //or 'center bottom'
            msg: '{{session('session-insert-update')}}',
        });
    </script>
@endif
</body>
</html>
@php
session()->forget('session-insert-update');
@endphp
