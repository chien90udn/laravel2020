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
                <div class="form-title col-lg-12 col-md-12 col-xs-12">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend', ['id' => $user->id]) }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

