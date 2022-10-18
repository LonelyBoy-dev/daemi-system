@extends('admin.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
        @media screen and (max-width: 992px) {
            .content-wrapper-header .page-title {
                font-size: 13px;
            }

        }

       /* .limiter table tbody tr td:nth-child(1):before {
            content: "انتخاب";
        }*/
        .limiter table tbody tr td:nth-child(1):before {
            content: "شماره فاکتور";
        }
        .limiter table tbody tr td:nth-child(2):before {
            content: "توضیحات";
        }
        .limiter table tbody tr td:nth-child(3):before {
            content: "مبلغ فاکتور";
        }
        .limiter table tbody tr td:nth-child(4):before {
            content: "مبلغ پرداختی";
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
        .limiter table tbody tr td:nth-child(8) a,.limiter table tbody tr td:nth-child(7) button{
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
        <a href="/admin/factors" type="button" class="back-button-mobile btn btn-primary waves-effect waves-light m-1" style="top: 67px"> بازگشت </a>
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="fa fa-money"></i>لیست صورت حساب فاکتور {{$factors[0]->factor_id}}
                <div style="padding: 5px 32px 0 0;">
                    <div style="padding: 15px 0">فاکتور {{$factors[0]->name}}</div>
                    <div>مبلغ فاکتور : {{number_format($factors[0]->Total)}} تومان </div>
                    <div style="padding: 15px 0 0">باقیمانده : <span id="Total_remaining">@if(count($invoices)){{number_format(@$invoices[0]->Total_remaining)}}@else{{number_format($factors[0]->Total)}} @endif</span> تومان </div>
                </div>
                </h3>
            </div>
            <div style="position: relative;" class="div-button-top">
                <a href="/admin/invoice/show-invoice/{{$factors[0]->factor_id}}" class="btn btn-warning waves-effect waves-light m-1">گزارش صورت حساب</a>
                {{--<button onclick="delete_all('{{$table}}')" type="button" class="btn btn-danger waves-effect waves-light m-1">حذف دسته جمعی</button>--}}
                <a href="{{route('invoice.create','id='.$factors[0]->factor_id)}}" type="button" class="btn btn-success waves-effect waves-light m-1">افزودن صورت حساب جدید</a>
                <div class="arrow-back-button" style="position: absolute;left: 0;bottom: 0;">
                    <a class="arrow-back" href="/admin/factors">
                        <span class="ti-arrow-left"></span>
                    </a>
                </div>
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
                                                    {{--<th class="column1" style="background-image: none;">
                                                        <div class="icheck-material-info">
                                                            <input type="checkbox" id="check_All">
                                                            <label for="check_All"></label>
                                                        </div>
                                                    </th>--}}
                                                    <th class="column2" style="width: 100px">شماره فاکتور</th>
                                                    <th class="column3">توضیحات</th>
                                                    <th class="column4">مبلغ فاکتور</th>
                                                    <th class="column5">مبلغ پرداختی</th>
                                                    <th class="column6">باقیمانده</th>
                                                    <th class="column7" style="width: 180px">تاریخ ثبت</th>
                                                    <th class="column8">فعالیت ها</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $factors=\App\Models\Invoice::where('factor_id', $factor_id)->paginate(5); @endphp
                                                @foreach($invoices as $item)
                                                    <tr id="item{{$item->factor_id}}">
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
                                                            {{$item->description}}
                                                        </td>
                                                        <td class="column4">
                                                            {{number_format($item->price)}} تومان
                                                        </td>

                                                        <td class="column5">
                                                            {{number_format($item->amount_paid)}} تومان
                                                        </td>


                                                        <td class="column6">
                                                            {{number_format($item->remaining)}} تومان
                                                        </td>


                                                        <td class="column7">
                                                            {{Verta::instance($item->created_at)->format('Y/m/d')}}
                                                        </td>
                                                        <td class="column8">
                                                            <button onclick="delete_solo_invoice(this,'{{$item->id}}','{{$table}}')" type="button" class="btn btn-outline-danger waves-effect waves-light">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button>

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
                                <table style="width: 100%;" id="items" class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        {{--<th style="background-image: none;">
                                            <div class="icheck-material-info">
                                                <input type="checkbox" id="check_All">
                                                <label for="check_All"></label>
                                            </div>
                                        </th>--}}
                                        <th style="width: 100px">شماره فاکتور</th>
                                        <th>توضیحات</th>
                                        <th>مبلغ فاکتور</th>
                                        <th>مبلغ پرداختی</th>
                                        <th>باقیمانده</th>
                                        <th style="width: 180px">تاریخ ثبت</th>
                                        <th>فعالیت ها</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $item)
                                        <tr id="item{{$item->factor_id}}">
                                           {{-- <td>
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
                                                {{$item->description}}
                                            </td>
                                            <td>
                                                {{number_format($item->price)}} تومان
                                            </td>

                                            <td>
                                                {{number_format($item->amount_paid)}} تومان
                                            </td>


                                            <td>
                                                {{number_format($item->remaining)}} تومان
                                            </td>


                                            <td>
                                                {{Verta::instance($item->created_at)->format('Y/m/d')}}
                                            </td>
                                            <td>
                                                <button onclick="delete_solo_invoice(this,'{{$item->id}}','{{$table}}')" type="button" class="btn btn-outline-danger waves-effect waves-light">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button>

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
        $('#check_All').click(function(){
            if(this.checked){
                $('.checkBox').each(function(){
                    this.checked = true;
                })
            }else{
                $('.checkBox').each(function(){
                    this.checked = false;
                })
            }

        });
    </script>
    <script>
        $('#items').DataTable({
            "lengthMenu": [
                [10, 20, 30],
                [10, 20, 30],
            ],
            ordering:  true,
            scrollX:0,
            paging: true,
            "bLengthChange" : false,
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
                            var url = '{{route('Ajax.delete-all-factors')}}';
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

        function delete_solo_invoice(tag,id,table) {

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
                        var url = '{{route('Ajax.delete-solo-invoice')}}';
                        var data = {_token: CSRF_TOKEN, id: id,table:table};
                        $.post(url, data, function (msg) {
                            console.log(msg)
                            if (msg.delete=="deleted"){
                                Lobibox.notify('success', {
                                    size: 'mini',
                                    showClass: 'Lobibox-custom-class hide-close-icon',
                                    iconSource: "fontAwesome",
                                    delay:3000,
                                    soundPath: '{{asset('admin/sounds/sounds/')}}',
                                    position: 'left top', //or 'center bottom'
                                    msg: 'عملیات حذف با موفقیت انجام شد',
                                });
                                $('#Total_remaining').text(number_3_3(msg.Total_remaining));
                                $(tag).parents('tr').remove();
                            }

                        });
                    }

                }
            });


        }

    </script>
@endsection
