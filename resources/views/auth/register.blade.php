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
                <div class="form-title col-lg-12 col-md-12 col-xs-12">{{ __('front.Register') }}</div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <input placeholder="{{ __('front.Name') }}" class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                    <i style="color:red">{{ $message }}</i>
                    @enderror
                    <input placeholder="{{ __('front.E-Mail Address') }}" class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                    <i style="color:red">{{ $message }}</i>
                    @enderror

                    <input placeholder="{{ __('front.Password') }}" class="form-control" id="password" name="password" type="password" value="{{ old('password') }}">
                    @error('password')
                    <i style="color:red">{{ $message }}</i>
                    @enderror

                    <input placeholder="{{ __('front.Confirm Password') }}" class="form-control" id="password_confirmation" name="password_confirmation" type="password" value="{{ old('re_password') }}">


                    <div style="text-align: center" class="checkbox">
                        @foreach(Config::get('settings.USER_TYPE') as $key => $userType)
                                <label><input type="checkbox" name="user_type[]" value="{{ $userType['code'] }}">{{ __('front.'.$key) }}</label>
                        @endforeach
                    </div>

                    @error('user_type')
                    <i style="color:red">{{ $message }}</i>
                    @enderror

                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0px">
                            <button type="submit" class="btn btn-login" id="btn-register" style="" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">{{ __('front.Register') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
