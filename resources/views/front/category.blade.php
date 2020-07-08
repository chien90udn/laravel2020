@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuPC')

                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                    <div class="row" style="margin-right: -5px;margin-left: -5px;">

                        <div class="col-md-8" style="padding-left: 5px;padding-right: 5px;">
                            <div class="vip width_common box_category box_home">
                                <div class="title_boxhome width_common">
                                    <a href="">
{{--                                        <img class="icon_img" src="{{ $categorys->icon }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">--}}
                                        <a href="{{ route('search_category',['id'=>$categorys->id]) }}">
                                            <img class="icon_img" src="{{ URL::asset($categorys->icon) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                                            {{ $categorys->lang_category ? $categorys->lang_category : $categorys->name }}
                                        </a>
                                    </a>
                                </div>
                                <div class="content_boxhome">
                                    @foreach($new_products as $product)
                                        <div class="row_box">
                                            <div class="thumb">
                                                <a href="{{route('detail',['id'=>$product->id])}}">
                                                    <img class="imgProdList" src="{{URL::asset($product->images['path'])}}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                                                </a>
                                            </div>
                                            <div class="info">
                                                <div class="round_titbox">
                                                    <div class="title_new">
                                                        @if($product -> sold == Config::get('settings.SOLD'))
                                                            <span class="sold">{{ __('front.Sold') }}</span>
                                                        @endif
                                                        <h3>
                                                            <a href="{{route('detail',['id'=>$product->id])}}">

                                                                @if($product->hot == 1)
                                                                    <img style="margin-top: -9px;" src="{{URL::asset('assets/front/images/hot.png')}}">
                                                                @endif
                                                                {{ $product->lang_title ? $product->lang_title : $product->title }}
                                                            </a>
                                                        </h3>
                                                        <div class="price">
                                                            <a href="{{route('detail',['id'=>$product->id])}}">{{$product->currency['name'].number_format($product->price)}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="lacation_gia">
                                                    <ul>
                                                        <li class="left local_sp">
                                                            <i class="fa fa-location-arrow"></i>
                                                            <a href="{{ route('detail',['id'=>$product->id]) }}">{{ $product->lang_location ? $product->lang_location : $product->locations['name'] }}</a>
                                                        </li>
                                                        <li class="right">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ date_format($product->created_at,'H:i d/m/Y') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div>{{ $new_products->links() }}</div>
                                    @include('front.commons.page')
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-md-4 " style="padding-left: 5px;padding-right: 5px;">

                        @include('front.commons.right')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
