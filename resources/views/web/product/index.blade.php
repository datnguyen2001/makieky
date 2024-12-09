@extends('web.index')
@section('title','Chi tiết sản phẩm')

@section('style_page')
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/product.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5">
        <div class="product-breadcrumb">
            <a href="{{route('home')}}" class="item-breadcrumb">Trang chủ</a>
            <span class="item-breadcrumb"> <i class="fa-solid fa-angle-right"></i> </span>
            <span class="item-breadcrumb">{{$data->category->name}}</span>
            <span class="item-breadcrumb"> <i class="fa-solid fa-angle-right"></i> </span>
            <span class="item-breadcrumb item-breadcrumb-active">{{$data->name}}</span>
        </div>

        <div class="box-detail-product">
            <div class="box-img-sp">
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff;margin-bottom: 10px"
                     class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        @foreach($productImage as $image)
                            <a href="{{asset($image->src)}}" data-lightbox="gallery" class="swiper-slide">
                                <img class="zoom-image w-100" src="{{asset($image->src)}}"/>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach($productImage as $image)
                            <div class="swiper-slide">
                                <img src="{{asset($image->src)}}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="box-content-detail-sp">
                <input type="text" class="product_id" value="{{$data->id}}" hidden>
                <p class="name-detail-sp">{{$data->name}}</p>
                <div class="d-flex align-items-center gap-1">
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
                <div class="describe-sp">
                    {{$data->describe}}
                </div>
                <div class="price-detail-sp">
                    {{number_format($data->price)}}đ
                </div>
                <div class="line-number-sp">
                    <span class="name-number">Số lượng</span>
                    <div class="box-number-sp">
                        <button class="btn-mimus"><i class="fa-solid fa-minus"></i></button>
                        <input type="text" class="number-sp" value="1">
                        <button class="btn-plus"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="line-btn-add-cart">
                    <button class="btn-add-carts">Thêm vào giỏ hàng</button>
                    <button class="btn-buy-now">Mua ngay</button>
                </div>
                <div class="line-cate-more">
                    <div>Danh mục: <a href="{{route('category',$data->category->slug)}}">{{$data->category->name}}</a>
                    </div>
                </div>
                <div class="line-cate-more">
                    <div>Thương hiệu: <a href="{{route('trademark',$data->trademark->slug)}}">{{$data->trademark->name}}</a></div>
                </div>
            </div>
        </div>

        <div class="box-content-info">
            <div class="line-tabs">
                <div class="tab tab-active" onclick="switchTab(1)">Mô tả sản phẩm</div>
                <div class="tab " onclick="switchTab(2)">Thành phần</div>
                <div style="border-bottom: 1px solid #dee3e6;width: calc(100% - 300px)"></div>
            </div>
            <div class="content-info-1">
                {!! $data->content !!}
            </div>
            <div class="content-info-2">
                {!! $data->ingredients !!}
            </div>
        </div>

        @if($related_products && count($related_products)>0)
            <p class="title-related-product">Sản phẩm liên quan</p>
            <div class="box-list-all-sp-cate">
                @foreach($related_products as $item)
                    <div class="item-all-sp">
                        <a href="{{route('detail-product',$item->slug)}}" class="d-flex flex-column justify-content-center gap-2">
                            <img src="{{asset($item->src)}}">
                            <p class="name-sp">{{$item->name}}</p>
                            <p class="price-sp">{{number_format($item->price)}}đ</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


@stop
@section('script_page')
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/js/lightbox.min.js"></script>
    <script src="{{asset('assets/js/product.js')}}"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            spaceBetween: 10,
            thumbs: {
                swiper: swiper,
            },
            zoom: true,
        });
        document.querySelectorAll('.zoom-image').forEach(function (image) {
            image.addEventListener('mousemove', function (event) {
                const rect = image.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width * 100;
                const y = (event.clientY - rect.top) / rect.height * 100;
                image.style.transformOrigin = `${x}% ${y}%`;
                image.style.transform = "scale(1.6)";
            });

            image.addEventListener('mouseleave', function () {
                image.style.transform = "scale(1)";
            });
        });

    </script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })

        function switchTab(tabNumber) {
            // Ẩn tất cả các content-info
            document.querySelector('.content-info-1').style.display = 'none';
            document.querySelector('.content-info-2').style.display = 'none';

            // Xóa class tab-active từ tất cả các tab
            let tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.classList.remove('tab-active');
            });

            // Hiển thị content tương ứng và thêm class tab-active vào tab đang được chọn
            if (tabNumber === 1) {
                document.querySelector('.content-info-1').style.display = 'inline-block';
                document.querySelector('.line-tabs .tab:nth-child(1)').classList.add('tab-active');
            } else if (tabNumber === 2) {
                document.querySelector('.content-info-2').style.display = 'inline-block';
                document.querySelector('.line-tabs .tab:nth-child(2)').classList.add('tab-active');
            }
        }
    </script>
@stop
