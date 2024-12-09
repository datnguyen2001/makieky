@extends('web.index')
@section('title','Tài khoản của tôi')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/account.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-5">

        <div class="row mb-gd-2">
            @include('web.account.menu')
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="content-info">
                    <div class="body-my-account">
                        <div class="wrapper-my-account ml-gd-3 px-0 py-gd-1">
                            <div class="member-my-account">
                                Tài khoản của tôi
                            </div>
                        </div>
                        <hr class="mt-0">
                        <form method="POST" action="{{route('update-profile')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-gd-3 container-fluid px-gd-2">
                                <div class="row">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3">
                                        Ảnh đại diện
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div>
                                            <span class="b-avatar mwe-avatar badge-secondary rounded-circle" style="width: 6rem; height: 6rem;">
                                                <span class="b-avatar-custom">
                                                    <img id="avatarPreview"
                                                         src="{{@$data->avatar}}"
                                                         width="100" height="100" class="blur-up lazyautosizes ls-is-cached lazyloaded"
                                                         style="object-fit: cover;">
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <label for="files" class="text-member-profile cursor-pointer">Thay đổi hình
                                                ảnh hồ sơ</label>
                                            <input type="file" id="files" name="avatar" accept="image/jpeg, image/png"
                                                   class="custom-file-input" hidden>
                                            <div class="text-member-gride">Tệp hỗ trợ: .JPEG, .PNG</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3 align-self-center">
                                        Tên
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <input type="text" class="form-control" name="name" value="{{@$data->name}}">
                                    </div>
                                </div>
                                <div class="row mt-gd-2 d-flex align-items-center">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3 align-self-center">
                                        E-mail
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div>
                                            <input type="text" disabled="disabled" class="form-control"
                                                   value="{{@$data->email}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3 align-self-center">
                                        <div class="text-member">
                                            Số điện thoại
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <input type="number" name="phone" class="form-control" value="{{@$data->phone}}">
                                    </div>
                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3 align-self-center">
                                        Giới tính
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div role="radiogroup" tabindex="-1" class="bv-no-focus-ring" id="__BVID__1515">
                                            <div class="custom-control custom-control-inline custom-radio">
                                                <input type="radio" name="gender" class="custom-control-input" value="1" id="__BVID__1515_BV_option_0"
                                                       @if(@$data->gender == 1) checked @endif>
                                                <label class="custom-control-label"
                                                       for="__BVID__1515_BV_option_0"><span>Nam</span></label>
                                            </div>
                                            <div class="custom-control custom-control-inline custom-radio">
                                                <input type="radio" name="gender" class="custom-control-input" value="2" id="__BVID__1515_BV_option_1"
                                                       @if(@$data->gender == 2) checked @endif>
                                                <label class="custom-control-label"
                                                       for="__BVID__1515_BV_option_1"><span>Nữ</span></label>
                                            </div>
                                            <div class="custom-control custom-control-inline custom-radio">
                                                <input type="radio" name="gender" class="custom-control-input" value="3" id="__BVID__1515_BV_option_2"
                                                       @if(@$data->gender == 3) checked @endif>
                                                <label class="custom-control-label"
                                                       for="__BVID__1515_BV_option_2"><span>Khác</span></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3 align-self-center">
                                        Ngày sinh
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div class="my-datepicker-wrapper">
                                            <div class="d-flex">
                                                <div class="vdp-datepicker" style="width: 100%;">
                                                    <div class="input-group">
                                                        <input type="date" id="dateStart" name="birth_date" value="{{@$data->date_of_birth}}"
                                                               autocomplete="off"
                                                               class="my-input-datepicker fixed-height css-block-inline full-width calendar mwe-input readOnly cursor-pointer form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-gd-3">
                                    <div class="col-12 col-md-3 pr-0 ml-gd-3"></div>
                                    <div class="col-12 col-md-6 d-flex pl-0">
                                        <button type="submit"
                                                class="btn btn-system-main button-save-member btn-secondary">
                                            Lưu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="body-my-account-update-password mt-gd-3">
                        <div class="wrapper-my-account ml-gd-3 px-0 py-gd-1">
                            <div class="member-my-account">
                                Cập nhật mật khẩu
                            </div>
                        </div>
                        <hr class="mt-0">
                        <form method="POST" action="{{route('change-password')}}">
                            @csrf
                            <div class="mb-gd-3 container-fluid px-gd-2">
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 ml-gd-3 px-0">
                                        Mật khẩu hiện tại
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div>
                                            <div class="fs-sa">
                                                <div style="position: relative;">
                                                    <input name="password" type="password"
                                                           placeholder="Trường mật khẩu là bắt buộc."
                                                           class="form-control" value="{{old('password')}}">
                                                </div>
                                                @error('password')
                                                <div class="error-message">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 ml-gd-3 px-0">
                                        <div class="text-member">
                                            Mật khẩu mới
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div>
                                            <div style="position: relative;">
                                                <input name="newPassword" type="password" placeholder="Mật khẩu mới"
                                                       class="form-control" value="{{old('newPassword')}}">
                                            </div>
                                            @error('newPassword')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>

                                        </div>
                                        <div class="d-inline-block pt-6">
                                            <div class="text-member-gride">
                                                * Mật khẩu phải dài từ 8 ký tự trở lên.
                                            </div>
                                            <div class="text-member-gride">
                                                * Mật khẩu phải bao gồm một chữ hoa (AZ), chữ thường (az) và số.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-gd-2">
                                    <div class="col-12 col-md-3 px-0 ml-gd-3">
                                        <div class="text-member">
                                            Xác nhận mật khẩu mới.
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 pl-0">
                                        <div>
                                            <div style="position: relative;">
                                                <input name="confNewpassword" type="password"
                                                       placeholder="Xác nhận mật khẩu mới." class="form-control"
                                                       value="{{old('confNewpassword')}}">
                                            </div>
                                            @error('newPassword')
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-gd-3">
                                    <div class="col-12 col-md-8 d-flex pl-0">
                                        <button type="submit"
                                                class="btn button-save-member btn-system-main btn-secondary">
                                            Thay đổi mật khẩu
                                        </button>
                                        {{--                                    <button type="button"--}}
                                        {{--                                            class="btn button-cancel-member btn-system-secondary ml-gd-1 btn-secondary">--}}
                                        {{--                                        Hủy bỏ--}}
                                        {{--                                    </button>--}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
@section('script_page')
    <script>

        document.getElementById("files").addEventListener("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("avatarPreview").src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

    </script>
@stop
