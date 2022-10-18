@php $agent=new Jenssegers\Agent\Agent();@endphp
@if ($agent->isMobile())


    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاکتور شماره {{$factors[0]->factor_id}}</title>
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/css/table.mobile.css')}}" rel="stylesheet"/>
</head>
<style>
    .limiter table tbody tr td:nth-child(1):before {
        content: "ردیف";
    }

    .limiter table tbody tr td:nth-child(2):before {
        content: "تاریخ";
    }

    .limiter table tbody tr td:nth-child(3):before {
        content: "توضیحات";
    }

    .limiter table tbody tr td:nth-child(4):before {
        content: "مبلغ فاکتور";
    }

    .limiter table tbody tr td:nth-child(5):before {
        content: "مبلغ پرداختی(تومان)";
    }


    .limiter table tbody tr td:nth-child(6):before {
        content: "باقی مانده(تومان)";
    }


    .limiter table tbody tr td:nth-child(7) a, .limiter table tbody tr td:nth-child(7) button {
        padding: 5px;
    }

    @media screen and (max-width: 992px) {
        .limiter table tbody tr td {
            padding-right: 52% !important;
        }
        .limiter table tbody tr {
            padding: 14px 0;
        }
    }

    .container-table100 {
        min-height: auto
    }

    .limiter table {
        background: #fff;
    }

    tbody tr:nth-child(even) {
        background-color: #f1f1f1a8;
    }

    .row.header-top {
        text-align: right;
        border: 2px solid;
        margin: 5px -10px;
        padding: 5px 10px;
        font-weight: 500;
        border-radius: 3px;
    }



    .row.header-top div,.row.footer-bottom div{
        text-align: right;
        width: 100%;
    }
    .row.footer-bottom {
        text-align: right;
        border: 2px solid;
        margin: 5px -10px;
        font-weight: 500;
        border-radius: 3px;
    }

    .table100 table {
        border: 2px solid;
        margin: 5px -5px 0 5px;
        border-radius: 3px;
        width: 97%;
    }

    table tbody tr {
        border-bottom: 1px solid;
    }
    .table-all-count{
        direction: rtl;
        margin-bottom: 0;
        text-align: center;
    }
    .table-all-count td:first-child{
        border-left: 1px solid;
        width: 50%;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .back-button-mobile{
        display: none;
    }
    @media screen and (max-width: 992px) {
        .back-button-mobile{
            display: block;
            position: fixed;
            z-index: 1;
            top: 7px;
            left: 8px;
            font-size: 13px;
            padding: 5px;
        }
    }
</style>
<body>
<div class="container">
    <a href="/admin/invoice/{{$factors[0]->factor_id}}" type="button" class="back-button-mobile btn btn-dark waves-effect waves-light m-1"> بازگشت </a>
    <div class="row header-top">
        <div class="col-xs-6"><span>فاکتور {{$factors[0]->name}}</span></div>
        <div class="col-xs-6"><span>شماره فاکتور : {{$factors[0]->factor_id}}</span></div>
    </div>
    <div class="row">

        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">

                    <div class="table100">
                        <table>
                            <thead>
                            <tr class="table100-head">
                                <th class="column1" scope="col">ردیف</th>
                                <th class="column2" scope="col">تاریخ</th>
                                <th class="column3" scope="col">توضیحات</th>
                                <th class="column4" scope="col">مبلغ فاکتور</th>
                                <th class="column5" scope="col">مبلغ پرداختی</th>
                                <th class="column6" scope="col">باقی مانده</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $row=1; @endphp
                            @php $count_date=count($factors)-1; @endphp
                            @foreach($invoices as $item)
                                <tr>
                                    <td class="column1" scope="row">{{$row}}</td>
                                    <td class="column2">{{Verta::instance($factors[$count_date]->create_at)->format('Y/m/d')}}</td>
                                    <td class="column3">@if($item->check_id!=""){{'شماره چک: '.$item->check_id}}@endif{{' - '.$item->description}}</td>
                                    <td class="column4">{{number_format($item->price)}}</td>
                                    <td class="column5">{{number_format($item->amount_paid)}}</td>
                                    <td class="column6">{{number_format($item->remaining)}}</td>
                                </tr>
                                @php
                                    $amount_paid[]=$item->amount_paid;
                                    $price[]=$item->price;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row footer-bottom">
        <table class="table table-all-count">
            <tr>
                <td>جمع کل</td>
                <td>{{number_format(array_sum($amount_paid))}} تومان </td>
            </tr>
            <tr>
                <td>باقیمانده</td>
                <td>{{number_format($factors[0]->Total-array_sum($amount_paid))}} تومان </td>
            </tr>

        </table>
    </div>

    <div class="row footer-bottom">
        <a style="width: 100%" href="/admin/invoice/invoice-pdf/{{$factors[0]->factor_id}}"  class="btn btn-warning waves-effect waves-light m-1">ذخیره گزارش</a>
    </div>
</div>
</body>
</html>






@else

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاکتور شماره {{$factors[0]->factor_id}}</title>
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <style>
        @font-face {
            font-family: "Vazir";
            src: url("{{asset('admin/fonts/Vazir/Vazir.eot')}}");
            src: url("{{asset('admin/fonts/Vazir/Vazir.woff')}}") format("woff"),
            url('{{asset('admin/fonts/Vazir/Vazir.woff2')}}') format('woff2'),
            url('{{asset('admin/fonts/Vazir/Vazir.woff')}}') format('woff')
        }
        div,a,p,span,h1,h2,h3,h4,h5,h6{
            font-family: Vazir !important;
        }
        body{
            direction: rtl;
        }
        .pdf-row{
            width:210mm;
            margin: 0 auto;
            padding: 8px 30px 0;
            border: 5px double;
            /*height:297mm;*/
        }


        table{
            text-align: center;
            border-color: #212529;
            font-size: 13px;
        }
        .table thead th,.table tbody td{
            border-color: #212529!important;
            vertical-align: inherit;
        }
        .logo {
            text-align: center;
        }
        .mobile{
            position: absolute;
            right: 0;
            font-size: 12px;
            font-weight: 700;
        }
        .date{
            position: absolute;
            left: 0;
            font-size: 12px;
            font-weight: 700;
        }
        .mohr-emza{
            text-align: center;
            position: absolute;
            bottom: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <a href="/admin/invoice/invoice-pdf/{{$factors[0]->factor_id}}"  class="btn btn-warning waves-effect waves-light m-1">ذخیره گزارش</a>
    </div>
    <div class="pdf-row">
        <div class="row">
            <div class="col-sm">
                <span class="mobile">شماره موبایل :{{setting()['mobile']}}</span>
                @php $count_date=count($factors)-1; @endphp
                <span class="date"> تاریخ ثبت فاکتور:{{Verta::instance($factors[$count_date]->create_at)->format('Y/m/d')}}</span>
                <h5 style="text-align: center">{{setting()['title']}}</h5>

            </div>
        </div>
        <div class="row">
            <div class="col-sm" style="text-align: center">
                <img src="{{asset(setting()['logo'])}}">
            </div>
        </div>

        <div class="row">
            <div class="col-sm" style="text-align: right;padding-bottom: 10px;">
                <span>صورتحساب  {{$factors[0]->name}}</span>
            </div>
            <div class="col-sm">
                <span>شماره فاکتور : {{$factors[0]->factor_id}}</span>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ردیف</th>
                        <th scope="col">تاریخ</th>
                        <th scope="col">توضیحات</th>
                        <th scope="col">مبلغ فاکتور</th>
                        <th scope="col">مبلغ پرداختی</th>
                        <th scope="col">باقی مانده</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $row=1; @endphp
                    @foreach($invoices as $item)
                        <tr>
                            <td scope="row">{{$row}}</td>
                            <td>{{Verta::instance($factors[$count_date]->create_at)->format('Y/m/d')}}</td>
                            <td>@if($item->check_id!=""){{'شماره چک: '.$item->check_id}}@endif{{' - '.$item->description}}</td>
                            <td>{{number_format($item->price)}}</td>
                            <td>{{number_format($item->amount_paid)}}</td>
                            <td>{{number_format($item->remaining)}}</td>
                        </tr>
                        @php
                            $amount_paid[]=$item->amount_paid;
                            $price[]=$item->price;
                            @endphp
                    @endforeach
                    </tbody>
                    <tbody style="border-top: 5px solid">
                    <tr>
                        <td colspan="4">مجموع</td>
                        <td>{{number_format(array_sum($amount_paid))}} تومان </td>
                        <td>{{number_format($factors[0]->Total-array_sum($amount_paid))}} تومان </td>

                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>



@endif
