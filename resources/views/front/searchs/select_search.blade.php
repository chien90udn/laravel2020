@extends('layouts.front')
@section('styles')
@endsection
@section('content')
<style>
    .title-reg{
            background: red;
            color: white;
            padding-left: 10px;
        }

        #station_form{
            display: none;
        }
        #station_detail{
            display: none;
        }
    </style>
<div class="center" id="hlcenter" style="; border: none;">
    <div id="container" class="w-clear">
        <div class="row" style="margin-right: -5px;margin-left: -5px;">
            @include('front.element.menuPC')
            <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                <div class="row" style="margin-right: -5px;margin-left: -5px;">
                    <div class="col-md-8" style="padding-left: 5px;padding-right: 5px;">
                            <div>
                                @if(!$isMethodPostSearch)
                                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('select_search', ['type' => $type_search, 'cate_id' => $cate_id, 'location_id' => $location_id, 'route_master_id' => $route_master_id]) }}">
                                        @csrf
                                        @if($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_REGION'))
                                            @if(isset($listRegion))
                                                @foreach($listRegion as $region)
                                                    <div class="condition_search">
                                                        <div class="title-reg col-md-12 condition_parent">
                                                            <label class="pattern_checkbox_label"><input type="checkbox" name="region[]" value="{{ $region->id }}"> {{ $region->title }}</label>
                                                        </div>
                                                        <div class="condition_sub">
                                                            @if($region->cityMaster())
                                                                @foreach($region->cityMaster()->get() as $city)
                                                                <div style="padding: 5px" class="col-md-4">
                                                                    <label class="pattern_checkbox_label"><input @if(isset($sessionSearch['inputCity']) && in_array($city->id, $sessionSearch['inputCity'])) checked="checked" @endif type="checkbox" name="city[]" value="{{ $city->id }}"> {{ $city->title }}</label>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_ROUTE'))
                                            @if(isset($listOperatingCompany))
                                                @foreach($listOperatingCompany as $operatingCompany)
                                                    @if($operatingCompany->routeMaster() && $operatingCompany->routeMaster()->get()->count())
                                                        <div class="condition_search">
                                                            <div class="title-reg col-md-12 condition_parent">
                                                                <label class="pattern_checkbox_label"><input type="checkbox" name="operating_company[]" value="{{ $operatingCompany->id }}"> {{ $operatingCompany->title }}</label>
                                                            </div>
                                                            <div class="condition_sub">
                                                                @foreach($operatingCompany->routeMaster()->get() as $route)
                                                                    <div style="padding: 5px" class="col-md-4"><input  @if(isset($sessionSearch['inputRoute']) && in_array($route->id, $sessionSearch['inputRoute'])) checked="checked" @endif  name="route[]" value="{{ $route->id }}" type="checkbox"> <a href="{{ route('select_search', ['type' => Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME'), 'cate_id' => $cate_id, 'location_id' => $location_id, 'route_master_id' => $route->id]) }}">{{ $route->title }}</a></div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME'))
                                            @if(isset($listStation) && $infoRouteMaster)
                                                 <div class="condition_search">
                                                        <div class="title-reg col-md-12 condition_parent">
                                                            <label class="pattern_checkbox_label"><input type="checkbox" name="info_route_master" value="{{ $infoRouteMaster->id }}"> {{ $infoRouteMaster->title }}</label>
                                                        </div>
                                                        <div class="condition_sub">
                                                            @foreach($listStation as $station)

                                                                <div style="padding: 5px" class="col-md-4">
                                                                    <label class="pattern_checkbox_label"><input @if(isset($sessionSearch['inputStation']) && in_array($station->id, $sessionSearch['inputStation'])) checked="checked" @endif type="checkbox" name="station[]" value="{{ $station->id }}"> {{ $station->title }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                            @endif
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group col-md-6">
                                                @if($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME'))
                                                    <a href="{{ route('select_search', ['type' => Config::get('settings.TYPE_SEARCH.SEARCH_BY_ROUTE'), 'cate_id' => $cate_id, 'location_id' => $location_id]) }}" class="btn back">{{ __('front.Back') }}</a>
                                                @else
                                                    <a href="{{ route('advancedSearch') }}" class="btn back">{{ __('front.Back') }}</a>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button class="btn" type="submit">{{ __('front.検索結果を見る') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="content_boxhome">
{{--                                        @if(isset($resultSearch) && $resultSearch->total())--}}
                                        @if(isset($resultSearch))
                                            @foreach($resultSearch as $product)
                                                <div class="row_box">
                                                    <div class="thumb">
                                                        <a href="{{route('detail',['id'=>$product->product_id])}}">
                                                            <img class="imgProdList"
                                                                 src="{{URL::asset($product->images['path'])}}"
                                                                 onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <div class="round_titbox">
                                                            <div class="title_new">
                                                                @if($product -> sold == Config::get('settings.SOLD'))
                                                                    <span class="sold3">{{ __('front.Sold') }}</span>
                                                                @endif
                                                                <h3>
                                                                    <a href="{{route('detail',['id'=>$product->product_id])}}">
                                                                        <!-- Ống mềm Sprinkler nối đầu phun chữa cháy - ống mềm PCCC dài 1000mm -->
                                                                        @if($product->hot == 1)
                                                                            <img style="margin-top: -9px;"
                                                                                 src="{{URL::asset('assets/front/images/hot.png')}}">
                                                                        @endif
                                                                                {{ str_limit($product->lang_title ? $product->lang_title : $product->title) }}
                                                                    </a>
                                                                </h3>
                                                                <div class="price">
                                                                    <a href="{{route('detail',['id'=>$product->product_id])}}">{{$product->currency['name'].number_format($product->price)}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lacation_gia">
                                                            <ul>
                                                                <li class="left local_sp">
                                                                    <i class="fa fa-location-arrow"></i>
                                                                    <a href="{{ route('detail',['id'=>$product->product_id]) }}">{{ $product->lang_location ? $product->lang_location : $product->locations['name'] }}</a>
        {{--                                                            <a href="{{ route('detail',['id'=>$product->product_id]) }}">{{ $product->locations['name'] }}</a>--}}
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
                                        @else
                                            <div>
                                                <p>お探しの不動産が見つかりませんでした。</p>
                                                <a href="{{ route('select_search', ['type' => $type_search, 'cate_id' => $cate_id, 'location_id' => $location_id, '' => ($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME')) ? $route_master_id : null]) }}" class="btn back">{{ __('front.Back') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
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
<script type="text/javascript">
    function handleCLickConditionSearch() {
        $('.condition_search .condition_parent input').change(function() {
            if ($(this).is(':checked')) {
                $(this).parent().parent().parent().find('.condition_sub input').attr('checked', true);
            } else {
                $(this).parent().parent().parent().find('.condition_sub input').attr('checked', false);
            }
        });
        $('.condition_search .condition_sub input').change(function() {
            if ($(this).parent().parent().parent().find('input').length == $(this).parent().parent().parent().find('input:checked').length) {
                $(this).parent().parent().parent().parent().find('.condition_parent input').attr('checked', true);
            } else {
                $(this).parent().parent().parent().parent().find('.condition_parent input').attr('checked', false);
            }
        });
    }

    function handleSetCheckedConditionSearch() {
        $('.condition_search .condition_sub').each(function() {
            if ($(this).find('input').length == $(this).find('input:checked').length) {
                $(this).parent().find('.condition_parent input').attr('checked', true);
            } else {
                $(this).parent().find('.condition_parent input').attr('checked', false);
            }
        });
    }

    function handleCLickFilterPrice() {
        $('#filter_min_price').change(function() {
            if (parseInt($('#filter_min_price').val()) > parseInt($('#filter_max_price').val())) {
                $('#filter_max_price > option').each(function() {
                    if (parseInt($('#filter_min_price').val()) <= parseInt($(this).val())) {
                        $('#filter_max_price').val(parseInt($(this).val()));
                        return false;
                    }
                });
            }
        });
        $('#filter_max_price').change(function() {
            if (parseInt($('#filter_min_price').val()) > parseInt($('#filter_max_price').val())) {
                $('#filter_min_price').val(parseInt($('#filter_max_price').val()));
            }
        });
    }
    $(document).ready(function() {
        handleCLickConditionSearch();
        handleSetCheckedConditionSearch();
        handleCLickFilterPrice();
    })
</script>

@endsection
