@extends('admin.layout.master')
@section('style')
    <style>
        #check-yes{
            display: none;
        }
        .check-row{
            display: flex !important;
        }
    </style>
@endsection
@section('content')
    @php
        $amount_paid=[];
            foreach ($invoices as $invoice){
            $amount_paid[]=$invoice->amount_paid;
            }
        $remaining=$factors[0]->Total-array_sum($amount_paid);
        @endphp
    <div class="container-fluid">
        <div class="row pt-2 pb-2 content-wrapper-header">
            <div>

                <h3 class="page-title"><i class="fa fa-money"></i>افزودن صورت حساب جدید</h3>
            </div>
            <div>
                <a class="arrow-back" href="/admin/invoice/{{$factors[0]->factor_id}}">
                    <span class="ti-arrow-left"></span>
                </a>
            </div>
        </div>
    </div>
    @include('admin.partial.error')
    <form method="post" action="{{route('invoice.store')}}">
        @csrf
        <div class="row">
            <div class="col-lg-8" style="margin: 0 auto;">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">ایجاد صورت حساب</div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp1">نام</label>
                                    <input type="text" class="form-control" disabled id="inp1" value="{{$factors[0]->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp2">شماره فاکتور</label>
                                    <input type="text" class="form-control" disabled id="inp2" value="{{$factors[0]->factor_id}}">
                                    <input type="hidden" class="form-control" name="factor_id"  id="inp2" value="{{$factors[0]->factor_id}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">مبلغ باقیمانده</label>
                                    <input type="text" disabled class="form-control" id="price" value="@if(count($invoices)){{number_format($remaining)}}@else{{number_format($factors[0]->Total)}}@endif">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check">پرداخت به صورت چک</label>
                                    <select class="form-control" id="check" name="check" onchange="change_check()" required>
                                        <option @if(old('check')=="no")selected @endif value="no">خیر</option>
                                        <option @if(old('check')=="yes")selected @endif value="yes">بله</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="check-no" class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount_paid">مبلغ پرداختی</label>
                                    <input type="text" class="form-control" onkeyup="numberToword(this)" name="amount_paid" id="amount_paid" value="{{old('amount_paid')}}">
                                    <span class="numberToword" style="left: 13px;"></span>
                                </div>
                            </div>
                        </div>


                        <div class="row" id="check-yes">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="check_id">شماره چک</label>
                                        <input type="text" class="form-control" name="check_id" id="check_id" value="{{old('check_id')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_paid_check">مبلغ پرداختی</label>
                                        <input type="text" class="form-control" onkeyup="numberToword(this)" name="amount_paid_check" id="amount_paid_check" value="{{old('amount_paid')}}">
                                        <span class="numberToword"></span>
                                    </div>
                                </div>
                        </div>

                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" rows="4" id="description" name="description" placeholder="توضیحات را وارد کنید">{{old('description')}}</textarea>
                            </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5 w-100">ثبت صورت حساب</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@section('script')
    <script>
        change_check();
        function change_check() {
            var change=$('select[name=check]').val();
            if (change=="yes"){
                $('#check-yes').show();
                $('#check-yes').addClass('check-row');

                $('#check-no').hide();
                $('#check-no').removeClass('check-row');
            }
            else if (change=="no"){
                $('#check-no').show();
                $('#check-no').addClass('check-row');

                $('#check-yes').hide();
                $('#check-yes').removeClass('check-row');
            }
        }
    </script>
@endsection
