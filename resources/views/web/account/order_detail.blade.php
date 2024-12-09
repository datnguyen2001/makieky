<div class="order-details">
    <h4>Thông tin đơn hàng</h4>
    <p>Mã đơn hàng: {{ $order->order_code }}</p>
    <p>Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</p>
    <p>Trạng thái:
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

    <h5>Sản phẩm đã mua:</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng giá</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->orderItems as $item)
            <tr>
                <td>
                    <img src="{{ asset(@$item->product->src) }}" alt="{{ $item->product->name }}" width="50" height="50">
                </td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price_product, 0, ',', '.') }}đ</td>
                <td>{{ number_format($item->price_product * $item->quantity, 0, ',', '.') }}đ</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
