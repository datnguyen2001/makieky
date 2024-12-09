@extends('web.index')
@section('title','Trang chủ')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/home.css')}}">
@stop
{{--content of page--}}
@section('content')
    @if($banner && count($banner)>0)
        <div class="swiper mySwiperBanner">
            <div class="swiper-wrapper">
                @foreach($banner as $banners)
                    <a @if($banners->link) href="{{$banners->link}}" @endif class="swiper-slide">
                        <img src="{{asset($banners->src)}}">
                    </a>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    @endif

    @if($introduce)
        <div class="box-content-web d-flex align-items-center justify-content-between flex-wrap-reverse mb-5 mt-5">
            <div class="box-left-img">
                <img src="{{asset($introduce->src)}}" alt="">
            </div>
            <div class="box-right-content-img">
                <p class="title-gt1">{{$introduce->name}}</p>
                <div class="line-text-hot"></div>
                <div class="content-gt1">
                    {{$introduce->describe}}
                </div>
                <a href="{{route('detail',$introduce->slug)}}" class="btn-more">Xem thêm</a>
            </div>
        </div>
    @endif

    @if($product && count($product))
        <div class="box-all-product">
            <div class="box-content-web box-big-all-sp">
                <p class="title-all-product">TẤT CẢ SẢN PHẨM</p>
                <div class="box-list-all-sp">
                    @foreach($product as $products)
                        <div class="item-all-sp">
                            <a href="{{route('detail-product',$products->slug)}}" class="d-flex flex-column justify-content-center gap-2">
                                <img src="{{asset($products->src)}}">
                                <p class="name-sp">{{$products->name}}</p>
                                <p class="price-sp">{{number_format($products->price)}}đ</p>
                                <a class="btn-add-cart" data-value="{{$products->id}}" style="cursor: pointer">Thêm vào giỏ hàng</a >
                                <div class="d-flex justify-content-center">
                                    <div class="rating-star-comp pointer-none d-flex align-items-center">
                                        <div class="star"><i
                                                class="fas fa-star star-disabled"></i></div>
                                        <div class="star"><i
                                                class="fas fa-star star-disabled"></i></div>
                                        <div class="star"><i
                                                class="fas fa-star star-disabled"></i></div>
                                        <div class="star"><i
                                                class="fas fa-star star-disabled"></i></div>
                                        <div class="star"><i
                                                class="fas fa-star star-disabled"></i></div>
                                    </div>
                                    <div class="number-star">(0)</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($promote && count($promote)>0)
        <div class="box-content-web box-sp-option">
            @foreach($promote as $promotes)
                <a href="{{$promotes->link}}" class="item-sp-option">
                    <img src="{{asset($promotes->src)}}">
                    <p class="name-sp-option name-none-sp">{{$promotes->name}}</p>
                    <div class="box-nen-name-sp">
                        <p class="name-sp-option">{{$promotes->name}}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@stop
@section('script_page')
    <script>
        var swiper = new Swiper(".mySwiperBanner", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
@stop
