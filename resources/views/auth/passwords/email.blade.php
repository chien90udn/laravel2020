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
                <div class="form-title col-lg-12 col-md-12 col-xs-12">{{ __('front.Reset Password') }}</div>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('front.E-Mail Address') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <i style="color:red">{{ $message }}</i>
                    @enderror
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0px">
                            <button type="submit" class="btn btn-login" id="btn-login" style=""> {{ __('front.Send Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
                <!-- react-empty: 64 -->
            </div>
        </div>
    </div>
</div>
@endsection
