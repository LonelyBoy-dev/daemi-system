@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="icon-puzzle icons"></i>افزودن دسته جدید</h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/categories">
                    <span class="ti-arrow-left"></span>
                </a>

            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('categories.store')}}">
        <div class="row">

            @csrf
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">ایجاد دسته بندی</div>
                        <hr>
                        <form>
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input name="title" type="text" class="form-control" id="title"
                                       placeholder="عنوان دسته را وارد کنید">
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
                                <option value="show">نمایش</option>
                                <option value="DontShow">عدم نمایش</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5 w-100">ثبت دسته جدید</button>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </form>
@endsection
