@extends('admin.layout.master')
@section('style_link')
@endsection
@section('style')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>
                <h3 class="page-title"><i class="icon-settings mr-2"></i>تنضیمات</h3>
            </div>

        </div>
    </div>

        <div class="row">


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{route('settings.store')}}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @foreach($items as $item)
                                @if($item->type=="text")
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">{{$item->title}}</label>
                                <div class="col-lg-9">
                                    <input class="form-control " name="{{$item->setting}}" type="text" value="{{$item->value}}">
                                </div>
                            </div>
                                @endif
                                @if($item->type=="number")
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">{{$item->title}}</label>
                                <div class="col-lg-9">
                                    <input class="form-control " name="{{$item->setting}}" type="number" value="{{$item->value}}">
                                </div>
                            </div>
                                @endif
                                    @if($item->type=="image")
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">{{$item->title}}</label>
                                            <div class="col-lg-9">
                                                @if($item->value)
                                                    <label style="cursor: pointer" for="image{{$item->id}}">
                                                    <img width="150" height="150" src="{{asset($item->value)}}">
                                                </label>
                                                @endif
                                                <input style="padding: 3px" class="form-control " id="image{{$item->id}}" name="{{$item->setting}}" type="file" value="{{$item->value}}">
                                            </div>
                                        </div>

                                    @endif
                            @endforeach

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9" style="text-align: left">
                                    <a href="/admin/factors" class="btn btn-secondary">لغو</a>
                                    <input type="submit" class="btn btn-primary" value="ذخیره تغییرات">
                                </div>
                            </div>


                        </form>
                </div>
            </div>

        </div>
        <div class="overlay toggle-menu"></div>
    </div>
@endsection

@section('script')

@endsection
