@extends('admin.layout.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                        <form method="post" action="{{url('admin/product/update/'.$product->id)}}"
                              enctype="multipart/form-data" class="card p-3">
                        @csrf
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Tên sản phẩm</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="name" value="{{$product->name}}" required>
                            </div>
                        </div>
                            <div class="row mb-3">
                                <div class="col-3 d-flex align-items-center">
                                    <p class="m-0">Danh mục :</p>
                                </div>
                                <div class="col-9">
                                    <select name="category_id" class="form-control" required>
                                        @foreach($category as $categorys)
                                            <option value="{{$categorys->id}}" @if($categorys->id == $product->category_id) selected @endif>{{$categorys->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-3 d-flex align-items-center">
                                    <p class="m-0">Thương hiệu :</p>
                                </div>
                                <div class="col-9">
                                    <select name="trademark_id" class="form-control" required>
                                        @foreach($trademark as $trademarks)
                                            <option value="{{$trademarks->id}}" @if($trademarks->id == $product->trademark_id) selected @endif>{{$trademarks->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-3">Mô tả ngắn:</div>
                                <div class="col-8">
                                    <textarea name="describe" class="form-control"  rows="6" required>{{ $product->describe }}</textarea>
                                </div>
                            </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Giá bán</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control price format-currency" name="price" value="{{number_format($product->price)}}" required>
                            </div>
                        </div>
                            <div class="row mb-3 box_parameter_2">
                                <div class="col-3 d-flex align-items-center">
                                    <p class="m-0 parameter_2">Số lượng :</p>
                                </div>
                                <div class="col-9">
                                    <input type="number" class="form-control price" value="{{$product->quantity}}" name="quantity" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3 d-flex align-items-center">
                                    <p class="m-0">Ảnh bìa sản phẩm :</p>
                                </div>
                                <div class="col-9">
                                    <div
                                        class="d-flex align-items-center position-relative selector__image justify-content-center"
                                        style="width: 200px; height: 250px; background: #f0f0f0;cursor: pointer">
                                        <img src="{{asset($product->src)}}" class="position-absolute w-100 h-100"
                                             style="top: 0;left: 0; object-fit: cover">
                                        <label class="position-absolute bg-transparent clear-img text-black"
                                               style="top: 5px; right: 5px; z-index: 10; cursor: pointer"><i
                                                class="bi bi-x-circle-fill"></i></label>
                                    </div>
                                    <input type="file" hidden name="file_product" accept="image/*">
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header bg-info text-white">
                                    Hình ảnh sản phẩm
                                </div>
                                <div class="card-body">
                                    <div class="image-uploader image_product has-files mt-2">
                                        <div class="uploaded">
                                            @foreach($product_img as $value)
                                                <div class="uploaded-images">
                                                    <img src="{{asset($value->src)}}">
                                                    <button type="button" value="{{$value->id}}" class="delete__image"><i
                                                            class="bi bi-x"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                Cập nhật hình ảnh sản phẩm
                            </div>
                            <div class="card-body">
                                <label class="mt-2 mb-2"><i class="fa fa-upload"></i> Chọn hoặc kéo ảnh vào khung bên
                                    dưới</label>
                                <div class="input-image-product">
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <a data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="true"
                               aria-controls="collapseExample1" class="btn bg-info text-white card-header">
                                <p class="d-flex align-items-center justify-content-between mb-0"><strong
                                        style="font-weight: unset">Thông tin sản phẩm</strong><i
                                        class="fa fa-angle-down"></i></p>
                            </a>
                            <div id="collapseExample1" class="collapse shadow-sm show">
                                <div class="card">
                                    <div class="card-body mt-2">
                                        <textarea name="content" id="content"
                                                  class="ckeditor">{!! $product->content !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="card mb-3">
                                <a data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="true"
                                   aria-controls="collapseExample1" class="btn bg-info text-white card-header">
                                    <p class="d-flex align-items-center justify-content-between mb-0"><strong
                                            style="font-weight: unset">Thông tin thành phần</strong><i
                                            class="fa fa-angle-down"></i></p>
                                </a>
                                <div id="collapseExample1" class="collapse shadow-sm show">
                                    <div class="card">
                                        <div class="card-body mt-2">
                                        <textarea name="ingredients" id="ingredients"
                                                  class="ckeditor">{!! $product->ingredients !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Trạng thái: </label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="display" type="checkbox" @if($product->display == 1) checked @endif
                                           id="flexSwitchCheckChecked">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Hiện sản phẩm</label>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Cập nhật</button>
                            <a href="{{route('admin.product.index')}}" class="btn btn-dark">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $(".selector__image").click(function () {
            $('input[name="file_product"]').trigger("click");
        });
        $('input[name="file_product"]').change(function () {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    if (input.files[0].type == 'video/mp4') {
                        let video = '<video class="w-100 h-100" style="object-fit: cover;"><source src=" ' + e.target.result + ' " type="' + input.files[0].type + '"></video>';
                        $(".selector__image").html(video);
                    } else {
                        let img = '<img src="' + e.target.result + '" class="w-100 h-100" style="object-fit: cover;">';
                        $(".selector__image").html(img);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="{{url('assets/admin/js/input_file.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/js/format_currency.js')}}" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height:'500px'
        });
        CKEDITOR.replace('ingredients', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height: '500px'
        });
    </script>
    <script>
        $('button.delete__image').confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
            buttons: {
                ok: {
                    text: 'Xóa',
                    btnClass: 'btn-danger',
                    action: function(){
                        let data = {};
                        data['id'] = this.$target.attr("value");
                        $.ajax({
                            url: window.location.origin + '/admin/product/delete-img',
                            data: data,
                            dataType: 'json',
                            type: 'post',
                            success: function (data) {
                                if (data.status){
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {}
                }
            }
        });
        $('a.btn-delete-color').confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
            buttons: {
                ok: {
                    text: 'Xóa',
                    btnClass: 'btn-danger',
                    action: function(){
                        location.href = this.$target.attr('href');
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {}
                }
            }
        });
    </script>
@endsection
