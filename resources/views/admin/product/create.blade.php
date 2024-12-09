@extends('admin.layout.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{route('admin.product.store')}}" enctype="multipart/form-data"
                          class="card p-3">
                        @csrf
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Tên sản phẩm :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Danh mục :</p>
                            </div>
                            <div class="col-9">
                                <select name="category_id" class="form-control" required>
                                    @foreach($category as $categorys)
                                        <option value="{{$categorys->id}}">{{$categorys->name}}</option>
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
                                        <option value="{{$trademarks->id}}">{{$trademarks->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Mô tả ngắn:</div>
                            <div class="col-8">
                                <textarea name="describe" class="form-control"  rows="6" required>{{ old('describe') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Giá bán :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control price format-currency" value="{{old('price')}}" name="price"
                                       required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Số lượng :</p>
                            </div>
                            <div class="col-9">
                                <input type="number" class="form-control price" value="{{old('quantity')}}" name="quantity" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Ảnh bìa sản phẩm :</p>
                            </div>
                            <div class="col-9">
                                <div class="d-flex align-items-center selector__image justify-content-center"
                                     style="width: 200px; height: 250px; background: #f0f0f0;cursor: pointer">
                                    <i style="font-size: 30px" class="bi bi-download"></i>
                                </div>
                                <input type="file" hidden name="file_product" accept="image/*">
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                Hình ảnh sản phẩm
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
                                        <textarea name="content" id="content" required
                                                  class="ckeditor">{{ old('content') }}</textarea>
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
                                        <textarea name="ingredients" id="ingredients" required
                                                  class="ckeditor">{{ old('ingredients') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Trạng thái: </label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="display" type="checkbox" checked
                                           id="flexSwitchCheckChecked">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Hiện sản phẩm</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Tạo mới</button>
                            <a href="{{route('admin.product.index')}}" class="btn btn-dark">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="{{url('assets/admin/js/input_file.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/js/format_currency.js')}}" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height: '500px'
        });
        CKEDITOR.replace('ingredients', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height: '500px'
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
@endsection
