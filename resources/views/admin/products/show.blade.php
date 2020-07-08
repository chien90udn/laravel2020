@extends('layouts.admin')
@section('breadcrumb', __('admin.product.detail'))
@section('content')
    <div class="col-md-12">

        <div class="alert alert-success" id="MessageUpdate"></div>
        <div class="col-sm-12"><a href="{{ route('admin.products.index') }}"><button class="btn btn-primary"><< Back</button></a> <br><br></div>
        <div class="col-sm-4" id="bx-slider">
            <img class="imgProd" src="{{ URL::asset($product->images['path']) }}"
                 onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
            <div class="image_area">
                @foreach($images as $img)
                    <div class="img_control">
                        <img class="img" src="{{ URL::asset($img->path) }}"
                             onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-8">
            <span style="font-size: 24px; font-weight: bold">
                {{ $product->title }}
                @if($product -> sold == Config::get('settings.SOLD'))
                    <span class="sold">{{ __('admin.product.Sold') }}</span>
                @endif
            </span>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon text-red">{{ __('admin.product.status') }}</span>
                            <input id="productId" type="hidden" value="{{ $product->id }}">
                            <select id="approve" class="form-control">
                                <option
                                    {{ $product->approve== Config::get('settings.GLOBAL_APPROVE.DISABLED.code')?'selected':''}}
                                    value="{{ Config::get('settings.GLOBAL_APPROVE.DISABLED.code') }}">{{ __('admin.disabled') }}
                                </option>
                                <option
                                    {{ $product->approve== Config::get('settings.GLOBAL_APPROVE.ENABLED.code')?'selected':''}}
                                    value="{{ Config::get('settings.GLOBAL_APPROVE.ENABLED.code') }}">{{ __('admin.enabled') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon text-red">{{ __('admin.product.hot') }}</span>
                            <select id="hot" class="form-control">
                                <option
                                    {{ $product->hot== Config::get('settings.HOT_PRODUCT.NORMAL.code')?'selected':''}}
                                    value="{{ Config::get('settings.HOT_PRODUCT.NORMAL.code') }}">{{ Config::get('settings.HOT_PRODUCT.NORMAL.name') }}
                                </option>
                                <option
                                    {{ $product->hot== Config::get('settings.HOT_PRODUCT.HOT.code')?'selected':''}}
                                    value="{{ Config::get('settings.HOT_PRODUCT.HOT.code') }}">{{ Config::get('settings.HOT_PRODUCT.HOT.name') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if($product->user_type==Config::get('settings.TYPE_ACCOUNT.ADMIN'))
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-primary"><i class="fa fa-edit"></i> {{ __('admin.product.edit') }}</a>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="btn btn-danger">
                            {{ $product->currency['name'].number_format($product->price) }}@if(isset($exchangeRateBTC) && $product->price)（{{ __('admin.product.Estimated Value')}}: {{ number_format($exchangeRateBTC *  $product->price, 5, '.', '') }} BTC） @endif
                        </label>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-3">
                        <i class="fa fa-user"></i>
                        @if($product->user_type==Config::get('settings.TYPE_ACCOUNT.ADMIN'))
                            {{ $product->admin['name'] }}
                        @else
                            {{ $product->user['name'] }}
                        @endif
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-calendar"></i> {{ date_format($product->created_at, 'H:i - d/m/Y') }}
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-location-arrow"></i> {{ $product->locations['name'] ." - ". $product->city['title'] }}
                    </div>
                    <div id="Ar_fields" class="col-sm-3">
                        <div id="DefaulAr">
                            <i class="fa fa-check-square-o"></i> {{ nameApprove($product->approve) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <hr>
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
                    <div class="col-md-6">
                        <hr>
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
                </div>
            </div>

        </div>
        <div class="col-sm-12 text-justify">
            <h4 class="description_prod">
                {{ $product->description }}
            </h4>
            <h4>
                {!! $product->content !!}
            </h4>
        </div>
    </div>
    <script src={{ URL::asset('ckeditor/ckeditor.js') }}></script>
    <script>
        CKEDITOR.replace('text', {
            filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',

        });

    </script>
    @include('ckfinder::setup')
@endsection


