@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    <div class="alert alert-icon-danger alert-dismissible " role="alert">
        <button style="opacity: 0;top: -5px;" type="button" class="close" data-dismiss="alert">×</button>
        <div style="width: 40px;" class="alert-icon icon-part-danger">
            <i class="fa fa-times"></i>
        </div>

        <div class="alert-message" style="padding: 7px 15px 4px 15px;">
            <span><a href="javascript:void();" class="alert-link">

                        {{ $error }}
                        <br>

                </a></span>
        </div>

    </div>
    @endforeach
@endif
@if(session('error-insert'))
    <div class="alert alert-icon-danger alert-dismissible " role="alert">
        <button style="opacity: 0;top: -5px;" type="button" class="close" data-dismiss="alert">×</button>
        <div style="width: 40px;" class="alert-icon icon-part-danger">
            <i class="fa fa-times"></i>
        </div>

        <div class="alert-message" style="padding: 7px 15px 4px 15px;">
            <span><a href="javascript:void();" class="alert-link">

                        {{session('error-insert')}}
                        <br>

                </a></span>
        </div>

    </div>
@endif
@php
session()->forget('error-insert');
@endphp
