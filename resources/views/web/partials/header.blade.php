@php
    $category = \App\Models\CategoryModel::where('display',1)->orderBy('created_at','desc')->limit(3)->get();
@endphp
<div class="header-desktop">
    <div class="header-top">
        <div class="box-content-web d-flex justify-content-end align-center gap-4">
            <div class="d-flex align-items-center btn-search-header">
                <svg class="icon-search" width="14" height="15" viewBox="0 0 14 15" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.918 13.6641C13.9727 13.7188 14 13.8008 14 13.8828C14 13.9922 13.9727 14.0742 13.918 14.1289L13.2891 14.7305C13.207 14.8125 13.125 14.8398 13.043 14.8398C12.9336 14.8398 12.8789 14.8125 12.8242 14.7305L9.48828 11.4219C9.43359 11.3672 9.40625 11.2852 9.40625 11.2031V10.8203C8.88672 11.2578 8.3125 11.6133 7.68359 11.8594C7.02734 12.1055 6.37109 12.2148 5.6875 12.2148C4.64844 12.2148 3.69141 11.9688 2.81641 11.4492C1.94141 10.957 1.25781 10.2734 0.765625 9.39844C0.246094 8.52344 0 7.56641 0 6.52734C0 5.48828 0.246094 4.55859 0.765625 3.68359C1.25781 2.80859 1.94141 2.125 2.81641 1.60547C3.69141 1.11328 4.64844 0.839844 5.6875 0.839844C6.72656 0.839844 7.65625 1.11328 8.53125 1.60547C9.40625 2.125 10.0898 2.80859 10.6094 3.68359C11.1016 4.55859 11.375 5.48828 11.375 6.52734C11.375 7.23828 11.2383 7.89453 10.9922 8.52344C10.7461 9.17969 10.418 9.75391 9.98047 10.2461H10.3633C10.4453 10.2461 10.5273 10.2734 10.582 10.3281L13.918 13.6641ZM5.6875 10.9023C6.45312 10.9023 7.19141 10.7109 7.875 10.3281C8.53125 9.94531 9.07812 9.39844 9.46094 8.71484C9.84375 8.05859 10.0625 7.32031 10.0625 6.52734C10.0625 5.76172 9.84375 5.02344 9.46094 4.33984C9.07812 3.68359 8.53125 3.13672 7.875 2.75391C7.19141 2.37109 6.45312 2.15234 5.6875 2.15234C4.89453 2.15234 4.15625 2.37109 3.5 2.75391C2.81641 3.13672 2.26953 3.68359 1.88672 4.33984C1.50391 5.02344 1.3125 5.76172 1.3125 6.52734C1.3125 7.32031 1.50391 8.05859 1.88672 8.71484C2.26953 9.39844 2.81641 9.94531 3.5 10.3281C4.15625 10.7109 4.89453 10.9023 5.6875 10.9023Z"
                        fill="#9A9A9A"></path>
                </svg>
            </div>
            @if(\Illuminate\Support\Facades\Auth::check())
                <a class="btn-dk-dn" style="cursor: pointer" data-bs-toggle="dropdown" aria-expanded="false">Tài khoản
                    của
                    tôi</a>
                <ul class="dropdown-menu dropdown-menu-header">
                    <li><a class="dropdown-item dropdown-item-first">Chào mừng!</a></li>
                    <li><a class="dropdown-item"
                           href="{{route('profile')}}">{{\Illuminate\Support\Facades\Auth::user()->email}}</a></li>
                    <div class="line-dropdown-item"></div>
                    <li><a class="dropdown-item" href="{{route('profile')}}">Tài khoản của tôi</a></li>
                    <li><a class="dropdown-item" href="{{route('address')}}">Địa chỉ</a></li>
                    <li><a class="dropdown-item" href="{{route('order-history')}}">Lịch sử đơn hàng</a></li>
{{--                    <li><a class="dropdown-item" href="#">Trích dẫn</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Danh sách mong muốn</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Phiếu giảm giá</a></li>--}}
                    <div class="line-dropdown-item"></div>
                    <li><a class="dropdown-item" href="{{route('logout')}}">Đăng xuất</a></li>
                </ul>
            @else
                <a href="{{route('login')}}" class="btn-dk-dn">Đăng nhập</a>
                <a href="{{route('register')}}" class="btn-dk-dn">Đăng ký</a>
            @endif
            <a href="{{route('get-cart')}}" class="position-relative d-flex align-items-center">
                <svg class="cart-icon" width="22" height="24" viewBox="0 0 22 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.7826 7.5H21.2826V20.25C21.2826 21.2812 20.9076 22.1719 20.1576 22.9219C19.4076 23.6719 18.5639 24 17.5326 24H4.03261C3.00136 24 2.11073 23.6719 1.36073 22.9219C0.610733 22.1719 0.282608 21.2812 0.282608 20.25V7.5H4.78261V6C4.78261 4.92188 5.01698 3.9375 5.57948 3C6.09511 2.0625 6.79823 1.35938 7.73573 0.796875C8.67323 0.28125 9.65761 0 10.7826 0C11.8607 0 12.8451 0.28125 13.7826 0.796875C14.7201 1.35938 15.4232 2.0625 15.9857 3C16.5014 3.9375 16.7826 4.92188 16.7826 6V7.5ZM7.78261 6V7.5H13.7826V6C13.7826 5.20312 13.4545 4.5 12.892 3.89062C12.2826 3.32812 11.5795 3 10.7826 3C9.93886 3 9.23573 3.32812 8.67323 3.89062C8.06386 4.5 7.78261 5.20312 7.78261 6ZM15.2826 11.625C15.5639 11.625 15.8451 11.5312 16.0795 11.2969C16.267 11.1094 16.4076 10.8281 16.4076 10.5C16.4076 10.2188 16.267 9.9375 16.0795 9.70312C15.8451 9.51562 15.5639 9.375 15.2826 9.375C14.9545 9.375 14.6732 9.51562 14.4857 9.70312C14.2514 9.9375 14.1576 10.2188 14.1576 10.5C14.1576 10.8281 14.2514 11.1094 14.4857 11.2969C14.6732 11.5312 14.9545 11.625 15.2826 11.625ZM6.28261 11.625C6.56386 11.625 6.84511 11.5312 7.07948 11.2969C7.26698 11.1094 7.40761 10.8281 7.40761 10.5C7.40761 10.2188 7.26698 9.9375 7.07948 9.70312C6.84511 9.51562 6.56386 9.375 6.28261 9.375C5.95448 9.375 5.67323 9.51562 5.48573 9.70312C5.25136 9.9375 5.15761 10.2188 5.15761 10.5C5.15761 10.8281 5.25136 11.1094 5.48573 11.2969C5.67323 11.5312 5.95448 11.625 6.28261 11.625Z"
                        fill="#373E44"></path>
                </svg>
                <span class="badge-number">0</span>
            </a>
        </div>
    </div>
    <div class="header-main">
        <div class="box-content-web d-flex justify-content-between align-center gap-4" style="padding:8px 0px;">
            <a href="{{route('home')}}"><img
                    src="{{ asset(@$setting->logo?@$setting->logo:'https://image.makewebeasy.net/makeweb/m_480x240/4mNdJ2T2B/DefaultData/Logo_website.png?v=202405291424') }}"
                    class="img-logo"></a>
            <div class="menu-header">
                <a href="{{route('home')}}">Trang chủ</a>
                <a href="{{route('category','all')}}">Tất cả sản phẩm</a>
                @if($category && count($category))
                    @foreach($category as $categorys)
                        <a href="{{route('category',$categorys->slug)}}">{{$categorys->name}}</a>
                    @endforeach
                @endif
                <a href="{{route('order-tracking')}}">Theo dõi đơn hàng</a>
                <a href="{{route('contact')}}">Liên hệ</a>
            </div>
        </div>
    </div>
</div>

<div class="header-mobile">
    <a class="btn btn-menu-mobile" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
       aria-controls="offcanvasExample">
        <i class="fa-solid fa-bars"></i>
    </a>
    <a href="{{route('home')}}"><img
            src="{{ asset(@$setting->logo?@$setting->logo:'https://image.makewebeasy.net/makeweb/m_480x240/4mNdJ2T2B/DefaultData/Logo_website.png?v=202405291424') }}"
            class="img-logo" style="width: 100px;height: 40px;object-fit: contain"></a>
    <div class="d-flex align-items-center">
        <div class="d-flex align-items-center btn-search-header btn-search-header-mobile">
            <svg class="icon-search" width="14" height="15" viewBox="0 0 14 15" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13.918 13.6641C13.9727 13.7188 14 13.8008 14 13.8828C14 13.9922 13.9727 14.0742 13.918 14.1289L13.2891 14.7305C13.207 14.8125 13.125 14.8398 13.043 14.8398C12.9336 14.8398 12.8789 14.8125 12.8242 14.7305L9.48828 11.4219C9.43359 11.3672 9.40625 11.2852 9.40625 11.2031V10.8203C8.88672 11.2578 8.3125 11.6133 7.68359 11.8594C7.02734 12.1055 6.37109 12.2148 5.6875 12.2148C4.64844 12.2148 3.69141 11.9688 2.81641 11.4492C1.94141 10.957 1.25781 10.2734 0.765625 9.39844C0.246094 8.52344 0 7.56641 0 6.52734C0 5.48828 0.246094 4.55859 0.765625 3.68359C1.25781 2.80859 1.94141 2.125 2.81641 1.60547C3.69141 1.11328 4.64844 0.839844 5.6875 0.839844C6.72656 0.839844 7.65625 1.11328 8.53125 1.60547C9.40625 2.125 10.0898 2.80859 10.6094 3.68359C11.1016 4.55859 11.375 5.48828 11.375 6.52734C11.375 7.23828 11.2383 7.89453 10.9922 8.52344C10.7461 9.17969 10.418 9.75391 9.98047 10.2461H10.3633C10.4453 10.2461 10.5273 10.2734 10.582 10.3281L13.918 13.6641ZM5.6875 10.9023C6.45312 10.9023 7.19141 10.7109 7.875 10.3281C8.53125 9.94531 9.07812 9.39844 9.46094 8.71484C9.84375 8.05859 10.0625 7.32031 10.0625 6.52734C10.0625 5.76172 9.84375 5.02344 9.46094 4.33984C9.07812 3.68359 8.53125 3.13672 7.875 2.75391C7.19141 2.37109 6.45312 2.15234 5.6875 2.15234C4.89453 2.15234 4.15625 2.37109 3.5 2.75391C2.81641 3.13672 2.26953 3.68359 1.88672 4.33984C1.50391 5.02344 1.3125 5.76172 1.3125 6.52734C1.3125 7.32031 1.50391 8.05859 1.88672 8.71484C2.26953 9.39844 2.81641 9.94531 3.5 10.3281C4.15625 10.7109 4.89453 10.9023 5.6875 10.9023Z"
                    fill="#9A9A9A"></path>
            </svg>
        </div>
        <a href="{{route('get-cart')}}" class="position-relative d-flex align-items-center" style="padding-right: 6px">
            <svg class="cart-icon" width="22" height="24" viewBox="0 0 22 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.7826 7.5H21.2826V20.25C21.2826 21.2812 20.9076 22.1719 20.1576 22.9219C19.4076 23.6719 18.5639 24 17.5326 24H4.03261C3.00136 24 2.11073 23.6719 1.36073 22.9219C0.610733 22.1719 0.282608 21.2812 0.282608 20.25V7.5H4.78261V6C4.78261 4.92188 5.01698 3.9375 5.57948 3C6.09511 2.0625 6.79823 1.35938 7.73573 0.796875C8.67323 0.28125 9.65761 0 10.7826 0C11.8607 0 12.8451 0.28125 13.7826 0.796875C14.7201 1.35938 15.4232 2.0625 15.9857 3C16.5014 3.9375 16.7826 4.92188 16.7826 6V7.5ZM7.78261 6V7.5H13.7826V6C13.7826 5.20312 13.4545 4.5 12.892 3.89062C12.2826 3.32812 11.5795 3 10.7826 3C9.93886 3 9.23573 3.32812 8.67323 3.89062C8.06386 4.5 7.78261 5.20312 7.78261 6ZM15.2826 11.625C15.5639 11.625 15.8451 11.5312 16.0795 11.2969C16.267 11.1094 16.4076 10.8281 16.4076 10.5C16.4076 10.2188 16.267 9.9375 16.0795 9.70312C15.8451 9.51562 15.5639 9.375 15.2826 9.375C14.9545 9.375 14.6732 9.51562 14.4857 9.70312C14.2514 9.9375 14.1576 10.2188 14.1576 10.5C14.1576 10.8281 14.2514 11.1094 14.4857 11.2969C14.6732 11.5312 14.9545 11.625 15.2826 11.625ZM6.28261 11.625C6.56386 11.625 6.84511 11.5312 7.07948 11.2969C7.26698 11.1094 7.40761 10.8281 7.40761 10.5C7.40761 10.2188 7.26698 9.9375 7.07948 9.70312C6.84511 9.51562 6.56386 9.375 6.28261 9.375C5.95448 9.375 5.67323 9.51562 5.48573 9.70312C5.25136 9.9375 5.15761 10.2188 5.15761 10.5C5.15761 10.8281 5.25136 11.1094 5.48573 11.2969C5.67323 11.5312 5.95448 11.625 6.28261 11.625Z"
                    fill="#B71B6FFF"></path>
            </svg>
            <span class="badge-number">0</span>
        </a>
    </div>
</div>

<div id="topSearchBar" class="collapse topSearchBar collapse" style="display: none">
    <div class="topSearchBarInner">
        <form action="{{ route('search') }}" method="GET" id="append" role="group" class="input-group">
            <input type="text" placeholder="Tìm kiếm sản phẩm" name="search" class="form-control" id="__BVID__324">
            <button type="submit" class="input-group-append" style="border: none">
                <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
            </button>
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header" style="padding: 10px 10px 10px 20px">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
        <div style="font-size: 24px;padding: 0px 10px;color: #B71B6FFF" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-solid fa-xmark"></i></div>
    </div>
    <div class="offcanvas-body p-0">
        <div class="d-flex flex-column">
            <a href="{{route('home')}}" class="item-menu-mobile item-menu-mobile-active">Trang chủ</a>
            <a href="{{route('category','all')}}" class="item-menu-mobile">Tất cả sản phẩm</a>
            @if($category && count($category))
                @foreach($category as $categorys)
                    <a href="{{route('category',$categorys->slug)}}" class="item-menu-mobile">{{$categorys->name}}</a>
                @endforeach
            @endif
            <a href="{{route('contact')}}" class="item-menu-mobile">Liên hệ</a>
            @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{route('profile')}}" class="item-menu-mobile">Tài khoản của tôi</a>
            @else
                <a href="{{route('login')}}" class="item-menu-mobile">Đăng nhập</a>
                <a href="{{route('register')}}" class="item-menu-mobile">Đăng ký</a>
            @endif
        </div>
    </div>
</div>

