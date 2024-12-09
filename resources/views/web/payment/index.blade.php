@extends('web.index')
@section('title','Thanh toán')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/pay.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-3">
        <div class="product-breadcrumb">
            <a href="{{route('get-cart')}}" class="item-breadcrumb">Giỏ hàng</a>
            <span class="item-breadcrumb"> <i class="fa-solid fa-angle-right"></i> </span>
            <span class="item-breadcrumb item-breadcrumb-active">Thanh toán</span>
        </div>

        <form method="POST" action="{{ route('create-order') }}">
            @csrf
        <div class="row box-pay">
            <div class="col-8 col-pay-left">
                <div class="row ">
                    <div class="card w-100 col-12 px-0">
                        <div class="card-body pb-gd-2 pt-gd-2 px-gd-2">
                            <div class="fs-sa-16 fw-bold">
                                Đặt hàng bằng tài khoản của bạn
                            </div>
                            <div class="d-flex mt-gd-1">
                                <img src="{{asset($user->avatar)}}" referrerpolicy="no-referrer" class="rounded-circle"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <span class="ml-gd-1">
                                    <div>Chào mừng <span class="fs-sa-16 fw-bold">{{$user->name}}</span></div>
                                    <div>{{$user->email}}</div>
                                    <a href="{{route('logout')}}"
                                       class="text-muted cursor-pointer text-decoration-underline">Đăng xuất</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-gd-2">
                    <div class="card w-100 col-12 px-0">
                        <div class="card-header d-flex justify-content-between px-gd-2 py-gd-1">
                            <div class="fs-sa-16 fw-bold">
                                Địa chỉ giao hàng
                            </div>
                            @if($listAddress && count($listAddress)>0)
                                <a data-bs-toggle="modal" href="#exampleModalToggle" role="button"
                                   class="fs-sa-14 text-decoration-underline cursor-pointer" style="color:#373e44;">
                                    Biên tập
                                </a>
                            @endif
                        </div>
                        <div class="card-body p-gd-2">
                            @if($addressDetail)
                                <div class="b-overlay-wrap position-relative">
                                    <div>
                                        <div class="d-flex"><span
                                                class="fs-sa-14 fw-bold mr-gd-1">{{$addressDetail->name}}</span>
                                            <span class="fs-sa-14">{{$addressDetail->phone}}</span>
                                        </div>
                                        <div class="fs-sa-14">
                                            {{$addressDetail->detail_address}}, {{$addressDetail->ward->name}}
                                            , {{$addressDetail->district->name}}, {{$addressDetail->province->name}}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form id="addressForm" method="POST" action="{{ route('add.address') }}">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                                         style="gap: 16px">
                                        <div class="col-info-name">
                                            <div class="fs-sa-14">Họ và tên</div>
                                            <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                                   required>
                                        </div>
                                        <div class="col-info-name">
                                            <div class="fs-sa-14">Số điện thoại</div>
                                            <input type="text" class="form-control" name="phone"
                                                   placeholder="Số điện thoại" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                                         style="gap: 16px">
                                        <div class="col-info-address">
                                            <div class="fs-sa-14">Tỉnh/Thành phố</div>
                                            <select name="province_id" id="province_id" class="form-control" required>
                                                @foreach($province as $provinces)
                                                    <option
                                                        value="{{$provinces->province_id}}">{{$provinces->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-info-address">
                                            <div class="fs-sa-14">Quận/Huyện</div>
                                            <select name="district_id" id="district_id" class="form-control" required>
                                                <option value="">Quận/Huyện</option>
                                            </select>
                                        </div>
                                        <div class="col-info-address">
                                            <div class="fs-sa-14">Phường/Xã</div>
                                            <select name="ward_id" id="ward_id" class="form-control" required>
                                                <option value="">Phường/Xã</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-info-address-detail w-100">
                                        <div class="fs-sa-14">Địa chỉ chi tiết</div>
                                        <input type="text" class="form-control w-100" name="detail_address" required
                                               placeholder="Địa chỉ chi tiết">
                                    </div>
                                    <input type="text" name="is_default" value="1" hidden>
                                    <button type="submit"
                                            class="btn fs-sa-14 btn-coupon btn-secondary mt-3">Thêm địa chỉ
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-gd-2">
                    <div class="card w-100 col-12 px-0">
                        <div class="card-header d-flex justify-content-between px-gd-2 py-gd-1">
                            <div class="fs-sa-16 fw-bold">
                                Phương thức thanh toán
                            </div>
                        </div>
                        <div class="card-body p-gd-2">
                            <div class="d-flex flex-column payment-method">
                                <label for="payment0" class="payment-option">
                                    <input type="radio" name="type_payment" id="payment0" value="1" checked>
                                    <span class="payment-text">Thanh toán khi nhận hàng</span>
                                </label>
                                <label for="payment1" class="payment-option">
                                    <input type="radio" name="type_payment" id="payment1" value="2">
                                    <span class="payment-text">Thanh toán bằng VNPAY</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-pay-right">
                <div class="card border-0 summary-cart">
                    <div class="card-header summary-cart bg-color-alpha p-gd-2">
                        <div class="fs-sa-18 fw-bold">
                            Tóm tắt đơn hàng
                        </div>
                    </div>
                    <div class="card-body p-gd-2 bg-color-alpha">
                        <div class="product pb-0">
                            @foreach($cartItems as $item)
                                <div class="row">
                                    <div class="col-3 col-md-2 col-lg-3 detail">
                                        <img src="{{ asset($item['product']->src) }}" width="60px" height="60px" style="object-fit: contain;">
                                    </div>
                                    <div class="col pl-gd-0">
                                        <div class="row -ml-1">
                                            <div class="col-12 pl-gd-0 name w-100 text-break fs-sa-14 fw-bold">
                                                {{ $item['product']->name }}
                                            </div>
                                            <div class="col-12 pl-gd-0 fs-sa-14 d-flex justify-content-between">
                                                <span>Số lượng: <span class="fw-bold">{{ $item['quantity'] }}</span></span>
                                                <span class="fw-bold">{{ number_format($item['totalPrice'], 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer p-gd-2">
                        <div class="b-overlay-wrap position-relative">
                            <div class="row border-bottom fs-sa-14 mb-gd-2">
                                <div class="col pr-gd-1 col-left">
                                    <input type="text" placeholder="Nhập mã giảm giá" class="form-control" maxlength="10" id="__BVID__2692">
                                </div>
                                <div class="pl-0 text-right mr-15 col-right">
                                    <button type="button"
                                            class="btn fs-sa-14 btn-coupon btn-secondary">Áp
                                        dụng
                                    </button>
                                </div>
                                <div class="col-12 py-gd-2"><span class="d-block cursor-pointer coupon-choose">Chọn phiếu giảm giá</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
{{--                            <div class="d-flex justify-content-between fs-sa-14">--}}
{{--                                <div class="w-fc text-left">--}}
{{--                                    Tổng phụ <span class="text-muted"> ({{ $totalQuantity }} mục) </span>--}}
{{--                                </div>--}}
{{--                                <div class="w-fc text-right pl-0">--}}
{{--                                    <span>{{ number_format($totalPrice, 0, ',', '.') }}đ</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="justify-content-between fs-sa-14 d-none">--}}
{{--                                <div class="w-fc text-left">--}}
{{--                                    Phiếu giảm giá--}}
{{--                                </div>--}}
{{--                                <div class="w-fc text-right pl-0">--}}
{{--                                    - 0đ--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between fs-sa-14">--}}
{{--                                <div class="w-fc text-left">--}}
{{--                                    Chi phí vận chuyển--}}
{{--                                </div>--}}
{{--                                <div class="w-fc text-right pl-0"><span>0đ</span></div>--}}
{{--                            </div>--}}
{{--                            <div class="dash"></div>--}}
                            <div class="d-flex justify-content-between fs-sa-16 fw-bold">
                                <div class="w-fc text-left">
                                    Tổng số tiền
                                </div>
                                <div class="w-fc text-right pl-0"> <span>{{ number_format($totalPrice, 0, ',', '.') }}đ</span></div>
                                <input type="text" name="total_money" value="{{$totalPrice}}" hidden>
                            </div>
                            <hr class="dash">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-system-main mt-gd-2 w-100 btn-secondary">Thanh
                    toán
                </button>
            </div>
        </div>
        </form>
    </div>


    <!-- Modal list address-->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-address">
            <div class="modal-content">
                <header id="modal-change-address-shipping___BV_modal_header_" class="modal-header">
                        <span class="fs-sa-16 fw-bold">
                            Chọn địa chỉ giao hàng
                        </span>
                    <div class="float-right ml-auto close-modal" data-bs-dismiss="modal" aria-label="Close"
                         style="cursor: pointer;">
                        <i class="fa-solid fa-xmark" style="font-size: 18px"></i>
                    </div>
                </header>
                <div id="modal-change-address-shipping___BV_modal_body_" class="modal-body">
                    <div class="b-overlay-wrap position-relative">
                        @if($listAddress && count($listAddress)>0)
                            @foreach($listAddress as $address)
                                <div id="select-address" role="radiogroup" tabindex="-1" class="bv-no-focus-ring">
                                    <div
                                        class="w-100 modal-change-address-shipping custom-control custom-control-inline custom-radio d-flex align-items-center gap-2">
                                        <input type="radio" name="select-address" class="custom-control-input"
                                               value="{{$address->id}}" @if($address->is_default == 1) checked @endif
                                               id="list_address_{{$address->id}}">
                                        <label class="custom-control-label" for="list_address_{{$address->id}}">
                                            <div class="row cursor-pointer justify-content-between">
                                                <div class="col-3 text-break text-name-address">{{$address->name}}
                                                    <br>{{$address->phone}}</div>
                                                <div class="col-6 px-0 text text-name-address">
                                                    {{$address->detail_address}}, {{$address->ward->name}}
                                                    , {{$address->district->name}}, {{$address->province->name}}
                                                </div>
                                                <div
                                                    class="col-2 text-muted text-name-address">{{$address->is_default == 1?'Mặc định':''}}</div>
                                                <div class="d-flex justify-content-between flex-wrap col-1 pl-0 text">
                                            <span class="cursor-pointer" data-bs-toggle="modal"
                                                  data-bs-target="#editAddressModal"
                                                  data-id="{{ $address->id }}" data-name="{{ $address->name }}"
                                                  data-is_default="{{ $address->is_default }}"
                                                  data-phone="{{ $address->phone }}"
                                                  data-detail_address="{{ $address->detail_address }}"
                                                  data-province_id="{{ $address->province_id }}"
                                                  data-district_id="{{ $address->district_id }}"
                                                  data-ward_id="{{ $address->ward_id }}"><i class="far fa-edit"></i>
                                            </span>
                                                    <a href="{{route('address.delete',$address->id)}}"
                                                       class="text-muted cursor-not-allowed"><i
                                                            class="far fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <hr class="mt-0">
                            @endforeach
                        @endif
                    </div>
                </div>
                <footer id="modal-change-address-shipping___BV_modal_footer_" class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <button type="button" class="btn fs-sa-14 btn-outline-secondary"
                                    data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">
                                <span><i class="far fa-plus"></i> <span
                                        class="text-decoration-underline">Thêm địa chỉ</span></span>
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn cursor-pointer btn-dark text-name-address">Lưu</button>
                            <button type="button" class="btn cursor-pointer btn-outline-dark text-name-address"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">Hủy
                            </button>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Modal add address-->
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-address">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Thêm địa chỉ giao hàng</h1>
                    <div class="float-right ml-auto close-modal" data-bs-target="#exampleModalToggle"
                         data-bs-toggle="modal"
                         style="cursor: pointer;">
                        <i class="fa-solid fa-xmark" style="font-size: 18px"></i>
                    </div>
                </div>
                <form id="addressForm" method="POST" action="{{ route('add.address') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                             style="gap: 16px">
                            <div class="col-info-name">
                                <div class="fs-sa-14">Họ và tên</div>
                                <input type="text" class="form-control" name="name" placeholder="Họ và tên" required>
                            </div>
                            <div class="col-info-name">
                                <div class="fs-sa-14">Số điện thoại</div>
                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại"
                                       required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                             style="gap: 16px">
                            <div class="col-info-address">
                                <div class="fs-sa-14">Tỉnh/Thành phố</div>
                                <select name="province_id" id="province_id" class="form-control" required>
                                    @foreach($province as $provinces)
                                        <option value="{{$provinces->province_id}}">{{$provinces->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-info-address">
                                <div class="fs-sa-14">Quận/Huyện</div>
                                <select name="district_id" id="district_id" class="form-control" required>
                                    <option value="">Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="col-info-address">
                                <div class="fs-sa-14">Phường/Xã</div>
                                <select name="ward_id" id="ward_id" class="form-control" required>
                                    <option value="">Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-info-address-detail w-100">
                                <div class="fs-sa-14">Địa chỉ chi tiết</div>
                                <input type="text" name="detail_address" class="form-control w-100" required
                                       placeholder="Địa chỉ chi tiết">
                            </div>
                        </div>
                        <div class="modal-footer w-100 px-0 d-flex justify-content-between align-items-center py-0"
                             style="border-top: 0">
                            <div
                                class="checkbox-default-addr-shipping custom-control custom-checkbox d-flex align-items-center gap-2">
                                <input id="checkbox-1" type="checkbox" name="is_default" class="custom-control-input"
                                       value="1"><label
                                    for="checkbox-1" class="custom-control-label">
                                    Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                            <div>
                                <button type="submit" class="btn cursor-pointer btn-dark text-name-address">Lưu</button>
                                <button type="button" class="btn cursor-pointer btn-outline-dark text-name-address"
                                        data-bs-dismiss="modal" aria-label="Close">Hủy
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal edit address-->
    <div class="modal fade" id="editAddressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-address">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Chỉnh sửa địa chỉ giao hàng</h1>
                    <div class="float-right ml-auto close-modal" data-bs-target="#exampleModalToggle"
                         data-bs-toggle="modal"
                         style="cursor: pointer;">
                        <i class="fa-solid fa-xmark" style="font-size: 18px"></i>
                    </div>
                </div>
                <form id="addressFormUpdate" method="POST" action="{{ route('update.address', ':id') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                             style="gap: 16px">
                            <div class="col-info-name">
                                <div class="fs-sa-14">Họ và tên</div>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên" required>
                            </div>
                            <div class="col-info-name">
                                <div class="fs-sa-14">Số điện thoại</div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại"
                                       required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"
                             style="gap: 16px">
                            <div class="col-info-address">
                                <div class="fs-sa-14">Tỉnh/Thành phố</div>
                                <select name="province_id" id="edit_province_id" class="form-control" required>
                                    @foreach($province as $provinces)
                                        <option value="{{$provinces->province_id}}" >{{$provinces->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-info-address">
                                <div class="fs-sa-14">Quận/Huyện</div>
                                <select name="district_id" id="edit_district_id" class="form-control" required>
                                    <option value="">Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="col-info-address">
                                <div class="fs-sa-14">Phường/Xã</div>
                                <select name="ward_id" id="edit_ward_id" class="form-control" required>
                                    <option value="">Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-info-address-detail w-100">
                                <div class="fs-sa-14">Địa chỉ chi tiết</div>
                                <input type="text" name="detail_address" id="detail_address" class="form-control w-100" required
                                       placeholder="Địa chỉ chi tiết">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer w-100 d-flex justify-content-between align-items-center pt-0"
                         style="border-top: 0">
                        <div
                            class="checkbox-default-addr-shipping custom-control custom-checkbox d-flex align-items-center gap-2">
                            <input id="checkbox-2" type="checkbox" name="is_default" class="custom-control-input"
                                   value="1">
                            <label
                                for="checkbox-2" class="custom-control-label">
                                Đặt làm địa chỉ mặc định
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="btn cursor-pointer btn-dark text-name-address">Lưu</button>
                            <button type="button" class="btn cursor-pointer btn-outline-dark text-name-address"
                                    data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Hủy
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('script_page')

@stop
