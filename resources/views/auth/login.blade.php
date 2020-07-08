@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')
<div class="center" id="hlcenter" style="; border: none;">
    <div id="container" class="w-clear">
        <div id="col_920" class="col_920_right">
            <div class="form-container" data-reactid="42">
                <!-- react-empty: 43 -->
                <div class="form-title col-lg-12 col-md-12 col-xs-12">{{ __('front.Login') }}</div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    @error('common')
                    <i style="color:red">{{ $message }}</i>
                    @enderror

                    <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="{{ __('front.E-Mail Address') }}">
                    @error('email')
                    <i style="color:red">{{ $message }}</i>
                    @enderror
                    <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" placeholder="{{ __('front.Password') }}">
                    @error('password')
                    <i style="color:red">{{ $message }}</i>
                    @enderror
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0px">
                            <button type="submit" class="btn btn-login" id="btn-login" style="">{{ __('front.Login') }}</button>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                    <button type="button" class="btn" onclick="window.location.href= '{{ route('password.request') }}'" style="background: #ebebeb; margin-bottom: 0; color: #000;">{{ __('front.Forgot Your Password?') }}</button>
                    @endif
                    <div class="form-separator" data-reactid="55"><span data-reactid="56">{{ __('front.Create a account?') }}</span>
                    </div>
                    <div class="form-group group-2">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <button type="button" class="btn btn-success" onclick="window.location.href= '{{ route('register') }}'">{{ __('front.Register') }}</button>
                        </div>
                    </div>
                </form>
                <!-- react-empty: 64 -->
            </div>
        </div>
    </div>
</div>
@endsection
