@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-basket-loaded icons"></i>ویرایش محصولات </h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/products">
                    <span class="ti-arrow-left"></span>
                </a>

            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('products.update',$product->id)}}">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">ایجاد محصول</div>
                        <hr>
                        <form>
                            <div class="form-group">
                                <label for="input-1">عنوان</label>
                                <input type="text" name="title" class="form-control" id="input-1" value="{{$product->title}}" placeholder="عنوان محصول را وارد کنید">
                            </div>
                            <div class="form-group">
                                <label for="content">توضیحات</label>
                                <textarea class="form-control" rows="4" id="content" name="content" placeholder="توضیحات محصول را وارد کنید">{{$product->content}}</textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">وضعیت</div>
                        <hr>
                        <div class="form-group">
                            <label for="status">وضعیت نمایش</label>
                            <select class="form-control" id="status" name="status" required>
                                <option @if($product->status=="show")selected @endif value="show">نمایش</option>
                                <option @if($product->status=="DontShow")selected @endif value="DontShow">عدم نمایش</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5 w-100">ویرایش محصول</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">بخش مالی</div>
                        <hr>
                        <div class="form-group">
                            <label for="price">قیمت اصلی</label>
                            <input type="number" name="price" onkeyup="numberToword(this)" class="form-control" value="{{$product->price}}" id="price" placeholder="قیمت اصلی را وارد کنید">
                            <span class="numberToword" style="bottom: 8px;"></span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">تعداد موجود</div>
                        <hr>
                        <div class="form-group">
                            <input type="number" name="depot" class="form-control" value="{{$product->depot}}" id="depot" placeholder="تعداد را وارد کنید">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">دسته بندی محصول</div>
                        <hr>
                        <div class="form-group">
                            <select class="form-control" id="category" name="category" onchange="brands()" required>
                                @foreach($categories as $item)
                                    <option @if($product->category_id==$item->id)selected @endif value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">برند محصول</div>
                        <hr>
                        <div class="form-group">
                            <select class="form-control" id="brand" name="brand" required>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('script')
    <script>
        brands();
        function brands() {
            var id=$('select[name=category]').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            var url = '{{route('Ajax.get-brands')}}';
            var data = {_token: CSRF_TOKEN, id: id,item_id:{{$product->id}}};
            $.post(url, data, function (msg) {
                $('select[name=brand]').html('<option value="0">برند را انتخاب کنید</option>'+msg)
            })
        }
    </script>
@endsection
