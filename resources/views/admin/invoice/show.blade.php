@extends('Admin.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-layers icons"></i>لیست فاکتورها</h3>
            </div>
            <div>
                <button onclick="delete_all('{{$table}}')" type="button" class="btn btn-danger waves-effect waves-light m-1">حذف دسته جمعی</button>
                @if(count($factor_row)>0)
                <a href="{{route('factors.create')}}" type="button" class="btn btn-success waves-effect waves-light m-1">تکمیل فاکتور قبلی</a>
                @else
                    <a href="{{route('factors.create')}}" type="button" class="btn btn-success waves-effect waves-light m-1">افزودن فاکتور جدید</a>
                @endif
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table style="width: 100%;" id="items" class="table table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th style="background-image: none;">
                                        <div class="icheck-material-info">
                                            <input type="checkbox" id="check_All">
                                            <label for="check_All"></label>
                                        </div>
                                    </th>
                                    <th style="width: 100px">شماره فاکتور</th>
                                    <th>نام خریدار</th>
                                    <th>مبلغ فاکتور</th>
                                    <th style="width: 180px">تاریخ ثبت  </th>
                                    <th>فعالیت ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($factors as $items)
                                    @php $item=\App\Models\Factor::where('factor_id',$items->factor_id)->first(); @endphp
                                    <tr id="item{{$item->factor_id}}">
                                        <td>
                                            <div class="icheck-material-info">
                                                <input name="delete" value="{{$item->factor_id}}" class="checkBox"
                                                       type="checkbox" id="md_checkbox_{{$item->id}}">
                                                <label for="md_checkbox_{{$item->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            {{$item->factor_id}}
                                        </td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            {{number_format($item->Total)}} تومان
                                        </td>


                                        <td>
                                            {{Verta::instance($item->created_at)->format('Y/m/d')}}
                                        </td>
                                        <td>
                                            <div>
                                                <a href="{{route('factors.show',$item->factor_id)}}" type="button" class="btn btn-outline-warning waves-effect waves-light m-1">  <span>چاپ فاکتور</span> <i class="fa fa-desktop"></i></a>
                                                <a href="{{route('factors.edit',$item->factor_id)}}" type="button" class="btn btn-outline-info waves-effect waves-light">  <span>ویرایش</span><i class="icon-note "></i> </a>
                                            </div>
                                            <div>
                                                <a href="{{route('factors.show',$item->factor_id)}}" class="btn btn-outline-success waves-effect waves-light m-1"> <i class="fa fa-money"></i> <span>صورت حساب</span> </a>
                                                <button onclick="delete_solo(this,'{{$item->factor_id}}','{{$table}}')" type="button" class="btn btn-outline-danger waves-effect waves-light">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
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

        function delete_solo(tag,id,table) {

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
                        var url = '{{route('Ajax.delete-solo-factor')}}';
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
                            }

                        });
                    }

                }
            });


        }

    </script>
@endsection
