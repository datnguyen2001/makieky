function getCartQuantity() {
    $.get(window.location.origin +'/cart-number', function(data) {
        $('.badge-number').text(data.number);
    });
}
getCartQuantity();

$('.btn-add-cart').on('click', function(e) {
    e.preventDefault();

    var productId = $(this).data('value');
    var quantity = 1;
    var _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: window.location.origin + '/add-cart',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: quantity,
            _token: _token
        },
        success: function(response) {
            if (response.success) {
                toastr.success('Sản phẩm đã được thêm vào giỏ hàng!');
                getCartQuantity();
            } else {
                toastr.error('Số lượng sản phẩm còn lại không đủ');
            }
        },
        error: function() {
            toastr.error('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
        }
    });
});

$("select[name='province_id']").change(function() {
    var provinceId = $(this).val();

    $.ajax({
        url: '/api/districts/' + provinceId,
        method: 'GET',
        success: function(data) {
            var districts = data.districts;
            var districtSelect = $("select[name='district_id']");
            districtSelect.empty();
            districtSelect.append('<option value="">Quận/Huyện</option>');

            $.each(districts, function(index, district) {
                districtSelect.append('<option value="' + district.district_id  + '">' + district.name + '</option>');
            });
        },
        error: function() {
            alert('Không thể tải quận/huyện.');
        }
    });

});

$("select[name='district_id']").change(function() {
    var districtId = $(this).val();

    $.ajax({
        url: '/api/wards/' + districtId,
        method: 'GET',
        success: function(data) {
            var wards = data.wards;
            var wardSelect = $("select[name='ward_id']");
            wardSelect.empty();
            wardSelect.append('<option value="">Phường/Xã</option>');

            $.each(wards, function(index, ward) {
                wardSelect.append('<option value="' + ward.wards_id + '">' + ward.name + '</option>');
            });

        },
        error: function() {
            alert('Không thể tải phường/xã.');
        }
    });
});

$('#editAddressModal').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');
    var phone = button.data('phone');
    var detailAddress = button.data('detail_address');
    var provinceId = button.data('province_id');
    var districtId = button.data('district_id');
    var wardId = button.data('ward_id');

    $('#name').val(name);
    $('#phone').val(phone);
    $('#detail_address').val(detailAddress);
    $('#edit_province_id').val(provinceId);
    getDistricts(provinceId,districtId);
    getWards(districtId,wardId);

    if (button.data('is_default') == 1) {
        $('#checkbox-2').prop('checked', true);
    } else {
        $('#checkbox-2').prop('checked', false);
    }
    $('#addressFormUpdate').attr('action', '/update-address/' + id);
});

function getDistricts(province_id,districtId) {
    $.ajax({
        url: '/api/districts/' + province_id,
        method: 'GET',
        success: function (data) {
            $('#edit_district_id').empty();
            $('#edit_district_id').append('<option value="">Quận/Huyện</option>');
            $.each(data.districts, function (index, district) {
                var selected = (district.district_id == districtId) ? 'selected' : '';
                $('#edit_district_id').append('<option value="' + district.district_id + '" ' + selected + '>' + district.name + '</option>');
            });

        }
    });
}

function getWards(district_id,wardId) {
    $.ajax({
        url: '/api/wards/' + district_id,
        method: 'GET',
        success: function (data) {
            $('#edit_ward_id').empty();
            $('#edit_ward_id').append('<option value="">Phường/Xã</option>');
            $.each(data.wards, function (index, ward) {
                var selected = (ward.wards_id == wardId) ? 'selected' : '';
                $('#edit_ward_id').append('<option value="' + ward.wards_id + '" ' + selected + '>' + ward.name + '</option>');
            });

        }
    });
}

