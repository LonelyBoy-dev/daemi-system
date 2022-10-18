@extends('admin.layout.master')
@section('style_link')
    <link href='{{asset('admin/css/select2.min.css')}}' rel='stylesheet' type='text/css'>
    <script src='{{asset('admin/js/sort.js')}}' type='text/javascript'></script>
@endsection

@section('style')
    <style>
        tbody tr{
            cursor: pointer;
        }
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

                <h3 class="page-title"><i class="zmdi zmdi-layers"></i>ویرایش
                    فاکتور {{@$factors[0]->factor_id.' - '.@$factors[0]->name}}</h3>
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
                                    <label for="input-product">نام محصول</label>
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
                                    <input type="number" name="price" onkeyup="numberToword(this)" class="form-control"
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
                            <input type="hidden" name="factor_id" class="form-control"
                                   value="{{@$factors[0]->factor_id}}">
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
                    <form id="sortableForm">
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



                            <tbody id="sortable" data-toggle="sortable">
                                @php $row=1;$count=[];$Total=[];$price=[];$discount=[] @endphp
                                @foreach($factors as $item)
                                    <tr>
                                        <th scope="row">{{$row}}
                                            <input name="id" type="hidden" value="{{$item->id}}">
                                        </th>
                                        @php $brand=\App\Models\Brand::find(@$item->product->brand_id); @endphp
                                        <td colspan="2"
                                            style="text-align: right">{{@$item->product->title}}@if(@$brand->title!=""){{' - '.@$brand->title}} @endif @if(@$item->product->content!=""){{' - '.@$item->product->content}}@endif</td>

                                        <td>{{$item->count}}</td>
                                        <td>{{number_format($item->price)}}</td>
                                        <td>@if($item->discount!=""){{$item->discount.' % '}} @endif</td>
                                        <td>{{number_format($item->price*$item->count)}}</td>
                                        <td>
                                            <button style="padding: 5px;width: 54px"
                                                    onclick="delete_solo_item(this,'{{$item->id}}','{{$table}}')"
                                                    type="button" class="btn btn-outline-danger waves-effect waves-light">
                                                <span>حذف</span><i class="fa fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    @php
                                        $row++;

                                            $total_price=$item->price*$item->count;
                                             if ($item->discount!="") {
                                                $discount[]=$total_price-$total_price * (100 - $item->discount) / 100;
                                            }
                                        $Total[]=$item->price*$item->count;
                                        $count[]=$item->count;
                                        $price[]=$item->price;

                                    @endphp
                                @endforeach
                            </tbody>



                            <tbody style="border-top: 5px solid #0a0b0b!important;">

                            <tr>
                                <td colspan="3">جمع کل</td>
                                <td id="count">{{array_sum($count)}}</td>
                                <td>***</td>
                                <td colspan="3"><span id="sum_price">{{number_format(array_sum($Total))}}</span> تومان
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">هزینه نصب و اجرا : <span id="install_default"></span></td>
                                <td colspan="6">
                                    @php
                                        if ($factors[0]->install!="" and $factors[0]->install!=0){
                                            $install=array_sum(@$Total)*setting()['install|setup']/100;
                                        }elseif ($factors[0]->install_toman!="" and $factors[0]->install_toman!=0){
                                        $install=$factors[0]->install_toman;
                                        }else{
                                            $install=0;
                                        }
                                    @endphp
                                    <span id="install">{{number_format($install)}}</span>
                                    تومان
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" scope="row">مبلغ کل (قیمت اجناس و هزینه نصب و اجرا ) :</td>
                                <td colspan="5">
                                    <?php
                                    $Total = array_sum(@$Total) + $install;
                                    ?>
                                    <span style="padding: 0;margin: 0">
                                        مبلغ کل
                                        <span id="total">{{number_format($Total)}}</span>
                                        تومان
                                    </span>

                                </td>
                            </tr>

                            <tr>
                                @php if ($factors[0]->Total>=0){ if (count($factors)){$Number2Word=new Number2Word();$Number2Word=$Number2Word->numberToWords(@$factors[0]->Total).'(تومان)';} }else{$Number2Word="";} @endphp
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
                                            if ($factors[0]->Total_discount!="" and $factors[0]->Total_discount>0){

                                                $all_discount=array_sum($discount)+$factors[0]->Total_discount;

                                                }else{
                                                    $all_discount=array_sum($discount);
                                                }
                                        @endphp
                                        <span style="font-weight: 700"
                                              id="Total_discount">{{number_format(@$all_discount)}}</span>
                                        تومان
                                    </h6>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="5">
                                    <h6 style="padding: 0;margin: 0">
                                        مبلغ پرداختی
                                        <span style="font-weight: 700"
                                              id="Total">{{number_format(@$factors[0]->Total)}}</span>
                                        تومان
                                    </h6>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{route('factors.update',@$factors[0]->factor_id)}}">
                    @method('PATCH')
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
                                                            <label for="input-1">نام خریدار</label>
                                                            <input type="text" name="name"
                                                                   class="form-control @error('name') is-invalid @enderror"
                                                                   id="input-1"
                                                                   value="@if(old('name')){{old('name')}}@else{{@$factors[0]->name}}@endif"
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
                                                            <label for="input-1"> کد مشتری</label>
                                                            <input type="text" name="member_id"
                                                                   class="form-control @error('member_id') is-invalid @enderror"
                                                                   id="input-1"
                                                                   value="@if(old('member_id')){{old('member_id')}}@else{{@$factors[0]->member_id}}@endif"
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
                                                                   value="@if(old('install')){{old('install')}}@else{{@$factors[0]->install}}@endif"
                                                                   placeholder="هزینه اجرا و نصب را وارد کنید">
                                                            <span class="numberToword"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="input-1-install-toman">هزینه نصب و اجرا(تومان)</label>
                                                            <input type="text" onkeyup="change_price_install(this)"
                                                                   name="install_toman" class="form-control" id="input-1-install"
                                                                   value="@if(old('install_toman')){{old('install_toman')}}@else{{@$factors[0]->install_toman}}@endif"
                                                                   placeholder="هزینه اجرا و نصب را وارد کنید">
                                                            <span class="numberToword"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="input-1">میزان تخفیف از مبلغ نهایی </label>
                                                            <input type="text" onkeyup="change_price(this)"
                                                                   name="Total_discount" class="form-control" id="input-1"
                                                                   value="@if(old('Total_discount')){{old('Total_discount')}}@else{{@$factors[0]->Total_discount}}@endif"
                                                                   placeholder="میزان تخفیف را وارد کنید">
                                                            <span class="numberToword"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input style="margin-top: 30px" type="submit"
                                                               class="btn btn-primary float-left" value="ویرایش فاکتور">
                                                    </div>
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

    <script src='{{asset('admin/js/select2.min.js')}}' type='text/javascript'></script>


@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $("#brand").select2();
            $("#product").select2();
            $("#category").select2();
        });



        Sortable.create(sortable, {
            onUpdate: function (evt) {
                var form=$('#sortableForm').serializeArray();

                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Ajax.updateOrdering')}}';
                var data = {_token: CSRF_TOKEN,form:form};
                $.post(url, data, function (msg) {
                    console.log(msg)
                    Lobibox.notify('success', {
                        size: 'mini',
                        showClass: 'Lobibox-custom-class hide-close-icon',
                        iconSource: "fontAwesome",
                        delay: 3000,
                        soundPath: '{{asset('admin/sounds/sounds/')}}',
                        position: 'left top', //or 'center bottom'
                        msg: 'مرتب سازی انجام شد',
                    });
                })

            },
        });


    </script>
    <script>
        function number_3_3(num, sep) {
            var number = typeof num === "number" ? num.toString() : num,
                separator = typeof sep === "undefined" ? ',' : sep;
            return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
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

        $('#sabt').click(function () {
            var invalid = false;
            var product = $('select[name=product]').val();
            var count = $('input[name=count]').val();
            var factor_id = $('input[name=factor_id]').val();
            var price = $('input[name=price]').val();
            var discount = $('input[name=discount]').val();
            var name = $('input[name=name]').val();

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
                var url = '{{route('Ajax.update-factor')}}';
                var data = {
                    _token: CSRF_TOKEN,
                    product: product,
                    count: count,
                    price: price,
                    discount: discount,
                    factor_id: factor_id,
                    name: name
                };
                $.post(url, data, function (msg) {
                    if(msg.count!="NoCount"){
                    get_price();
                    let row=parseInt(msg.row)+1;
                    $('table').append('<tr><td scope="row">' + row + '</td><td colspan="2">' + msg.product.title + ' - ' + msg.brand + ' - ' + msg.product.content + '</td><td>' + msg.count + '</td><td>' + number_3_3(msg.price) + '</td><td>' + msg.discount + ' % </td><td>' + number_3_3(msg.total_price) + '</td><td><button style="padding: 5px" onclick="delete_solo_item(this,' + msg.id + ',' + msg.table + ')" type="button" class="btn btn-outline-danger waves-effect waves-light delete-factor-row">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button></td></tr>');
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

    </script>
    <script>
        function change_price(item) {
            numberToword(item);
            var discount = $('input[name=Total_discount]').val();
            var install = $('input[name=install]').val();
            var install_toman = $('input[name=install_toman]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.change-price')}}';
            var data = {_token: CSRF_TOKEN, discount: discount,install:install,install_toman:install_toman, factor_id: '{{$factors[0]->factor_id}}'};
            $.post(url, data, function (msg) {
                $('#Total').html(number_3_3(msg.Total));
                $('#Total_discount').html(number_3_3(msg.Total_discount));
            })
        }

        function get_price() {
            var discount = $('input[name=Total_discount]').val();
            var install = $('input[name=install]').val();
            var install_toman = $('input[name=install_toman]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.get-price-factor')}}';
            var data = {
                _token: CSRF_TOKEN,
                install: install,
                install_toman: install_toman,
                discount: discount,
                factor_id: '{{$factors[0]->factor_id}}'
            };
            $.post(url, data, function (msg) {
                $('#sum_price').html(number_3_3(msg.sum_price));
                $('#install').html(number_3_3(msg.install));
                $('#total').html(number_3_3(msg.total));
                $('#Total').html(number_3_3(msg.Total));
                $('#Total_discount').html(number_3_3(msg.Total_discount));
                $('#hrofi').html(msg.hrofi);
                $('#count').html(msg.count);
                $('#install_default').html(msg.install_default);
            })
        }

        change_price_install();

        function change_price_install() {
            get_price()
            var install_toman = $('input[name=install_toman]').val();
            if (install_toman.length>3) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Ajax.numberToword')}}';
                var data = {_token: CSRF_TOKEN, number: install_toman};
                $.post(url, data, function (msg) {
                    $('input[name=install_toman]').parent('.form-group').find('.numberToword').html(msg.word)
                })
            }
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
@endsection
