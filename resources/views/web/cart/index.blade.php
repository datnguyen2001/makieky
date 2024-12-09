@extends('web.index')
@section('title','Giỏ hàng')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/cart.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-5">
        <p class="title-cart">Giỏ hàng</p>

        <div class="row mt-30 box-cart">
            <div class="col-8 col-cart-left">
                <div id="cartDesktopProduct" class="card w-100">
                    <div class="card-header px-gd-2 py-gd-1"><h6 class="mb-0 fs-sa-16 fw-bold">Giỏ hàng của bạn</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item list-group-item-mobile px-gd-2 py-gd-1">
                                <div class="row fs-sa-16 fw-bold">
                                    <div class="col-5">Sản phẩm</div>
                                    <div class="col-2 item-none-mobile text-center">Giá</div>
                                    <div class="col-2 item-none-mobile text-center">Số lượng</div>
                                    <div class="col-2 item-none-mobile text-center">Tổng cộng</div>
                                    <div class="col-1 text-center"></div>
                                </div>
                            </div>
                            @if($cart && count($cart)>0)
                                @foreach($cart as $productId => $item)
                                    <div class="list-group-item d-inline px-gd-2 py-gd-1">
                                        <div class="row">
                                            <div class="col-5 col-item-mobile-1 detail d-flex"><img
                                                    src="{{ asset($item['image']) }}"
                                                    width="60px" height="60px"
                                                    style="object-fit: contain; min-width: 60px;">
                                                <div class="w-100 pl-gd-1">
                                                    <div title="{{ $item['name'] }}"
                                                         class="name w-100 text-break fs-sa-14 fw-bold">{{ $item['name'] }}</div>
                                                    <div class="item-block-mobile fs-sa-14">
                                                        <div class=""><span>{{ number_format($item['price']) }}đ</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="item-block-mobile d-flex justify-content-between px-gd-0">
                                                        <form action="{{ route('cart-update', $item['cart_id']) }}"
                                                              method="POST">
                                                            @csrf
                                                            <div role="group" class="input-group"
                                                                 style="width: fit-content">
                                                                <div class="input-group-prepend">
                                                                    <div data-action="decrease"
                                                                         class="input-group-text input-item-btn cursor-pointer position-relative">
                                                                        <i class="fa-solid fa-minus"
                                                                           style="font-size: 12px"></i>
                                                                    </div>
                                                                </div>
                                                                <input type="number" min="1" max="99999"
                                                                       value="{{ $item['quantity'] }}"
                                                                       class="input-item form-control" name="quantity"
                                                                       id="quantity-{{ $item['cart_id'] }}">
                                                                <div class="input-group-append">
                                                                    <div data-action="increase"
                                                                         class="input-group-text input-item-btn cursor-pointer position-relative">
                                                                        <i class="fa-solid fa-plus"
                                                                           style="font-size: 12px"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" style="display: none;"></button>
                                                        </form>
                                                        <div class="fs-sa-14 fw-bold" style="width: fit-content"><span>{{ number_format($item['totalPrice']) }}đ</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 item-none-mobile text-center fs-sa-14">
                                                <div class=""><span>{{ number_format($item['price']) }}đ</span></div>
                                            </div>
                                            <div class="col-2 item-none-mobile px-gd-0 text-center">
                                                <form action="{{ route('cart-update', $item['cart_id']) }}"
                                                      method="POST">
                                                    @csrf
                                                    <div role="group" class="input-group justify-content-center">
                                                        <div class="input-group-prepend">
                                                            <div data-action="decrease"
                                                                class="input-group-text input-item-btn cursor-pointer position-relative">
                                                                <i class="fa-solid fa-minus"
                                                                   style="font-size: 12px"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="1" max="99999" value="{{ $item['quantity'] }}"
                                                               class="input-item form-control" name="quantity"
                                                               id="quantity-{{ $item['cart_id'] }}">
                                                        <div class="input-group-append">
                                                            <div data-action="increase"
                                                                class="input-group-text input-item-btn cursor-pointer position-relative">
                                                                <i class="fa-solid fa-plus" style="font-size: 12px"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" style="display: none;"></button>
                                                </form>
                                            </div>
                                            <div class="col-2 item-none-mobile text-center fs-sa-14 fw-bold">
                                                <span>{{ number_format($item['totalPrice']) }}đ</span>
                                            </div>
                                            <a href="{{route('cart-remove',$item['product_id'])}}"
                                               class="col-1 text-center" style="color: #212529"><span
                                                    class="cursor-pointer"><i
                                                        class="far fa-trash-alt"></i></span></a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="list-group-item d-flex justify-content-center px-gd-2 py-gd-1"
                                     style="color: red">
                                    Không có sản phẩm nào trong giỏ hàng
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($cart && count($cart)>0)
                        <div class="card-footer d-flex justify-content-end w-100">
                            <a href="{{route('cart-clear-all')}}" style="color: #212529"
                               class="text-right cursor-pointer fs-sa-14 fw-bold"><i class="fas fa-trash-alt"></i>Xóa
                                giỏ hàng
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-4 col-cart-right">
                <div class="card">
                    <div class="card-header summary-cart pl-gd-2 pt-gd-1 pb-gd-1">
                        <div class="fs-sa-18 fw-bold">Tổng số giỏ hàng</div>
                    </div>
                    <div class="card-body p-gd-2">
                        <div>
                            {{--                            <div class="justify-content-between fs-sa-14 d-none">--}}
                            {{--                                <div class="w-fc text-left">Phiếu giảm giá</div>--}}
                            {{--                                <div class="w-fc text-right pl-0">- <span>200.000đ</span></div>--}}
                            {{--                            </div> --}}
                            <hr class="dash">
                            <div class="d-flex justify-content-between fs-sa-16 fw-bold">
                                <div class="w-fc text-left">
                                    Tổng số giỏ hàng
                                </div>
                                <div class="w-fc text-right pl-0"><span>{{number_format($totalPrice)}}đ</span></div>
                            </div>
                            <div class="dash"></div>
                        </div>
                        <a @if($cart && count($cart)>0) href="{{route('pay')}}" @endif type="button"
                           class="btn btn-system-main w-100 my-gd-2 btn-secondary">
                            Thanh toán ngay
                        </a>
                        <a href="{{route('home')}}" type="button"
                           class="btn btn-system-secondary w-100 mb-gd-2 ml-gd-0 btn-secondary">
                            Tiếp tục mua sắm
                        </a>
                        <div class="text-center fs-sa-14"><span>Áp dụng Mã giảm giá trong quá trình thanh toán.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>


@stop
@section('script_page')
    <script>
        $(document).ready(function () {

            $('.input-item-btn').on('click', function () {
                var $button = $(this);
                var action = $button.data('action');
                var $input = $button.closest('.input-group').find('.input-item');
                var currentValue = parseInt($input.val());
                var newValue;

                // Tăng hoặc giảm số lượng
                if (action === 'increase') {
                    newValue = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 1) {
                    newValue = currentValue - 1;
                } else {
                    newValue = currentValue;
                }

                $input.val(newValue);

                var form = $button.closest('form');
                form.submit();
            });

            // Sự kiện khi thay đổi trực tiếp trong input
            $('.input-item').on('change', function () {
                var form = $(this).closest('form');
                form.submit(); // Gửi form khi giá trị input thay đổi
            });
        });

    </script>
@stop
