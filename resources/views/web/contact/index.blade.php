@extends('web.index')
@section('title','Liên hệ')

@section('style_page')
    <link rel="stylesheet" href="{{asset('assets/css/contact.css')}}">
@stop
{{--content of page--}}
@section('content')

    <div class="box-content-web mb-5 mt-5">
        <p class="title-contact">Liên hệ với chúng tôi</p>
        <div class="line-contact">
            <i class="fa-solid fa-location-dot"></i>
            <span>Địa chỉ: {{@$contact->address}}</span>
        </div>
        <div class="line-contact">
            <i class="fa-solid fa-phone"></i>
            <span>Số điện thoại: {{@$contact->phone}}</span>
        </div>
        <div class="line-contact">
            <i class="fa-solid fa-envelope"></i>
            <span>Email: {{@$contact->email}}</span>
        </div>

        <div class="box-content-contact">

            <form action="{{ route('send.contact') }}" method="POST" class="content-left">
                @csrf

                <div class="text-input-contact d-flex">Họ tên<span class="text-red">*</span></div>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <input type="text" class="input-content" name="name" value="{{ old('name') }}" required>

                <div class="text-input-contact d-flex">Email<span class="text-red">*</span></div>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <input type="text" class="input-content" name="email" value="{{ old('email') }}" required>

                <div class="text-input-contact d-flex">Số điện thoại<span class="text-red">*</span></div>
                @error('phone')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <input type="text" class="input-content" name="phone" value="{{ old('phone') }}" required>

                <div class="text-input-contact d-flex">Công ty<span class="text-red">*</span></div>
                <input type="text" class="input-content" name="company" value="{{ old('company') }}" required>

                <div class="text-input-contact d-flex">Lời nhắn<span class="text-red">*</span></div>
                <textarea name="content" class="input-content" rows="4" required>{{ old('content') }}</textarea>

                <button type="submit" class="btn-send-contact"><i class="fa-solid fa-envelope"></i> Gửi tin nhắn</button>
            </form>

            <div class="content-right">
                {!! @$contact->map?$contact->map:'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14907.530116248008!2d105.88661864827655!3d20.917045291268437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ae18d97fbdc7%3A0x3d8fb9d0a3311a9!2zVuG6oW4gUGjDumMsIFRoYW5oIFRyw6wsIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1733233755813!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'!!}
            </div>
        </div>
    </div>


@stop
@section('script_page')

@stop
