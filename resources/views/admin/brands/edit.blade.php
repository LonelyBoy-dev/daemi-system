@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-puzzle icons"></i>ویرایش برند</h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/brands">
                    <span class="ti-arrow-left"></span>
                </a>

            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('brands.update',$item->id)}}">
        <div class="row">
            @csrf
            @method('PATCH')
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">ویرایش برند</div>
                        <hr>
                        <form>
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input name="title" type="text" class="form-control" id="title"
                                       placeholder="عنوان برند محصول را وارد کنید" value="{{$item->title}}">
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
                                <option @if($item->status=="show")selected @endif value="show">نمایش</option>
                                <option @if($item->status=="DontShow")selected @endif value="DontShow">عدم نمایش</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5 w-100">ویرایش برند</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">دسته بندی محصول</div>
                        <hr>
                        <div class="form-group">
                            <select class="form-control" id="category" name="category" required>
                                @foreach($categories as $cat)
                                    <option @if($item->category_id==$cat->id)selected @endif value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </form>
@endsection
