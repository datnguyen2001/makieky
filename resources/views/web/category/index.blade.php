@extends('web.index')
@section('title',$nameCate)

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/category.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5">
        <div class="product-breadcrumb">
            <a href="{{route('home')}}" class="item-breadcrumb">Trang chủ</a>
            <span class="item-breadcrumb"> <i class="fa-solid fa-angle-right"></i> </span>
            <span class="item-breadcrumb item-breadcrumb-active">{{$nameCate}}</span>
        </div>
        <p class="title-all-category">{{$nameCate}}</p>
        <div class="line-filter">
            <span>Tìm thấy {{count($listData)}} mặt hàng</span>
            <div class="sort-by">
                <span>Sắp xếp theo</span>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                       {{$nameSort}}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item px-2" href="{{ route('category', ['slug' => $slug, 'sort' => 'newest']) }}">Hàng mới về</a></li>
                        <li><a class="dropdown-item px-2" href="{{ route('category', ['slug' => $slug, 'sort' => 'bestselling']) }}">Bán chạy nhất</a></li>
                        <li><a class="dropdown-item px-2" href="{{ route('category', ['slug' => $slug, 'sort' => 'price_asc']) }}">Giá thấp đến cao</a></li>
                        <li><a class="dropdown-item px-2" href="{{ route('category', ['slug' => $slug, 'sort' => 'price_desc']) }}">Giá cao đến thấp</a></li>
                        <li><a class="dropdown-item px-2" href="{{ route('category', ['slug' => $slug, 'sort' => 'name_asc']) }}">Name A-Z</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @if($listData && count($listData)>0)
            <div class="box-list-all-sp-cate">
                @foreach($listData as $item)
                    <div class="item-all-sp">
                        <a href="{{route('detail-product',$item->slug)}}" class="d-flex flex-column justify-content-center gap-2">
                            <img src="{{asset($item->src)}}">
                            <p class="name-sp">{{$item->name}}</p>
                            <p class="price-sp">{{number_format($item->price)}}đ</p>
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

            <div class="w-100 d-flex justify-content-center mt-4">
                {{ $listData->appends(request()->all())->links('web.partials.pagination') }}
            </div>
        @endif
    </div>


@stop
@section('script_page')

@stop
