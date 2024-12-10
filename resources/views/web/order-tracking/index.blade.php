@extends('web.index')
@section('title','Theo dõi đơn hàng')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/order-tracking.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web box-tracking">
        <p class="name-tracking">Theo dõi đơn hàng</p>
        <form action="{{ route('order.search') }}" method="POST">
            @csrf
            <div class="box-tracking-order">
                <p class="name-order-code">Tìm kiếm theo mã đơn hàng của bạn</p>
                <div class="text-input-order-tracking d-flex">Mã đơn hàng<span class="text-red">*</span></div>
                <input type="text" placeholder="Mã đơn hàng" class="input-tracking-order" name="order_code" value="{{old('order_code')}}" required>
                <small class="text-guide text-muted">
                    Bạn có thể kiểm tra mã đơn hàng từ email xác nhận mua hàng.
                </small>

                <div class="text-input-order-tracking d-flex mt-3">Email<span class="text-red">*</span></div>
                @error('email')
                <div class="error-message w-100">{{ $message }}</div>
                @enderror
                <input type="text" placeholder="Email" class="input-tracking-order" name="email" value="{{old('email')}}" required>
                <button type="submit" class="btn-search-order">Tìm kiếm đơn hàng</button>
            </div>
        </form>
    </div>


@stop
@section('script_page')

@stop
