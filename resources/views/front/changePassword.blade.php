@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuProfile')
                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                    <form action="{{route('changePassword')}}" method="post" class="w-tttk">
                        @csrf
                        <div class="main-tit"><h2>{{ __('front.Change password') }}</h2><span><label for="name" class="ten">{{ Auth::user()->name }}</label></span></div>
                        <div style="color:#F00;font-weight:bold;">
                        </div>
                        @if (Session::has('success'))
                            <div style="color: green">{{ Session::get('success') }}</div>
                        @endif
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.Current password') }}
                            </div>
                            <div class="dk-r">
                                <input type="password" name="current_pass" class="input" value="{{ old('current_pass') }}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('current_pass'))
                                    {{$errors->first('current_pass')}}
                                @endif
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.New password') }}
                            </div>
                            <div class="dk-r">
                                <input type="password" name="new_pass" class="input" value="{{ old('new_pass') }}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('new_pass'))
                                    {{$errors->first('new_pass')}}
                                @endif
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.Confirm new password') }}
                            </div>
                            <div class="dk-r">
                                <input type="password" name="renew_pass" class="input" value="{{ old('renew_pass') }}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('renew_pass'))
                                    {{$errors->first('renew_pass')}}
                                @endif
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l dn-vh">

                            </div>
                            <div class="dk-r">
                                <input type="submit" class="button" value="{{ __('front.Update') }}">
                                <input type="reset" class="button" value="{{ __('front.Reset') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection
