@extends('layouts.front')

@section('styles')
    {{--styles--}}
    <style>
    </style>
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuPC')
                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">

                    <div class="quangcao_top">
                    </div>

                    <div class="row" style="margin-right: -5px;margin-left: -5px;">
                        <div class="col-md-12" style="padding-left: 5px;padding-right: 5px;">
                            <div class="vip width_common box_category box_home">

                                <div class="title_boxhome width_common">

                                        <a href="{{ route('search_category',['id'=>$product->category['id']]) }}">
{{--                                            <img class="icon_img" src="{{ $product->category['icon'] }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">--}}
                                            <img class="icon_img" src="{{ URL::asset($category->icon) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                                            {{ $category->lang_category ? $category->lang_category : $category->name }}
                                         /</a>
                                        <a href="#" title="{{ $product->lang_title ? $product->lang_title : $product->title }}">
                                            {{ $product->lang_title ? $product->lang_title : $product->title }}
                                        </a>

                                    @if($product->sold == Config::get('settings.SOLD'))
                                        <span class="sold_detail">{{ __('front.Sold') }}</span>
                                    @endif

                                </div>

                                <div class="content_boxhome"  style="color: black">

                                    <div class="content">
                                        <div class="ctn_detail_box">
                                            <div class="images">
                                                <div id="bx-slider">
                                                    @if(count($images)==0)
                                                        <img src="{{ URL::asset('assets/front/images/no_image.png') }}" class="imgProd"
                                                             alt="{{ $product->lang_title ? $product->lang_title : $product->title }}">
                                                    @else
                                                        @foreach($images as $img)
                                                            <img src="{{ URL::asset($img->path) }}" class="imgProd"
                                                                 alt="{{ $product->lang_title ? $product->lang_title : $product->title }}"
                                                                 onerror="this.src='{{ URL::asset('assets/front/images/no_image.png') }}';">
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="info_tin">
                                                <h2 class="title_tin width_common">
                                                    {{ $product->lang_title ? $product->lang_title : $product->title }}
                                                </h2>
                                                <div class="dangngay width_common">
                                                    <p>
                                                        <i class="fa fa-location-arrow"></i>
                                                        <span>{{ $product->lang_location ? $product->lang_location : $product->locations['name'] }} - {{ $product->city['title'] }}</span>
                                                    </p>
                                                    <p>
                                                        <i class="fa fa-clock-o"></i> {{date_format($product->created_at,'H:i - d/m/Y')}}
                                                    </p>
                                                    <p class="price_tin" style="display: inline-block;float: none; width: 100%; text-align: left;">
                                                        {{ $product->currency['name'].number_format($product->price) }}@if(isset($exchangeRateBTC) && $product->price)（{{ __('front.Estimated Value​​​')}}: {{ number_format($exchangeRateBTC *  $product->price, 5, '.', '') }} BTC） @endif
                                                    </p>
                                                </div>
                                                <div class="dangngay width_common" style="border-bottom: solid 1px #999">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong>{{ __('front.Completion time') }}: </strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ date_format(date_create($product->complete_time),'Y-m') }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>{{ __('front.Area used') }}: </strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $product -> area_used }}
                                                        </div>

                                                        <div class="col-md-6">
                                                            <strong>{{ __('front.Floor') }}: </strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {!! $group_id_val !!}
                                                        </div>

                                                        <div class="col-md-6">
                                                            <strong>{{ __('front.Address') }}: </strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ $product -> address }}
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="dangngay width_common">
                                                    <table style="width: 100%;">
                                                        @foreach($productTemp as $proTemp)
                                                            <tr>
                                                                <td>{{ $proTemp->route['title'] }}</td>
                                                                <td><i class="fa fa-long-arrow-right"></i></td>
                                                                <td>{{ $proTemp->station['title'] }}:</td>
                                                                <td>{{ $proTemp->distance }} {{ __('front.minute') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>


{{--                                                <div class="box_lienhe width_common">--}}
{{--                                                    <span class="arrow_box_lh"></span>--}}
{{--                                                    <div class="tt_contact width_common">--}}
{{--                                                        <h3>Contact info</h3>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="person_tin width_common">--}}
{{--                                                        <i class="fa fa-user"></i>--}}
{{--                                                        <span id="user_fullname_99904">--}}
{{--                                                            <a id="author" href="#">--}}
{{--                                                                <strong>{{$user->name}}</strong>--}}
{{--                                                            </a>--}}
{{--                                                        </span>--}}
{{--                                                    </p>--}}
{{--                                                    <p class="phone_tin width_common">--}}
{{--                                                        <span id="user_phone">--}}
{{--                                                        <i class="fa fa-phone"></i>--}}
{{--                                                        {{$user->phone}}--}}
{{--                                                        </span>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="clear"></div>
                                            <div class="col-sm-8">
                                            </div>

                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                    <div id="col_610">
                                        <div id="main" class="penci-main-sticky-sidebar"
                                             style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                                            <div class="theiaStickySidebar"
                                                 style="padding-top: 0px; padding-bottom: 1px; position: static;">
                                                <article id="post-4124"
                                                         class="post type-post status-publish hentry">
                                                    <div class="post-entry blockquote-style-2">
                                                        <div class="inner-post-entry entry-content text-justify"
                                                             id="penci-post-entry-inner" >
                                                            <div style="padding: 11px 3px">
                                                            <div class="box_lienhe width_common">
                                                                {{ $product->lang_description ? $product->lang_description : $product->description }}
                                                            </div>
                                                            </div>
                                                            {!! $product->lang_content ? $product->lang_content : $product->content !!}

                                                            <div>
                                                                <p class="title_boxhome width_common"
                                                                   style="color: red">
                                                                    <i class="fa fa-pencil-square-o"></i>
                                                                    {{ __('front.Related products') }}
                                                                </p>
                                                                @foreach($products as $prod)
                                                                    <a href="{{ route('detail',['id'=>$prod->id]) }}">
                                                                        <strong>{{ $prod->lang_title ? $prod->lang_title : $prod->title }}</strong>
                                                                    </a>
                                                                    <hr style="margin-top: 0px">
                                                                @endforeach

                                                            </div>

                                                        </div>
                                                    </div>
                                                </article>

                                            </div>
                                        </div>

                                    </div>
                                    <div id="col_300">
                                        <div class="col_200">
                                            <ul>
                                            </ul>
                                        </div>
                                        <div class="left_blog">
                                            <h2><i class="fa fa fa-comments" aria-hidden="true"></i>{{ __('front.Contact') }}</h2>
                                            <div class="blog_list">
                                                @if($errors->has('sendSuccess'))
                                                    <div
                                                        class="alert-success">{{$errors->first('sendSuccess')}}</div>
                                                @endif
                                                @if(Auth::check())
                                                    @if($product->user_id==Auth::user()->id && $product->user_type == Config::get('settings.TYPE_ACCOUNT.USER'))
                                                        {{ __('front.It\'s your own product, you can\'t contact the publisher.') }}
                                                    @else
                                                        @if($message>0)
                                                            {{ __('front.You have sent contact for this product. Please check the message management.') }}
                                                            <a class="link-a" href="{{route('getMessages')}}">{{ __('front.Click here') }}</a>
                                                        @else
                                                            <form method="POST"
                                                                  action="{{route('send_contact',['id'=> $product->id])}}">
                                                                @csrf
                                                                <input type="hidden" name="id_to"
                                                                       value="{{$product->user_id}}">
                                                                <input type="hidden" name="user_type"
                                                                       value="{{$product->user_type}}">

                                                                <div class="form-group">
                                                                    <label>{{ __('front.Your name') }}</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="name"
                                                                           placeholder="Enter name"
                                                                           value="{{ $errors->has('name')?old('name'):Auth::user()->name }}">
                                                                </div>
                                                                @if($errors->has('name'))
                                                                    <i style="color:red">{{$errors->first('name')}}</i>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label>{{ __('front.Your e-mail address') }}</label>
                                                                    <input type="email"
                                                                           class="form-control"
                                                                           name="email"
                                                                           id="email"
                                                                           placeholder="Enter email"
                                                                           value="{{ $errors->has('email')?old('email'):Auth::user()->email }}">
                                                                </div>
                                                                @if($errors->has('email'))
                                                                    <i style="color:red">{{$errors->first('email')}}</i>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label>{{ __('front.Phone number') }}</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="phone"
                                                                           value="{{old('phone')}}"
                                                                           placeholder="{{ __('front.Enter phone number') }}">
                                                                </div>
                                                                @if($errors->has('phone'))
                                                                    <i style="color:red">{{$errors->first('phone')}}</i>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label>{{ __('front.Content') }}</label>
                                                                    <textarea class="form-control" rows="5"
                                                                              placeholder="{{ __('front.Enter content') }}"
                                                                              name="content"
                                                                    >{{old('content')}}</textarea>
                                                                </div>
                                                                @if($errors->has('content'))
                                                                    <i style="color:red">{{$errors->first('content')}}</i><br>
                                                                @endif
                                                                <button
                                                                    style="border-color: #ed1c24;background: #ed1c24 none repeat scroll 0 0; color: #fff;"
                                                                    class="btn btn-default" type="submit">{{ __('front.Send') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @else
                                                    {{ __('front.You must login or register a new account in order to contact the advertiser') }}
                                                    <p>
                                                        <a class="link-a" href="{{route('login')}}">{{ __('front.Login') }}</a> |
                                                        <a class="link-a" href="{{route('register')}}">{{ __('front.Register') }}</a>
                                                    </p>
                                                @endif


                                            </div>

                                        </div>
                                        <div class="col_200">


                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                </div>

                            </div>
                            <div class="clear"></div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
    </div>

@endsection
