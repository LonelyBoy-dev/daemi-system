@extends('admin.layout.master')
@section('style_link')
    <link href="{{asset('admin/plugins/waitme/waitMe.css')}}" rel="stylesheet"/>
@endsection
@section('style')
    <style>
        .profile-card-2 .profile {
            border-radius: 50%;
            position: absolute;
            top: 27px;
            left: auto;
            max-width: 124px;
            border: 3px solid rgba(255, 255, 255, 1);
            -webkit-transform: translate(-50%, 0%);
            transform: translate(-24%, 0%);
            width: 80px;
        }
        .waitMe_container .waitMe{
            border-radius: 100%;

        }
        .waitMe_container .waitMe_progress.pulse{
            margin-top: 10px;
        }
        .waitMe_container .waitMe .waitMe_text{
            margin: 5px 0 0;
        }
        .waitMe_container .waitMe *{
            font-family:Vazir!important;
            font-size: 10px;
        }
        .hr-span{
            position: relative;
            margin: 40px 0;
        }
        .hr-span span{
            position: absolute;
            top: -14px;
            right: 2px;
            border: 1px dashed #7934f3;
            padding: 3px 9px;
            background: #242526;
            border-radius: 5px;
        }
        .invalid-feedback{
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-4">
                <div class="card profile-card-2">
                    <div class="card-img-block profile-body" style="text-align: center">
                        @if(@$item->avatar!="")
                            <label class="wimgpf" for="image_profile" style="cursor: pointer;margin-top: 30px;">
                                <img id="imgpf" style="width: 90px;height: 90px;border-radius: 100%"
                                     src="{{asset($item->avatar)}}" alt="عکس پروفایل"/>
                            </label>
                        @else
                            <label class="wimgpf" for="image_profile" style="cursor: pointer;margin-top: 30px">
                                <img id="imgpf" style="width: 90px;height: 90px"
                                     src="{{asset('admin/images/user.png')}}" alt="عکس پروفایل"/>
                            </label>
                        @endif
                    </div>
                    <div class="card-body pt-5">

                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">{{$item->email}}</p>

                    </div>

                </div>

            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content p-3">
                                <form method="post" action="{{route('profile.store')}}" autocomplete="off">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">نام و نام خانوادگی</label>
                                        <div class="col-lg-9">
                                            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="@if(old('name')){{old('name')}}@else{{$item->name}}@endif">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">نام کاربری</label>
                                        <div class="col-lg-9">
                                            <input class="form-control @error('username') is-invalid @enderror" name="username" type="text" value="@if(old('username')){{old('username')}}@else{{$item->username}}@endif">
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">ایمیل</label>
                                        <div class="col-lg-9">
                                            <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="@if(old('email')){{old('email')}}@else{{$item->email}}@endif">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="hr-span">
                                        <hr>
                                        <span>در صورت تغییر، پسورد را وارد کنید</span>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">پسور</label>
                                        <div class="col-lg-9">
                                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" value="{{old('email')}}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">تکرار پسور</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" name="password_confirmation" value="{{old('password_confirmation')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label"></label>
                                        <div class="col-lg-9">
                                                <a href="/admin/factors" class="btn btn-secondary">لغو</a>
                                            <input type="submit" class="btn btn-primary" value="ذخیره تغییرات">
                                        </div>
                                    </div>


                                </form>

                            <input onchange="uploadimageprofile()" style="display: none" type="file"
                                   name="image_profile" id="image_profile">
                    </div>
                </div>
            </div>

        </div>
        <div class="overlay toggle-menu"></div>
    </div>
@endsection
        @section('script_link')
            <script src="{{asset('admin/plugins/waitme/waitMe.js')}}"></script>
        @endsection
@section('script')
            <script>
                function uploadimageprofile() {
                    $('.profile-body .wimgpf').waitMe({
                        effect: 'pulse',
                        text: 'در حال بارگذاری ...',
                        maxSize: '',
                        waitTime: 1,
                        textPos: 'vertical',
                        fontSize: '10',
                        source: '',
                    });
                    var formData = new FormData();
                    formData.append("file", $('#image_profile')[0].files[0]);
                    formData.append("id", '{{$item->id}}');
                    $.ajax({
                        type: "post",
                        url: "{{route('uploadimageprofile')}}",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('.wimgpf').slideDown(300);
                            $('.waitMe').fadeOut();
                            $('.profile-body #imgpf').attr('src', data.status);
                        },
                        error: function (err) {
                            if (err.status == 422) {
                                $('#error_user').slideDown(150);
                                $.each(err.responseJSON.errors, function (i, error) {
                                    $('#error_item').append($('<span style="color: #fff;font-size: 12px">' + error[
                                            0] +
                                        '</span><br>'));
                                });
                            }
                        }
                    });

                }
            </script>
@endsection
