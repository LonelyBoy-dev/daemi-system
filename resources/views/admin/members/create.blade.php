@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-puzzle icons"></i>افزودن مشتری جدید</h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/brands">
                    <span class="ti-arrow-left"></span>
                </a>

            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('members.store')}}">
        <div class="row">

            @csrf
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">ایجاد مشتری </div>
                        <hr>
                            <div class="form-group">
                                <label for="name">نام و نام خانوادگی</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}" id="name"
                                       placeholder="نام و نام خانوادگی را وارد کنید">
                            </div>
                            <div class="form-group">
                                <label for="name">شماره موبایل</label>
                                <input name="mobile" type="text" class="form-control" value="{{old('mobile')}}" id="mobile"
                                       placeholder="شماره موبایل را وارد کنید">
                            </div>
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
                                <option @if(old('status')=="show") selected @endif value="show">نمایش</option>
                                <option @if(old('status')=="DontShow") selected @endif value="DontShow">عدم نمایش</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5 w-100">ثبت مشتری جدید</button>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </form>
@endsection
