@extends('web.index')
@section('title','Tìm kiếm sản phẩm')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/category.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-5">
        <form action="{{ route('search') }}" method="GET" id="append" role="group" class="input-group">
            <input type="text" placeholder="Tìm kiếm sản phẩm" name="search" class="form-control" id="__BVID__324">
            <button type="submit" class="input-group-append" style="border: none">
                <div class="input-group-text h-100"><i class="fa-solid fa-magnifying-glass"></i></div>
            </button>
        </form>
        <div class="d-flex justify-content-center mt-5 mb-5">
            <span>Kết quả tìm kiếm cho "{{$search}}" tìm thấy {{count($listData)}} mục</span>
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
