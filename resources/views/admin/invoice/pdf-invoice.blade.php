<!doctype html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }
        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-sm {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            text-align: center;
            border-color: #212529;
            font-size: 13px;
            border-collapse: collapse;
        }
        .table.table-title{
            border: unset;
        }
        .table.table-title td,.table.table-title th{
            border: unset!important;
        }
        .table.table-title td:first-child{
            padding: 0;
            text-align: right;
        }
        .table.table-title td:last-child{
            padding: 0;
            text-align: left;
        }
        .table thead th, .table tbody td {
            border-color: #212529!important;
            vertical-align: inherit;
        }

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        div,a,p,span,h1,h2,h3,h4,h5,h6{
            font-family: vazir !important;
        }
        body{
            direction: rtl;
        }
        .pdf-row{
            width:210mm;
            margin: 0 auto;
            padding: 8px 30px 0;
            border: 5px double;
            position: relative;
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
    <div class="pdf-row">

        <div class="row">
            <table class="table table-bordered table-title">
                <thead>
                <tr>
                    <td style="text-align: right">شماره موبایل :{{setting()['mobile']}}</td>
                    <th style="font-size: 20px"><h5 style="text-align: center">{{setting()['title']}}</h5></th>
                    @php $count_date=count($factors)-1; @endphp
                    <td style="text-align: left"> تاریخ ثبت فاکتور:{{Verta::instance($factors[$count_date]->create_at)->format('Y/m/d')}}</td>

                </tr>
                </thead>
            </table>
        </div>
        <div class="row">
            <div class="col-sm" style="text-align: center">
                <img src="{{public_path(setting()['logo'])}}">
            </div>
        </div>

        <div class="row">
            <table class="table table-bordered table-title">
                <thead>
                <tr>
                    <td style="text-align: right">صورتحساب  {{$factors[0]->name}}</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: left">شماره فاکتور : {{$factors[0]->factor_id}}</td>
                </tr>
                </thead>
            </table>
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


