<div class="col-lg-3 col-md-4 col-sm-12 mb-gd-2 fs-sa-14">
    <div class="body-menu-list-member px-gd-2">
        <div class="d-flex justify-content-center mt-gd-1">
            <div>
                <span class="b-avatar mwe-avatar badge-secondary rounded-circle"
                       style="width: 6rem; height: 6rem;"><span class="b-avatar-custom">
                        <img
                            src="{{\Illuminate\Support\Facades\Auth::user()->avatar}}"
                            class="blur-up lazyautosizes ls-is-cached lazyloaded" style="object-fit: cover;"
                            sizes="94px"></span>
                </span></div>
        </div>
        <div class="mt-gd-1" style="overflow-wrap: break-word;">
            <div class="profile-name fw-bold">
                {{\Illuminate\Support\Facades\Auth::user()->name}}
            </div>
            <div class="email-member">
                {{\Illuminate\Support\Facades\Auth::user()->email}}
            </div>
        </div>
        <hr>
        <div class="list-member-menu">
            <a href="{{route('profile')}}" class="my-gd-1 cursor-pointer link-menu-profile @if($active_menu == 1) selected-menu @endif">
                Tài khoản của tôi
            </a>
            <a href="{{route('address')}}" class="my-gd-1 cursor-pointer link-menu-profile @if($active_menu == 2) selected-menu @endif">
                Địa chỉ
            </a>
            <a href="{{route('order-history')}}" class="my-gd-1 cursor-pointer link-menu-profile @if($active_menu == 3) selected-menu @endif">
                Lịch sử đơn hàng
            </a>
{{--            <div class="my-gd-1 cursor-pointer">--}}
{{--                Danh sách báo giá--}}
{{--            </div>--}}
{{--            <div class="my-gd-1 cursor-pointer">--}}
{{--                Danh sách mong muốn--}}
{{--            </div>--}}
{{--            <div class="my-gd-1 cursor-pointer">--}}
{{--                Phiếu giảm giá--}}
{{--            </div>--}}
            <a href="{{route('logout')}}" class="py-gd-2 mt-gd-2 border-top w-100 d-inline-block link-menu-profile" style="cursor: pointer;">
                Đăng xuất
            </a>
        </div>
    </div>
</div>
