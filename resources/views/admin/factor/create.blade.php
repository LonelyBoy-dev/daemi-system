@extends('admin.layout.master')
@section('style_link')
    <link href='{{asset('admin/css/select2.min.css')}}' rel='stylesheet' type='text/css'>
@endsection
@section('style')
    <style>
        .invalid-feedback {
            display: block;
        }

        .select2-container {
            border-radius: 5px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #3a3b3c;
            border: 1px solid #3a3b3c;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
        }

        .select2-selection--single .select2-selection__arrow {
            top: 4px !important;
            right: auto;
            left: 1px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            line-height: 24px;
            padding-right: 0px;
            font-size: 1rem;
            font-weight: 400;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #242526;
            color: white;
            text-align: right;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid rgba(255, 255, 255, 0.06);
            background-color: #3a3b3c;
            color: #e4e6eb !important;
            border-radius: .25rem;
            text-align: right;
        }

        .select2-dropdown {
            background-color: #242526;
        }

        .select2-results__option {
            direction: rtl;
            text-align: right;
        }

        .factor-row {
            display: flex;
        }

        .table td, .table th {
            white-space: unset;
        }

        .table-responsive {
            white-space: unset;
        }

        .table {
            font-size: 13px;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #ddd0;
            color: #fff;
        }

        .select2-results__options li:hover {
            background-color: #fff;
            color: #555;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #f2f4f5;
            color: #130d0d;
        }
    </style>

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="zmdi zmdi-layers"></i>افزودن فاکتور جدید</h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/factors">
                    <span class="ti-arrow-left"></span>
                </a>

            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('factors.store')}}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="display: flow-root;">
                            <div style="float: right" class="card-title">ایجاد فاکتور</div>
                            @if(count($factor_row)>0)
                                <span style="float: left;cursor: pointer" id="cancel-factor-row"
                                      class="btn btn-secondary" title="لغو">لغو</span>
                            @endif
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="input-1">دسته بندی محصول</label>
                                    <div class="form-group">
                                        <select class="form-control" id="category" name="category" required
                                                onchange="products()">
                                            <option>دسته بندی محصول را انتخاب کنید</option>
                                            @foreach($categories as $item)
                                                <option @if(old('category')==$item->id)selected
                                                        @endif value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                        <div id="product-error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="input-1">نام محصول</label>
                                    <div class="form-group">
                                        <select class="form-control" id="product" name="product" required
                                                onchange="remove_css_product()">
                                            <option>دسته بندی محصول را انتخاب کنید</option>
                                        </select>
                                        <div id="product-error"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="input-count">تعداد</label>
                                    <input type="number" onkeyup="remove_css_count()" name="count" class="form-control"
                                           id="input-count" value="{{old('count')}}"
                                           placeholder="تعداد محصول را وارد کنید">
                                    <div id="product-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="input-price">قیمت(تومان)</label>
                                    <input type="number" onkeyup="numberToword(this)" name="price" class="form-control"
                                           id="input-price" value="{{old('price')}}"
                                           placeholder="قیمت را در صوردت تغییر وارد کنید">
                                    <span class="numberToword"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="input-discount">میزان تخفیف(درصد)</label>
                                    <input type="number" name="discount" class="form-control" id="input-discount"
                                           value="{{old('discount')}}" placeholder="میزان تخفیف محصول را وارد کنید">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <input type="button" id="sabt" class="btn btn-primary float-left" value="ثبت">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام محصول</th>
                                <th scope="col">توضیحات</th>
                                <th scope="col">تعداد</th>
                                <th scope="col">قیمت واحد(تومان)</th>
                                <th scope="col">تخفیف(درصد)</th>
                                <th scope="col">قیمت کل(تومان)</th>
                                <th scope="col">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $Total=[];$row=1;$count=[];$sum_price=[];$price=[];$discount=[] @endphp
                            @foreach($factor_row as $item)
                                <tr>
                                    <th scope="row">{{$row}}</th>
                                    <td colspan="2">{{@$item->product->title}}
                                        @php @$brand=\App\Models\Brand::find(@$item->product->brand_id); @endphp
                                        @if($brand!=""){{' - '.@$brand->title}} @endif @if(@$item->product->content!=""){{' - '.@$item->product->content}} @endif</td>
                                    <td>{{$item->count}}</td>
                                    <td>{{number_format($item->price)}}</td>
                                    <td>@if($item->discount!=""){{$item->discount.' % '}} @endif</td>
                                    <td>{{number_format($item->price*$item->count)}}</td>
                                    <td>
                                        <button style="padding: 5px"
                                                onclick="delete_solo_item(this,'{{$item->id}}','{{$table}}')"
                                                type="button" class="btn btn-outline-danger waves-effect waves-light">
                                            <span>حذف</span><i class="fa fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                @php
                                    $row++;
                                    $total_price=$item->price*$item->count;
                                    if ($item->discount!="") {
                                        $discount[]=$total_price-($item->price*$item->count) * (100 - $item->discount) / 100;
                                    }

                                    $Total[]=$item->price*$item->count;
                                    $count[]=$item->count;
                                    $price[]=$item->price;
                                    $sum_price[]=$item->price*$item->count;

                                @endphp
                            @endforeach

                            </tbody>
                            <tbody style="border-top: 5px solid #0a0b0b!important;">

                            <tr>
                                <td colspan="3">جمع کل</td>
                                <td id="count">{{array_sum($count)}}</td>
                                <td>***</td>
                                <td colspan="3"><span id="sum_price"
                                                      data-price="{{array_sum($sum_price)}}">{{number_format(array_sum($sum_price))}}</span>
                                    تومان
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">هزینه نصب و اجرا : <span id="install_default"
                                                                       data-price="0"></span>
                                </td>
                                <td colspan="6">
                                    @php $install=array_sum(@$sum_price)*setting()['install|setup']/100; @endphp
                                    <span id="install">{{number_format($install)}}</span>
                                    تومان
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" scope="row">مبلغ کل (قیمت اجناس و هزینه نصب و اجرا ) :</td>
                                <td colspan="5">
                                    <?php
                                    $Total = array_sum(@$sum_price) + $install;
                                    ?>
                                    <span style="padding: 0;margin: 0">
                                        مبلغ کل
                                        <span id="total" data-price="{{$Total}}">{{number_format($Total)}}</span>
                                        تومان
                                    </span>

                                </td>
                            </tr>

                            <tr>
                                @php if (count($factor_row)){ $Number2Word=new Number2Word();@$Number2Word=@$Number2Word->numberToWords($factors[0]->Total).'(تومان)';} @endphp
                                <td style="position: relative;vertical-align: unset;text-align: right;" colspan="3"
                                    rowspan="2">
                                    <div style="width: 90%">
                                        مبلغ فاکتور : <span id="hrofi">{{@$Number2Word}}</span>
                                    </div>

                                    <span style="position: absolute;left: 5px;top: 13px">جمع تخفیف</span>
                                </td>
                                <td colspan="5">
                                    <h6 style="padding: 0;margin: 0">
                                        @php
                                            $all_discount=array_sum(@$discount);
                                        @endphp
                                        <span style="font-weight: 700" data-price="{{$all_discount}}"
                                              id="all_discount">{{number_format(@$all_discount)}}</span>
                                        تومان
                                    </h6>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="5">
                                    <h6 style="padding: 0;margin: 0">
                                        مبلغ پرداختی
                                        <span style="font-weight: 700" data-price="{{$Total-$all_discount}}"
                                              id="Total">{{number_format($Total-$all_discount)}}</span>
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

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{route('factors.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="factor-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div class="row">
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="input-name">نام خریدار</label>
                                                           <input type="text" name="name"
                                                                  class="form-control @error('name') is-invalid @enderror"
                                                                  id="input-name" value="{{old('name')}}"
                                                                  placeholder="نام خریدار را وارد کنید">
                                                           @error('name')
                                                           <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                           @enderror
                                                       </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="input-name"> کد مشتری</label>
                                                           <input type="text" name="member_id"
                                                                  class="form-control @error('member_id') is-invalid @enderror"
                                                                  id="input-name" value="{{old('member_id')}}"
                                                                  placeholder="کد مشتری را وارد کنید">
                                                           @error('member_id')
                                                           <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                           @enderror
                                                       </div>
                                                   </div>
                                               </div>
                                            </div>

                                            <div class="col-md-10">
                                               <div class="row">
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="input-1-install">هزینه نصب و اجرا(درصد)</label>
                                                           <input type="text" onkeyup="change_price_install(this)"
                                                                  name="install" class="form-control" id="input-1-install"
                                                                  value="{{old('install')}}"
                                                                  placeholder="هزینه اجرا و نصب را وارد کنید">
                                                           <span class="numberToword"></span>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="input-1-install_toman">هزینه نصب و اجرا(تومان)</label>
                                                           <input type="text" onkeyup="change_price_install(this)"
                                                                  name="install_toman" class="form-control"
                                                                  id="input-1-install_toman" value="{{old('install_toman')}}"
                                                                  placeholder="هزینه اجرا و نصب را وارد کنید">
                                                           <span class="numberToword"></span>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label for="input-Total_discount">میزان تخفیف از مبلغ نهایی</label>
                                                           <input type="text" onkeyup="change_price(this)"
                                                                  name="Total_discount" class="form-control"
                                                                  id="input-Total_discount" value="{{old('Total_discount')}}"
                                                                  placeholder="میزان تخفیف را وارد کنید">
                                                           <span class="numberToword"></span>
                                                       </div>
                                                   </div>
                                               </div>
                                            </div>
                                            <div class="col-md-2 col-xs-12">
                                                <div class="col-md-12">
                                                    <input style="margin-top: 30px" type="submit"
                                                           class="btn btn-primary float-left" value="ثبت فاکتور">
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
@section('script_link')
    <script src='{{asset('admin/js/jquery-3.2.1.min.js')}}' type='text/javascript'></script>
    <script src='{{asset('admin/js/select2.min.js')}}' type='text/javascript'></script>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#brand").select2();
            $("#product").select2();
            $("#category").select2();
        });
    </script>
    <script>
        function number_3_3(num, sep) {
            var number = typeof num === "number" ? num.toString() : num,
                separator = typeof sep === "undefined" ? ',' : sep;
            return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
        }

        $('#sabt').click(function () {
            var invalid = false;
            var product = $('select[name=product]').val();
            var count = $('input[name=count]').val();
            var price = $('input[name=price]').val();
            var discount = $('input[name=discount]').val();

            if (product === "" || product === "محصول را انتخاب کنید") {
                invalid = true;
                $('#product-error').html('<span class="invalid-feedback" role="alert"><strong>محصول را انتخاب کنید</strong></span>');
                $('.select2-container').css('border', '1px solid red')
            } else {
                $('#product-error').empty();
                $('.select2-container').css('border', 'unset');
            }


            if (count === "") {
                invalid = true;
                $('#count-error').html('<span class="invalid-feedback" role="alert"><strong>تعداد را وارد کنید</strong></span>');
                $('input[name=count]').css('border', '1px solid red');
            } else {
                $('#count-error').empty();
                $('input[name=count]').css('border', 'unset');
            }


            if (invalid === false) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Ajax.set-factor-row')}}';
                var data = {_token: CSRF_TOKEN, product: product, count: count, price: price, discount: discount};
                $.post(url, data, function (msg) {
                   if(msg.count!="NoCount"){
                       $('input[name=count]').parent('.form-group').find('#product-error').html(' ')
                       $('table').append('<tr><th scope="row">' + msg.row + '</th><td colspan="2">' + msg.product.title + '' + msg.brand + '</td><td>' + msg.count + '</td><td>' + number_3_3(msg.price) + '</td><td>' + msg.discount + ' % </td><td>' + number_3_3(msg.total_price) + '</td><td><button style="padding: 5px" onclick="delete_solo_item(this,' + msg.id + ',' + msg.table + ')" type="button" class="btn btn-outline-danger waves-effect waves-light delete-factor-row">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button></td></tr>');
                       $('input[name=count]').val('');
                       $('input[name=price]').val('');
                       $('input[name=discount]').val('');
                       $('.delete-factor-row').click(function () {
                           var tag = this;
                           var table = msg.table;
                           var id = msg.id;
                           Lobibox.alert('error', {
                               title: 'پیغام',
                               msg: 'آیا حذف شود',
                               delayToRemove: 200,
                               width: 311,
                               top: 200,
                               position: "bottom right",
                               showClass: 'Lobibox-custom-class-confirm',
                               buttons: {
                                   cancel: {
                                       'class': 'btn btn-danger',
                                       closeOnClick: true,
                                       text: 'لغو'
                                   },
                                   yes: {
                                       'class': 'btn btn-success',
                                       closeOnClick: true,
                                       text: 'بله، حذف شود'
                                   },
                               },
                               callback: function (lobibox, type) {
                                   var btnType;
                                   if (type === 'yes') {
                                       var CSRF_TOKEN = '{{ csrf_token() }}';
                                       var url = '{{route('Ajax.delete-solo-item')}}';
                                       var data = {_token: CSRF_TOKEN, id: id, table: table};
                                       $.post(url, data, function (msg) {
                                           get_price()
                                           if (msg == "deleted") {
                                               Lobibox.notify('success', {
                                                   size: 'mini',
                                                   showClass: 'Lobibox-custom-class hide-close-icon',
                                                   iconSource: "fontAwesome",
                                                   delay: 3000,
                                                   soundPath: '{{asset('admin/sounds/sounds/')}}',
                                                   position: 'left top', //or 'center bottom'
                                                   msg: 'عملیات حذف با موفقیت انجام شد',
                                               });
                                               $(tag).parents('tr').remove();
                                           }

                                       });
                                   }

                               }
                           });


                       })
                       get_price();
                   }else{
                       $('input[name=count]').css('border','1px solid red;');
                       $('input[name=count]').parent('.form-group').find('#product-error').html('<span class="invalid-feedback" role="alert"><strong>فقط '+msg.depot+' عدد از محصول موجود می باشد</strong></span>');
                   }


                });
            }
        });

        function remove_css_count() {
            var count = $('input[name=count]').val();
            if (count === "") {
                $('#count-error').html('<span class="invalid-feedback" role="alert"><strong>تعداد را وارد کنید</strong></span>');
                $('input[name=count]').css('border', '1px solid red');
            } else {
                $('#count-error').empty();
                $('input[name=count]').css('border', 'unset');
            }
        }

        function remove_css_product() {
            var product = $('select[name=product]').val();

            if (product === "" || product === "محصول را انتخاب کنید") {
                $('#product-error').html('<span class="invalid-feedback" role="alert"><strong>محصول را انتخاب کنید</strong></span>');
                $('.select2-container').css('border', '1px solid red')
            } else {
                $('#product-error').empty();
                $('.select2-container').css('border', 'unset');
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Ajax.get-product-price')}}';
                var data = {_token: CSRF_TOKEN, id: product};
                $.post(url, data, function (msg) {
                    $('input[name=price]').val(msg)
                })
            }
        }

        function products() {
            var id = $('select[name=category]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.get-product')}}';
            var data = {_token: CSRF_TOKEN, id: id};
            $.post(url, data, function (msg) {
                $('select[name=product]').html(msg)
            })
        }
    </script>
    <script>
        $('#cancel-factor-row').click(function () {
            Lobibox.alert('error', {
                title: 'پیغام',
                msg: 'آیا حذف شود',
                delayToRemove: 200,
                width: 311,
                top: 200,
                position: "bottom right",
                showClass: 'Lobibox-custom-class-confirm',
                buttons: {
                    cancel: {
                        'class': 'btn btn-danger',
                        closeOnClick: true,
                        text: 'لغو'
                    },
                    yes: {
                        'class': 'btn btn-success',
                        closeOnClick: true,
                        text: 'بله، حذف شود'
                    },
                },
                callback: function (lobibox, type) {
                    var btnType;
                    if (type === 'yes') {
                        window.location.href = '/admin/factors/delete-factor-row';
                    }
                }
            })
        })
    </script>
    <script>
        change_price()

        function change_price(item) {
            numberToword(item)
            $('#all_discount').empty();
            var discount = $(item).val();
            var price = $('#Total').attr('data-price');
            var all_discount = $('#all_discount').attr('data-price');
            var install = $('input[name=install]').val();
            var total;
            if (discount !== "" && discount !== 0) {

                total = parseInt(price) - discount
                if (parseInt(all_discount) !== 0) {
                    all_discount = parseInt(all_discount) + parseInt(discount);
                    $('#all_discount').text(number_3_3(all_discount))
                } else {
                    $('#all_discount').text(number_3_3(parseInt(discount)));
                }
            } else {
                total = price;
                $('#all_discount').text(number_3_3(all_discount));
            }
            if (install === "") {
                $('#Total').html(number_3_3(total))
            } else {
                change_price_install();
            }

        }

        function get_price() {
            var discount = $('input[name=Total_discount]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.get-price-factor-row')}}';
            var data = {_token: CSRF_TOKEN, discount: discount};
            $.post(url, data, function (msg) {
                $('#sum_price').html(number_3_3(msg.sum_price));
                $('#sum_price').attr('data-price', msg.sum_price);
                $('#count').html(msg.count);
                $('#all_discount').html(number_3_3(msg.all_discount));
                $('#all_discount').attr('data-price', msg.all_discount);
                $('#install').html(number_3_3(msg.install));
                $('#total').html(number_3_3(msg.total));
                $('#Total').html(number_3_3(msg.Total));
                $('#Total').attr('data-price', msg.Total);
                change_price_install();
            })
        }

        change_price_install();

        function change_price_install() {
            var install = $('input[name=install]').val();
            var install_toman = $('input[name=install_toman]').val();
            var Total_discount = $('input[name=Total_discount]').val();
            var install_default = $('#install_default').attr('data-price');
            var sum_price = $('#sum_price').attr('data-price');
            var total = $('#total').attr('data-price');
            var Total = $('#Total').attr('data-price');
            var all_discount = $('#all_discount').attr('data-price');

            if (install !== "") {
                //$('#install_default').text(install)
                $('#install').text(number_3_3(parseInt(sum_price) * parseInt(install) / 100));
                install = parseInt(sum_price) * parseInt(install) / 100;
                $('#total').text(number_3_3(parseInt(sum_price) + install));
                if (Total_discount === "") {
                    $('#Total').text(number_3_3(parseInt(sum_price) + install - all_discount));
                } else {
                    Total = parseInt(sum_price) + install - all_discount;
                    $('#Total').text(number_3_3(Total - parseInt(Total_discount)));
                }
            }else if(install_toman!==""){
                if (install_toman.length>3) {
                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('Ajax.numberToword')}}';
                    var data = {_token: CSRF_TOKEN, number: install_toman};
                    $.post(url, data, function (msg) {
                        $('input[name=install_toman]').parent('.form-group').find('.numberToword').html(msg.word)
                    })
                }
                //$('#install_default').text(install_toman)
                $('#install').text(number_3_3(parseInt(install_toman)));
                install_toman = parseInt(install_toman);
                $('#total').text(number_3_3(parseInt(sum_price) + install_toman));
                if (Total_discount === "") {
                    $('#Total').text(number_3_3(parseInt(sum_price) + install_toman - all_discount));
                } else {
                    Total = parseInt(sum_price) + install_toman - all_discount;
                    $('#Total').text(number_3_3(Total - parseInt(Total_discount)));
                }
            } else {
                //$('#install_default').text(install_default);
                $('#install').text(number_3_3(parseInt(sum_price) * parseInt(install_default) / 100));
                $('#total').text(number_3_3(total));
                $('#Total').text(number_3_3(Total));
            }


        }
    </script>
@endsection
