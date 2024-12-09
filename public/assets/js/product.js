document.addEventListener('DOMContentLoaded', function () {
    const _token = $('meta[name="csrf-token"]').attr('content');
    const minusBtn = document.querySelector('.btn-mimus');
    const plusBtn = document.querySelector('.btn-plus');
    const quantityInput = document.querySelector('.number-sp');

    minusBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    plusBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });


    $('.btn-add-carts').on('click', function() {
        const quantity = $('.number-sp').val();
        const productId = $('.product_id').val();

        $.ajax({
            url: window.location.origin + '/add-cart',
            method: 'POST',
            dataType: 'json',
            data: {
                _token: _token,
                product_id: productId,
                quantity: quantity
            },
            success: function(data) {
                if (data.success) {
                    getCartQuantity();
                    toastr.success('Sản phẩm đã được thêm vào giỏ hàng!');
                } else {
                    toastr.error('Đã có lỗi xảy ra.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Đã có lỗi xảy ra.');
            }
        });
    });

    $('.btn-buy-now').on('click', function() {
        const quantity = $('.number-sp').val();
        const productId = $('.product_id').val();

        $.ajax({
            url: window.location.origin + '/mua-ngay',
            type: 'POST',
            data: {
                _token: _token,
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi mua ngay.');
            }
        });
    });


});
