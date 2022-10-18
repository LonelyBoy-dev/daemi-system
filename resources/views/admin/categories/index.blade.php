@extends('admin.layout.master')
@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection
@section('style')
    <style>
       /* .limiter table tbody tr td:nth-child(1):before {
            content: "انتخاب";
        }*/
        .limiter table tbody tr td:nth-child(1):before {
            content: "عنوان";
        }
        .limiter table tbody tr td:nth-child(2):before {
            content: "وضعیت";
        }
        .limiter table tbody tr td:nth-child(3):before {
            content: "تاریخ ثبت ";
        }
        .limiter table tbody tr td:nth-child(4):before {
            content: "فعالیت ها";
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-puzzle icons"></i>لیست نوع محصولات</h3>
            </div>
            <div class="div-button-top">
               {{-- <button onclick="delete_all_items('{{$table}}')" type="button"
                        class="btn btn-danger waves-effect waves-light m-1">حذف دسته جمعی
                </button>--}}

                <a href="/admin/categories/create" type="button" class="btn btn-success waves-effect waves-light m-1">افزودن
                    دسته جدید </a>

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
                                <form method="get" action="{{route('categories.index')}}" class="row" style="padding: 0 17px;">
                                    <div style="width: 80%;" class="col-xs-11">
                                        <div class="form-group">
                                            <label for="product_search">جستجو</label>
                                            <input type="text" name="type" class="form-control" id="product_search" value="" placeholder="عنوان دسته بندی را وارد کنید">
                                        </div>
                                    </div>
                                    <div class="col-xs-1">
                                        <button style="margin-top: 29px !important;padding: 10px 19px;border-color: #3a3b3c;color: #3a3b3c;" type="submit" class="btn btn-outline-dark waves-effect waves-light m-1"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </form>
                                <div class="container-table100">
                                    <div class="wrap-table100">
                                      {{--  <div style="padding: 1px 4px 15px;">
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
                                                    <th class="column2" style="background-image: none;min-width: 150px">عنوان</th>
                                                    <th class="column3">وضعیت</th>
                                                    <th class="column4">تاریخ ثبت </th>
                                                    <th class="column5">فعالیت ها</th>
                                                </tr>
                                                </thead>
                                                <tbody id="categorise">
                                                @foreach($categories as $item)

                                                    <tr id="item{{$item->id}}" data-page="<?= $pageNum+1?>">
                                                     {{--   <td class="column1">
                                                            <div class="icheck-material-info">
                                                                <input name="delete" value="{{$item->id}}" class="checkBox"
                                                                       type="checkbox" id="md_checkbox_{{$item->id}}">
                                                                <label for="md_checkbox_{{$item->id}}"></label>
                                                            </div>
                                                        </td>--}}
                                                        <td class="column2">
                                                            {{$item->title}}
                                                        </td>
                                                        <td class="column3">
                                                            @if($item->status=="show")
                                                                <span class="badge badge-success">نمایش</span>
                                                            @else
                                                                <span class="badge badge-info">عدم نمایش</span>
                                                            @endif
                                                        </td>
                                                        <td class="column4">
                                                            {{Verta::instance($item->created_at)}}
                                                        </td>
                                                        <td class="column5">
                                                            <a href="{{route('categories.edit',$item->id)}}" type="button" class="btn btn-outline-info waves-effect waves-light">  <span>ویرایش</span><i class="icon-note "></i> </a>
                                                            <button onclick="delete_solo_item(this,'{{$item->id}}','{{$table}}')" type="button" class="btn btn-outline-danger waves-effect waves-light">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button>
                                                        </td>

                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    {{$categories->links("pagination::bootstrap-4")}}
                                </div>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table style="width: 100%;" id="items"
                                       class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                       {{-- <th style="background-image: none;">
                                            <div class="icheck-material-info">
                                                <input type="checkbox" id="check_All">
                                                <label for="check_All"></label>
                                            </div>

                                        </th>--}}
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th style="width: 180px">تاریخ ثبت</th>
                                        <th>فعالیت ها</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)

                                        <tr id="item{{$item->id}}">
                                           {{-- <td>
                                                <div class="icheck-material-info">
                                                    <input name="delete" value="{{$item->id}}" class="checkBox"
                                                           type="checkbox" id="md_checkbox_{{$item->id}}">
                                                    <label for="md_checkbox_{{$item->id}}"></label>
                                                </div>
                                            </td>--}}
                                            <td>
                                                {{$item->title}}
                                            </td>
                                            <td>
                                                @if($item->status=="show")
                                                    <span class="badge badge-success">نمایش</span>
                                                @else
                                                    <span class="badge badge-info">عدم نمایش</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{Verta::instance($item->created_at)}}
                                            </td>
                                            <td>
                                                <a href="{{route('categories.edit',$item->id)}}" type="button" class="btn btn-outline-info waves-effect waves-light">  <span>ویرایش</span><i class="icon-note "></i> </a>
                                                <button onclick="delete_solo_item(this,'{{$item->id}}','{{$table}}')" type="button" class="btn btn-outline-danger waves-effect waves-light">  <span>حذف</span><i class="fa fa fa-trash-o"></i> </button>
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
        $('#items').DataTable({
            "lengthMenu": [
                [10, 20, 30],
                [10, 20, 30],
            ],
            ordering: true,
            scrollX: 1,
            paging: true,
            "bLengthChange": false,
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
        @if(@$_GET['type'])
        paginate()
        @endif
        function paginate(){
            $('.pagination').empty();
            var pageName=$('#categorise > tr').attr('data-page');


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
@endsection
