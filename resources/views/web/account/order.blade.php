@extends('web.index')
@section('title','Lịch sử đơn hàng')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/pay.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/account.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-5">

        <div class="row mb-gd-2">
            @include('web.account.menu')
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div>
                    <div class="body-list-member">
                        <div class="header-member-wrapper">
                            Lịch sử đặt hàng
                        </div>
                        <div class="content-member-wrapper">
                            <div class="filter-history-wrapper px-gd-2 pt-gd-2">
                                <div class="w-50">
                                    <label for="order-number" class="m-0">Tìm kiếm đơn hàng</label>
                                    <form action="{{ route('order-history') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="order-number" placeholder="Order code" class="form-control" value="{{ request('order-number') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn border-left-0 rounded-right btn-outline-secondary" style="border-color: rgb(206, 212, 218);padding: 3px 12px;">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tb-history-wrapper px-gd-2 pt-gd-2">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr style="background-color: rgb(248, 249, 250);">
                                        <th class="fs-sa-14 fw-bold" style="width: 20%;">Order code</th>
                                        <th class="fs-sa-14 fw-bold" style="width: 20%;">Order date</th>
                                        <th class="text-center fs-sa-14 fw-bold" style="width: 20%;">Price</th>
                                        <th class="text-center fs-sa-14 fw-bold" style="width: 20%;">Order status</th>
                                        <th class="text-center fs-sa-14 fw-bold" style="width: 20%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($listData as $order)
                                        <tr>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ number_format($order->total_money, 0, ',', '.') }} VND</td>
                                            <td class="text-center">
                                                @if ($order->status == 0)
                                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                                @elseif ($order->status == 1)
                                                    <span class="badge bg-primary">Đã xác nhận</span>
                                                @elseif ($order->status == 2)
                                                    <span class="badge bg-info">Đang vận chuyển</span>
                                                @elseif ($order->status == 3)
                                                    <span class="badge bg-success">Đã hoàn thành</span>
                                                @elseif ($order->status == 4)
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @else
                                                    <span class="badge bg-secondary">Trả hàng hoàn tiền</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info py-0" style="font-size: 14px" data-bs-toggle="modal" data-bs-target="#staticBackdropOrder" data-id="{{ $order->id }}">
                                                    Xem chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết đơn hàng-->
    <div class="modal fade" id="staticBackdropOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title title-hader-modal" id="staticBackdropLabel">Chi tiết đơn hàng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailContent">

                </div>
            </div>
        </div>
    </div>

@stop
@section('script_page')
    <script>
        $(document).ready(function() {
            $('#staticBackdropOrder').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var orderId = button.data('id');

                $.ajax({
                    url: '/order/details/' + orderId,
                    type: 'GET',
                    success: function(response) {
                        var modal = $('#staticBackdropOrder');
                        modal.find('#orderDetailContent').html(response);
                    },
                    error: function() {
                        alert('Lỗi khi tải chi tiết đơn hàng.');
                    }
                });
            });
        });
    </script>
@stop
