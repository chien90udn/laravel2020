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
                    <form action="{{route('changeProfile')}}" method="post" class="w-tttk">
                        @csrf
                        <div class="main-tit"><h2>{{ __('front.Infomation') }}</h2><span><label for="name" class="ten">{{ Auth::user()->name }}</label></span></div>
                        <div style="color:#F00;font-weight:bold;">
                        </div>
                        @if (Session::has('success'))
                            <div style="color: green">{{ Session::get('success') }}</div>
                        @endif
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.Your name') }}
                            </div>
                            <div class="dk-r">
                                <input type="text" name="name" class="input" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('name'))
                                    {{$errors->first('name')}}
                                @endif
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.User type') }}:

                                <strong>
                                    @if(@unserialize(Auth::user()->user_type) == true)
                                        @foreach(unserialize(Auth::user()->user_type) as $key => $value)
                                            {{ nameUserType($value) }}
                                        @endforeach
                                    @endif
                                </strong>
                            </div>
                            <div class="dk-a">
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.Address') }}
                            </div>
                            <div class="dk-r">
                                <input type="text" name="address" class="input" value="{{Auth::user()->address}}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('address'))
                                    {{$errors->first('address')}}
                                @endif
                            </div>
                        </div>
                        <div class="w-clear">
                            <div class="dk-l">
                                {{ __('front.Phone') }}
                            </div>
                            <div class="dk-r">
                                <input type="text" name="phone" class="input" value="{{Auth::user()->phone}}">
                            </div>
                            <div class="dk-a">
                                @if($errors->has('phone'))
                                    {{$errors->first('phone')}}
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
