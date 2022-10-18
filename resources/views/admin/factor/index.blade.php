@extends('admin.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection

@section('style')
    <style>
        /*.limiter table tbody tr td:nth-child(1):before {
            content: "انتخاب";
        }*/
        .limiter table tbody tr td:nth-child(1):before {
            content: "شماره فاکتور";
        }
        .limiter table tbody tr td:nth-child(2):before {
            content: "نام خریدار";
        }
        .limiter table tbody tr td:nth-child(3):before {
            content: "دسته بندی";
        }
        .limiter table tbody tr td:nth-child(4):before {
            content: "مبلغ فاکتور";
        }
        .limiter table tbody tr td:nth-child(5):before {
            content: "باقیمانده";
        }
        .limiter table tbody tr td:nth-child(6):before {
            content: "تاریخ ثبت";
        }
        .limiter table tbody tr td:nth-child(7):before {
            content: "فعالیت ها";
        }


        .limiter table tbody tr td:nth-child(7) a,.limiter table tbody tr td:nth-child(7) button{
            padding: 5px;
        }
        @media screen and (max-width: 992px) {
            .limiter table tbody tr td {
                padding-right: 42% !important;
            }
        }
        .container-table100{min-height: auto}
        </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-layers icons"></i>لیست فاکتورها</h3>
            </div>
            <div class="div-button-top">
               {{-- <button onclick="delete_all('{{$table}}')" type="button"
                        class="btn btn-danger waves-effect waves-light m-1">حذف دسته جمعی
                </button>--}}
                @if(count($factor_row)>0)
                    <a href="{{route('factors.create')}}" type="button"
                       class="btn btn-success waves-effect waves-light m-1">تکمیل فاکتور قبلی</a>
                @else
                    <a href="{{route('factors.create')}}" type="button"
                       class="btn btn-success waves-effect waves-light m-1">افزودن فاکتور جدید</a>
                @endif
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php $agent=new Jenssegers\Agent\Agent();@endphp
                        @if ($agent->isMobile())
                            <div class="limiter">
                                <form method="get" action="{{route('factors.index')}}" class="row" style="padding: 0 17px;">
                                    <div style="width: 80%;" class="col-xs-11">
                                        <div class="form-group">
                                            <label for="product_search">جستجو</label>
                                            <input type="text" name="type" class="form-control" id="product_search" value="" placeholder="شماره فاکتور،نام خریدار را وارد کنید">
                                        </div>
                                    </div>
                                    <div class="col-xs-1">
                                        <button style="margin-top: 29px !important;padding: 10px 19px;border-color: #3a3b3c;color: #3a3b3c;" type="submit" class="btn btn-outline-dark waves-effect waves-light m-1"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </form>
                                <div class="container-table100">
                                    <div class="wrap-table100">
                                       {{-- <div style="padding: 1px 4px 15px;">
                                            <div class="icheck-material-info">
                                                <input type="checkbox" id="check_All">
                                                <label for="check_All"></label>
                                                انتخاب همه
                                            </div>
                                        </div>--}}

                                        <div class="table100">
                                            <table>
                                                <thead>
                                                <tr class="table100-head">
                                                    <th class="column1" style="background-image: none;">
                                                        <div class="icheck-material-info">
                                                            <input type="checkbox" id="check_All">
                                                            <label for="check_All"></label>
                                                        </div>
                                                    </th>
                                                    <th class="column2" style="width: 100px">شماره فاکتور</th>
                                                    <th class="column3">نام خریدار</th>
                                                    <th class="column4">مبلغ فاکتور</th>
                                                    <th class="column5">باقیمانده</th>
                                                    <th class="column6" style="width: 180px">تاریخ ثبت</th>
                                                    <th class="column7">فعالیت ها</th>
                                                </tr>
                                                </thead>
                                                <tbody id="factors">
                                                @php $amount_paid=[]; @endphp
                                                @foreach($factors as $items)
                                                    @php $item=\App\Models\Factor::where('factor_id',$items->factor_id)->first(); @endphp
                                                    @php $invoices=\App\Models\Invoice::where('factor_id',$item->factor_id)->get(); @endphp
                                                    @php $product=\App\Models\Product::where('id',$item->product_id)->first();@endphp
                                                    @php $category=\App\Models\Category::where('id',$product->category_id)->first();@endphp

                                                    <tr data-page="<?= $pageNum+1?>" id="item{{$item->factor_id}}"
                                                        @if(count($invoices)) @if($invoices[0]->Total_remaining>0)style="background: #ff1e1e12"
                                                        @endif @else style="background: #ff1e1e12" @endif>
                                                       {{-- <td class="column1">
                                                            <div class="icheck-material-info">
                                                                <input name="delete" value="{{$item->factor_id}}" class="checkBox"
                                                                       type="checkbox" id="md_checkbox_{{$item->id}}">
                                                                <label for="md_checkbox_{{$item->id}}"></label>
                                                            </div>
                                                        </td>--}}
                                                        <td class="column2">
                                                            {{$item->factor_id}}
                                                        </td>
                                                        <td class="column3">
                                                            {{$item->name}}
                                                        </td>
                                                        <td class="column3">
                                                            {{@$category->title}}
                                                        </td>
                                                        <td class="column4">
                                                            {{number_format($item->Total)}} تومان
                                                        </td>
                                                        <td class="column5">
                                                            @if(count($invoices))
                                                                {{number_format($invoices[0]->Total_remaining)}} تومان
                                                            @else
                                                                {{number_format($item->Total)}} تومان
                                                            @endif
                                                        </td>


                                                        <td class="column6">
                                                            {{Verta::instance($item->created_at)->format('Y/m/d')}}
                                                        </td>
                                                        <td class="column7">
                                                                <a href="{{route('factors.edit',$item->factor_id)}}" type="button"
                                                                   class="btn btn-outline-info waves-effect waves-light">
                                                                    <span>ویرایش</span><i class="icon-note "></i> </a>
                                                                <a href="{{route('invoice.show',$item->factor_id)}}"
                                                                   class="btn btn-outline-success waves-effect waves-light m-1"> <i
                                                                        class="fa fa-money"></i> <span>صورت حساب</span> </a>

                                                                <a href="{{route('factors.show',$item->factor_id)}}" type="button"
                                                                   class="btn btn-outline-warning waves-effect waves-light m-1"> <span>چاپ فاکتور</span>
                                                                    <i class="fa fa-desktop"></i></a>
                                                                <button onclick="delete_solo(this,'{{$item->factor_id}}','{{$table}}')"
                                                                        type="button"
                                                                        class="btn btn-outline-danger waves-effect waves-light"><span>حذف</span><i
                                                                        class="fa fa fa-trash-o"></i></button>

                                                        </td>

                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    {{$factors->links("pagination::bootstrap-4")}}
                                </div>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table style="width: 100%;" id="items"
                                       class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        {{--<th style="background-image: none;">
                                            <div class="icheck-material-info">
                                                <input type="checkbox" id="check_All">
                                                <label for="check_All"></label>
                                            </div>
                                        </th>--}}
                                        <th style="width: 100px">شماره فاکتور</th>
                                        <th>نام خریدار</th>
                                        <th>دسته بندی</th>
                                        <th>مبلغ فاکتور</th>
                                        <th>باقیمانده</th>
                                        <th style="width: 180px">تاریخ ثبت</th>
                                        <th>فعالیت ها</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $amount_paid=[]; @endphp
                                    @foreach($item_s as $items)
                                        @php $item=\App\Models\Factor::where('factor_id',$items->factor_id)->first(); @endphp
                                        @php $invoices=\App\Models\Invoice::where('factor_id',$item->factor_id)->get();@endphp
                                        @php $product=\App\Models\Product::where('id',$item->product_id)->first();@endphp
                                        @php $category=\App\Models\Category::where('id',$product->category_id)->first();@endphp

                                        <tr id="item{{$item->factor_id}}"
                                            @if(count($invoices)) @if($invoices[0]->Total_remaining>0)style="background: #ff1e1e12"
                                            @endif @else style="background: #ff1e1e12" @endif>
                                          {{--  <td>
                                                <div class="icheck-material-info">
                                                    <input name="delete" value="{{$item->factor_id}}" class="checkBox"
                                                           type="checkbox" id="md_checkbox_{{$item->id}}">
                                                    <label for="md_checkbox_{{$item->id}}"></label>
                                                </div>
                                            </td>--}}
                                            <td>
                                                {{$item->factor_id}}
                                            </td>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>
                                                {{@$category->title}}
                                            </td>
                                            <td>
                                                {{number_format($item->Total)}} تومان
                                            </td>
                                            <td>
                                                @if(count($invoices))
                                                    {{number_format($invoices[0]->Total_remaining)}} تومان
                                                @else
                                                    {{number_format($item->Total)}} تومان
                                                @endif
                                            </td>


                                            <td>
                                                {{Verta::instance($item->created_at)->format('Y/m/d')}}
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="{{route('factors.edit',$item->factor_id)}}" type="button"
                                                       class="btn btn-outline-info waves-effect waves-light">
                                                        <span>ویرایش</span><i class="icon-note "></i> </a>
                                                    <a href="{{route('invoice.show',$item->factor_id)}}"
                                                       class="btn btn-outline-success waves-effect waves-light m-1"> <i
                                                            class="fa fa-money"></i> <span>صورت حساب</span> </a>
                                                </div>
                                                <div style="text-align: right">
                                                    <a style="margin-right: 0 !important;" href="{{route('factors.show',$item->factor_id)}}" type="button"
                                                       class="btn btn-outline-warning waves-effect waves-light m-1"> <span>چاپ فاکتور</span>
                                                        <i class="fa fa-desktop"></i></a>
                                                    <button onclick="delete_solo(this,'{{$item->factor_id}}','{{$table}}')"
                                                            type="button"
                                                            class="btn btn-outline-danger waves-effect waves-light"><span>حذف</span><i
                                                            class="fa fa fa-trash-o"></i></button>

                                                </div>
                                            </td>

                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_link')
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
@endsection
@section('script')
    <script>
        @if(@$_GET['type'])
        paginate()
        @endif
        function paginate(){
            $('.pagination').empty();
            var pageName=$('#factors > tr').attr('data-page');


            var type='{{@$_GET['type']}}';
            var url_page='{{@$_GET['page']}}';
            if (!url_page){
                url_page=1;
            }

            if (pageName>1) {
                console.log(pageName)
                var i;
                var Num;
                var Num2;
                for (i = 0; i <= pageName; i++) {
                    if (i <= 0) {
                        Num = "‹";
                        Num2 = i
                    } else {
                        if (i == pageName) {
                            Num = "›";
                        } else {
                            Num = i;
                            Num2 = i;
                        }
                    }

                    var active = "";
                    if (url_page == i) {
                        active = "active";
                    }
                    if (i===0){
                        if (url_page>1){
                            var Nums=url_page-1;
                            var link='<li data-browse="'+i+'" class=" page-item ' + active + '"><a class="page-link" href="?page=' + Nums + '&type=' + type + '">' + Num + '</a></li>';
                        }else {
                            var link='<li data-browse="'+i+'" class="disabled page-item ' + active + '" aria-disabled="true" aria-label="« Previous"><span class="page-link" aria-hidden="true">‹</span></li>';
                        }

                    }else{
                        var Numss=pageName-1;

                        if (Numss==url_page){
                            if (i==pageName){
                                var link='<li data-browse="'+i+'" class="disabled page-item ' + active + '" aria-disabled="true" aria-label="Next »"><span class="page-link" aria-hidden="true">›</span></li>';
                            }else {
                                var link='<li data-browse="'+i+'" class="page-item ' + active + '"><a class="page-link" href="?page=' + Num2+1 + '&type=' + type + '">' + Num + '</a></li>';
                            }

                        }else {
                            var link='<li data-browse="'+i+'" class="page-item ' + active + '"><a class="page-link" href="?page=' + Num2 + '&type=' + type + '">' + Num + '</a></li>';
                        }

                    }

                    $('.pagination').append(link)

                }
            }
        }
    </script>
    <script>
        $('#items').DataTable({
            "lengthMenu": [
                [10, 20, 30],
                [10, 20, 30],
            ],
            ordering: true,
            scrollX: 1,
            paging: true,
            "bLengthChange": true,
            "language": {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });
        $('#items_filter input').addClass('form-control');
    </script>
    <script>
        function delete_all(table) {
            var ChkBox = document.getElementsByClassName("checkBox");
            if ($(ChkBox).is(':checked')) {
                var id_row = new Array();
                $('input[name="delete"]:checked').each(function () {
                    id_row.push(this.value);
                });
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
                            var url = '{{route('Ajax.delete-all-factors')}}';
                            var data = {_token: CSRF_TOKEN, id: id_row, table: table};
                            $.post(url, data, function (msg) {
                                if (msg == "deleted") {
                                    id_row.forEach(function (element) {
                                        $(ChkBox).parents('#item' + element).remove()
                                    });
                                    Lobibox.notify('success', {
                                        size: 'mini',
                                        showClass: 'Lobibox-custom-class hide-close-icon',
                                        iconSource: "fontAwesome",
                                        delay: 3000,
                                        soundPath: '{{asset('admin/sounds/sounds/')}}',
                                        position: 'left top', //or 'center bottom'
                                        msg: 'عملیات حذف با موفقیت انجام شد',
                                    });
                                }

                            });
                        }

                    }
                });

            } else {
                Lobibox.notify('warning', {
                    size: 'mini',
                    rounded: true,
                    soundPath: '{{asset('admin/sounds/sounds/')}}',
                    sound: 'soundssound6',
                    iconSource: "fontAwesome",
                    delay: 3000,
                    showClass: 'Lobibox-custom-class hide-close-icon',
                    position: 'left top', //or 'center bottom'
                    msg: 'شما چیزی برای حذف انتخاب نکرده اید',

                });
            }

        }

        function delete_solo(tag, id, table) {

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
                        var url = '{{route('Ajax.delete-solo-factor')}}';
                        var data = {_token: CSRF_TOKEN, id: id, table: table};
                        $.post(url, data, function (msg) {
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


        }

    </script>

@endsection
