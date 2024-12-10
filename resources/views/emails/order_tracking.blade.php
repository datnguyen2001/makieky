<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng của bạn</title>
</head>
<body>
<div style="width: 700px;margin: 0 auto;padding: 15px;font-size: 16px;">
    <h2 style="margin:0 0 10px 0;font-size: 18px">Thông tin mua hàng</h2>
    <p style="margin:0 0 10px 0">Họ và tên: {{$order->name}}</p>
    <p style="margin:0 0 10px 0">Số điện thoại: {{$order->phone}}</p>
    <p style="margin:0 0 10px 0">
        Địa chỉ: {{$order->detail_address}},
        {{$order->ward ? $order->ward->name : ''}},
        {{$order->district ? $order->district->name : ''}},
        {{$order->province ? $order->province->name : ''}}
    </p>

    <h2 style="margin:0 0 10px 0;font-size: 18px">Phương thức thanh toán</h2>
    <p style="margin:0 0 10px 0">{{$order->type_payment == 1 ? 'Thanh toán khi nhận hàng' : 'Thanh toán chuyển khoản'}}</p>

    <h2 style="margin:0 0 10px 0;font-size: 18px">Thông tin đơn hàng</h2>
    <div style="display: flex; justify-content: space-between; align-items: center;width: 100%">
        <p style="margin:0;width: 50%">Mã đơn hàng: {{$order->order_code}}</p>
        <p style="margin:0;width: 50%;">Ngày đặt hàng: {{ date('d.m.Y H:i', strtotime($order->created_at)) }}</p>
    </div>

    @foreach($orderItems as $item)
        <div style="border-bottom: 2px solid #cccccc;margin-top: 10px">
            <div>
                <div>Tên sản phẩm: {{$item->product->name}}</div>
                <div>Số lượng: {{$item->quantity}}</div>
            </div>
            <div>
                <p style="margin: 0 0 10px 0">
                    <span>Giá: {{number_format($item->price_product)}}đ</span><br>
                    <span>Thành tiền: <span style="color: red">{{number_format($item->quantity * $item->price_product)}}đ</span></span>
                </p>
            </div>
        </div>
    @endforeach

    <div style="margin-top: 10px">
        <div style="display: flex;justify-content: space-between;align-items: center"><span
                style="font-weight: 700">Tổng tiền hàng:</span>
            <p style="width: 265px;margin: 0;text-align: right">{{number_format($order->total_money)}}đ</p>
        </div>
    </div>
    <h2 style="margin-top: 20px;">Trạng thái đơn hàng</h2>
    <p style="margin:0 0 10px 0">
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
    </p>
</div>

</body>
</html>
