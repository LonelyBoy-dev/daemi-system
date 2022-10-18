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
                    <td style="text-align: left"> تاریخ ثبت فاکتور:{{Verta::instance($factors[$count_date]->created_at)->format('Y/m/d')}}</td>

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
                        <th scope="col">نام محصول </th>
                        <th scope="col">توضیحات</th>
                        <th scope="col">تعداد</th>
                        <th scope="col">قیمت واحد(تومان)</th>
                        <th scope="col">درصد تخفیف</th>
                        <th scope="col">قیمت کل(تومان)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $row=1;$count=[];$Total=[];$price=[];$discount=[] @endphp
                    @foreach($factors as $item)
                        <tr>
                            <td scope="row">{{$row}}</td>
                            @php $brand=\App\Models\Brand::find(@$item->product->brand_id); @endphp
                            <td colspan="2" style="text-align: right">{{@$item->product->title}}@if(@$brand->title!=""){{' - '.@$brand->title}} @endif @if(@$item->product->content!=""){{' - '.@$item->product->content}}@endif</td>

                            <td>{{$item->count}}</td>
                            <td>{{number_format($item->price)}}</td>
                            <td>@if($item->discount!=""){{$item->discount.' % '}} @endif</td>
                            <td>{{number_format($item->price*$item->count)}}</td>

                        </tr>
                        @php
                            $row++;
                                    if ($item->discount!="") {
                                        $total_price = ($item->price*$item->count) * (100 - $item->discount) / 100;
                                        $discount[]=($item->price*$item->count) * (100 - $item->discount) / 100;
                                    }
                            $Total[]=$item->price*$item->count;
                            $count[]=$item->count;
                            $price[]=$item->price;
                            //$discount[]=$item->price*$item->count-$item->total_discount_price;
                        @endphp
                    @endforeach
                    </tbody>
                    <tbody style="border-top: 5px solid #0a0b0b!important;">

                    <tr>
                        <td colspan="3">جمع کل</td>
                        <td>{{array_sum($count)}}</td>
                        <td>***</td>
                        <td colspan="2">{{number_format(array_sum($Total)).' تومان '}}</td>
                    </tr>

                    <tr>
                        <td colspan="3">درصد از مبلغ کل اجناس</td>
                        <td colspan="5">
                            @php
                                if (@$factors[0]->install!="" and $factors[0]->install!=0){
                                            $install=array_sum(@$Total)*$factors[0]->install/100;

                                        }elseif (@$factors[0]->install_toman!="" and $factors[0]->install_toman!=0){
                                            @$install=$factors[0]->install_toman;
                                        }else{
                                         $install=array_sum(@$Total)*setting()['install|setup']/100;
                                        }

                            @endphp
                            <span id="install">{{number_format($install)}}</span>
                            تومان
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding-top: 3%" scope="row">مبلغ کل (قیمت اجناس و هزینه نصب و اجرا ) :</td>
                        <td colspan="4">
                            <?php
                            if (@$factors[0]->install!="" and $factors[0]->install!=0){
                                $Total = array_sum(@$Total) + (array_sum(@$Total) * $factors[0]->install) / 100;
                            }elseif (@$factors[0]->install_toman!="" and $factors[0]->install_toman!=0){
                                $Total = array_sum(@$Total) + $factors[0]->install_toman;
                            } else {
                                $Total = array_sum(@$Total) + (array_sum(@$Total) * setting()['install|setup']) / 100;
                            }

                            ?>
                            <span style="padding: 0;margin: 0">
                                        مبلغ کل
                                        <span id="total">{{number_format($Total)}}</span>
                                        تومان
                                    </span>

                        </td>
                    </tr>

                    <tr>
                        @php $Number2Word=new Number2Word();$Number2Word=$Number2Word->numberToWords($factors[0]->Total).'(تومان)' @endphp
                        <td style="position: relative;vertical-align: unset;text-align: right;" colspan="3" rowspan="2">
                            <div style="width: 90%;float: right">
                                مبلغ فاکتور : {{$Number2Word}}
                            </div>
                            <br>
                            <br>
                            <center class="mohr-emza" style="float: right;margin-top: 20px">مهر و امضا</center>
                        </td>
                        <td colspan="4">
                            <h6 style="padding: 0;margin: 0">
                                @php
                                    $sum_dis=$Total-array_sum($discount)-$factors[0]->Total;
                                            $all_discount=array_sum($discount);
                                @endphp
                                جمع تخفیف
                                <span style="font-weight: bold;font-size: 15px" id="Total">{{number_format(@$all_discount+$sum_dis)}}</span>
                                تومان
                            </h6>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="4">
                            <h6 style="padding: 0;margin: 0">
                                مبلغ پرداختی
                                <span style="font-weight: bold;font-size: 15px" id="Total">{{number_format($factors[0]->Total)}}</span>
                                تومان
                            </h6>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>


