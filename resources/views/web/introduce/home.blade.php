@extends('web.index')
@section('title','Danh mục')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/category.css')}}">
    <style>
        .title-all-category{
            margin-bottom: 0;
        }
        .box-content-introduce img{
            max-width: 100%;
            object-fit: cover;
        }
    </style>
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5">
        <p class="title-all-category">{{$data->name}}</p>
        <div class="box-content-introduce">{!! $data->content !!}</div>
    </div>


@stop
@section('script_page')

@stop
