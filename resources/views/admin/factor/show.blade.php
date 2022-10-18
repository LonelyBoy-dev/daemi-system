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
        content: "نام محصول";
    }

    .limiter table tbody tr td:nth-child(3):before {
        content: "توضیحات";
    }

    .limiter table tbody tr td:nth-child(4):before {
        content: "تعداد";
    }

    .limiter table tbody tr td:nth-child(5):before {
        content: "قیمت واحد(تومان)";
    }

    .limiter table tbody tr td:nth-child(6):before {
        content: "درصد تخفیف";
    }

    .limiter table tbody tr td:nth-child(7):before {
        content: "قیمت کل(تومان)";
    }


    .limiter table tbody tr td:nth-child(7) a, .limiter table tbody tr td:nth-child(7) button {
        padding: 5px;
    }

    @media screen and (max-width: 992px) {
        .limiter table tbody tr td {
            padding-right: 42% !important;
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
        display: block;
        position: fixed;
        z-index: 1;
        top: 7px;
        left: 8px;
        font-size: 13px;
        padding: 5px;
    }
</style>
<body>
<div class="container">
    <a href="/admin/factors" type="button" class="back-button-mobile btn btn-dark waves-effect waves-light m-1"> بازگشت </a>
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
                                <th class="column1" style="width: 100px">ردیف</th>
                                <th class="column2" style="width: 100px">نام محصول</th>
                                <th class="column3">توضیحات</th>
                                <th class="column4">تعداد</th>
                                <th class="column5">قیمت واحد(تومان)</th>
                                <th class="column6">درصد تخفیف</th>
                                <th class="column7">قیمت کل(تومان)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $row=1;$count=[];$Total=[];$price=[];$discount=[] @endphp
                            @foreach($factors as $item)
                                <tr>
                                    <td class="column1" scope="row">{{$row}}</td>
                                    @php $brand=\App\Models\Brand::find(@$item->product->brand_id); @endphp
                                    <td class="column2" colspan="2"
                                        style="text-align: right">{{@$item->product->title}}@if(@$brand->title!=""){{' - '.@$brand->title}} @endif @if(@$item->product->content!=""){{' - '.@$item->product->content}}@endif</td>

                                    <td class="column3">{{$item->count}}</td>
                                    <td class="column4">{{number_format($item->price)}}</td>
                                    <td class="column5">@if(@$item->discount!=""){{@$item->discount.' % '}} @endif</td>
                                    <td class="column6">{{number_format($item->price*$item->count)}}</td>

                                </tr>
                                @php
                                    $row++;
                                            if (@$item->discount!="") {
                                                $total_price = ($item->price*$item->count) * (100 - @$item->discount) / 100;
                                                $discount[]=($item->price*$item->count) * (100 - @$item->discount) / 100;
                                            }
                                    $Total[]=$item->price*$item->count;
                                    $count[]=$item->count;
                                    $price[]=$item->price;
                                    //$discount[]=$item->price*$item->count-$item->total_discount_price;
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
                <td>جمع تعداد</td>
                <td>{{array_sum($count)}}</td>
            </tr>
            <tr>
                <td>جمع کل</td>
                <td>{{number_format(array_sum($Total)).' تومان '}}</td>
            </tr>
            <tr>
                <td>هزینه نصب و اجرا :

                <td>@php
                        if (@$factors[0]->install!="" and $factors[0]->install!=0){
                                    $install=array_sum(@$Total)*$factors[0]->install/100;

                                }elseif (@$factors[0]->install_toman!="" and $factors[0]->install_toman!=0){
                                    @$install=$factors[0]->install_toman;
                                }else{
                                 $install=array_sum(@$Total)*setting()['install|setup']/100;
                                }

                    @endphp
                  {{number_format($install).' تومان '}}
                    </td>
            </tr>

            <tr>
                <td>مبلغ کل (قیمت اجناس و هزینه اجرا و
                    نصب ) :</td>
                <td> <?php
                    if (@$factors[0]->install != "" and $factors[0]->install != 0) {
                        $Total = array_sum(@$Total) + (array_sum(@$Total) * $factors[0]->install) / 100;
                    }elseif (@$factors[0]->install_toman != "" and $factors[0]->install_toman != 0) {
                        $Total = array_sum(@$Total) + $factors[0]->install_toman;
                    } else {
                        $Total = array_sum(@$Total) + (array_sum(@$Total) * setting()['install|setup']) / 100;
                    }
                    ?>
                    <span style="padding: 0;margin: 0">
                                        <span id="total">{{number_format($Total)}}</span>
                                        تومان
                                    </span></td>
            </tr>

            <tr>
                <td>جمع تخفیف</td>
                <td> <h6 style="padding: 0;margin: 0">
                        @php
                            $sum_dis=$Total-array_sum($discount)-$factors[0]->Total;
                                    $all_discount=array_sum(@$discount);
                        @endphp
                        <span style="font-weight: 700"
                              id="Total">{{number_format(@$all_discount+$sum_dis)}}</span>
                        تومان
                    </h6></td>
            </tr>

            <tr>
                <td>مبلغ پرداختی</td>
                <td><h6 style="padding: 0;margin: 0">{{number_format($factors[0]->Total)}} تومان </h6></td>
            </tr>
            <tr>
                <td>مبلغ به حروف</td>
                @php $Number2Word=new Number2Word();$Number2Word=$Number2Word->numberToWords($factors[0]->Total).'(تومان)' @endphp
                <td><h6 style="padding: 0;margin: 0">{{$Number2Word}}</h6></td>
            </tr>
        </table>
    </div>

    <div class="row footer-bottom">
        <a style="width: 100%" href="/admin/factor/factor-pdf/{{$factors[0]->factor_id}}"
           class="btn btn-warning waves-effect waves-light m-1">ذخیره فاکتور</a>
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

            div, a, p, span, h1, h2, h3, h4, h5, h6 {
                font-family: Vazir !important;
            }

            body {
                direction: rtl;
            }

            .pdf-row {
                width: 210mm;
                margin: 0 auto;
                padding: 8px 30px 0;
                border: 5px double;
                /*height:297mm;*/
            }


            table {
                text-align: center;
                border-color: #212529;
                font-size: 13px;
            }

            .table thead th, .table tbody td {
                border-color: #212529 !important;
                vertical-align: inherit;
            }

            .logo {
                text-align: center;
            }

            .mobile {
                position: absolute;
                right: 0;
                font-size: 12px;
                font-weight: 700;
            }

            .date {
                position: absolute;
                left: 0;
                font-size: 12px;
                font-weight: 700;
            }

            .mohr-emza {
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
            <a href="/admin/factor/factor-pdf/{{$factors[0]->factor_id}}"
               class="btn btn-warning waves-effect waves-light m-1">ذخیره فاکتور</a>
        </div>
        <div class="pdf-row">
            <div class="row">
                <div class="col-sm">
                    <span class="mobile">شماره موبایل :{{setting()['mobile']}}</span>
                    @php $count_date=count($factors)-1; @endphp
                    <span
                        class="date"> تاریخ ثبت :{{Verta::instance($factors[0]->created_at)->format('Y/m/d')}}</span>
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
                    <span>فاکتور {{$factors[0]->name}}</span>
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
                            <th scope="col">نام محصول</th>
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
                                <td colspan="2"
                                    style="text-align: right">{{@$item->product->title}}@if(@$brand->title!=""){{' - '.@$brand->title}} @endif @if(@$item->product->content!=""){{' - '.@$item->product->content}}@endif</td>

                                <td>{{$item->count}}</td>
                                <td>{{number_format($item->price)}}</td>
                                <td>@if(@$item->discount!=""){{@$item->discount.' % '}} @endif</td>
                                <td>{{number_format($item->price*$item->count)}}</td>

                            </tr>
                            @php
                                $row++;
                                        if (@$item->discount!="") {
                                            $total_price = ($item->price*$item->count) * (100 - @$item->discount) / 100;
                                            $discount[]=($item->price*$item->count) * (100 - @$item->discount) / 100;
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
                            <td colspan="3">هزینه نصب و اجرا :

                               
                            </td>
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
                            <td colspan="3" style="padding-top: 3%" scope="row">مبلغ کل (قیمت اجناس و هزینه اجرا و
                                نصب ) :
                            </td>
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
                            <td style="position: relative;vertical-align: unset;text-align: right;" colspan="3"
                                rowspan="2">
                                <div style="width: 90%">
                                    مبلغ فاکتور : {{$Number2Word}}
                                </div>
                                <div class="mohr-emza">مهر و امضا</div>
                                <span style="position: absolute;left: 5px;top: 13px">جمع تخفیف</span>
                            </td>
                            <td colspan="4">
                                <h6 style="padding: 0;margin: 0">
                                    @php
                                        $sum_dis=$Total-array_sum($discount)-$factors[0]->Total;
                                                $all_discount=array_sum(@$discount);
                                    @endphp
                                    <span style="font-weight: 700"
                                          id="Total">{{number_format(@$all_discount+$sum_dis)}}</span>
                                    تومان
                                </h6>
                            </td>
                        </tr>


                        <tr>
                            <td colspan="4">
                                <h6 style="padding: 0;margin: 0">
                                    مبلغ پرداختی
                                    <span style="font-weight: 700"
                                          id="Total">{{number_format($factors[0]->Total)}}</span>
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


@endif
