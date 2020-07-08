<div class="col-md-2 hidden-xs" id="halink-left" style="padding-left: 5px;padding-right: 5px;">
    <div class="list_item_panel">
        <ul>
            <li class="{{isset($product->category_id)?'':(!isset($categorys)?'active':'')}}">
                <a href="{{route("home")}}">
                    @if(isset($categorys))
                        <i class="fa fa-folder-open"></i>
                        {{ __('front.All') }}</a>
                    @else
                        <i class="fa fa-folder-open"></i>
                        {{ __('front.All') }}</a>
                    @endif

            </li>
            @foreach($categories as $category)
                <li class="{{ isset($product->category_id)?($product->category_id==$category->id?'active':''):(isset($categorys)?(($categorys->id==$category->id)?'active':''):'') }}">
                    <a style="padding-left: 5px" href="{{ route('search_category',['id'=>$category->id]) }}">
                        <img class="icon_img" src="{{ URL::asset($category->icon) }}"
                             onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                        {{ $category->lang_category ? $category->lang_category : $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <style>
        option{
            text-align: right   ;
        }
        .div100 {
            width: 100%;

        }
        .title{
            font-weight: bold;
            background:antiquewhite;
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 2px 5px;
            border-radius: 5px;
        }

        .div50 {
            width: 50%;
            float: left;
        }

        .div50 select {
            width: 100%;
        }
        .div100 select, button {
            width: 100%;
        }

        .no-padding {
            padding: 0px !important;
        }


    </style>

    @if(isset($isMethodPostSearch) && $isMethodPostSearch)
        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="@if(isset($search_from) && $search_from == 'advanced_search'){{ route('select_search', ['type' => $type_search, 'cate_id' => $cate_id, 'location_id' => $location_id, 'route_master_id' => $route_master_id]) }} @else {{ route('search') }} @endif">
        @csrf
        <div style="">
            <div style="background-color: #ed1c24; width: 100%; color: white; padding: 7px;">
                <strong><i class="fa fa-filter"></i> {{ __('front.絞り込み条件を指定') }}</strong>
            </div>

            <div class="div100 title">
                {{ __('front.価格') }}
            </div>
            <div class="col-md-12 no-padding">
                <div class="col-md-5 no-padding">
                    <select class="form-control" name="filter_min_price" id="filter_min_price">
                        <option value="0">{{ __('front.下限なし') }}</option>
                        @foreach(Config::get('settings.FILTER_PRICE') as $val_key => $val)
                        <option @if(isset($request->filter_min_price) && $request->filter_min_price == $val_key) selected="selected" @endif  value="{{ $val_key }}">{{ $val }} {{ __('front.万円') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    ～
                </div>
                <div class="col-md-5 no-padding">
                    <select class="form-control" name="filter_max_price" id="filter_max_price">
                        @foreach(Config::get('settings.FILTER_PRICE') as $val_key => $val)
                        <option @if(isset($request->filter_max_price) && $request->filter_max_price == $val_key) selected="selected" @endif value="{{ $val_key }}">{{ $val }} {{ __('front.万円') }}</option>
                        @endforeach
                        <option @if((isset($request->filter_max_price) && $request->filter_max_price == 9999999999999) || !isset($request->filter_max_price)) selected="selected" @endif value="9999999999999">{{ __('front.上限なし') }}</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>


            <div class="div100 title">
                {{ __('front.間取り') }}
            </div>
            <div class="div100">
                @foreach($listGroupFloorPlan as $fpm)
                <label class="radio-inline">
                    <input type="checkbox"  name="filter_floor_plan[]" @if(isset($request->filter_floor_plan) && in_array($fpm->list_id, $request->filter_floor_plan)) checked="checked" @endif value="{{ $fpm->list_id }}"> {{ str_replace(',', ' ', $fpm->titles) }}
                </label><br>
                @endforeach
            </div>
            <div class="clearfix"></div>

            <div class="div100 title">
                {{ __('front.面積') }}
            </div>
            <div class="div100">
                <select class="form-control" name="filter_area">
                    <option value="0">{{ __('front.指定なし') }}</option>
                    @foreach(Config::get('settings.FILTER_AREA') as $val_key => $val)
                    <option  @if(isset($request->filter_area) && $request->filter_area == $val_key) selected="selected" @endif value="{{ $val_key }}">{{ $val }}㎡{{ __('front.以上') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="clearfix"></div>
            @if((isset($type_search) && $type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME')) || isset($search_from) && $search_from == 'search')
            <div class="div100 title">
                {{ __('front.駅からの徒歩') }}
            </div>

            <div class="div100">
                <select class="form-control" name="filter_walk_from_station">
                    <option value="0" >{{ __('front.指定なし') }}</option>
                    @foreach(Config::get('settings.FILTER_WALK_FROM_STATION') as $val_key => $val)
                    <option  @if(isset($request->filter_walk_from_station) && $request->filter_walk_from_station == $val_key) selected="selected" @endif value="{{ $val_key }}">{{ $val }}{{ __('front.分以内') }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="clearfix"></div>

            <div class="div100 title">
                {{ __('front.築年数') }}
            </div>
            <div class="div100">
                <select class="form-control" name="filter_age">
                    <option value="0" >{{ __('front.指定なし') }}</option>
                    @foreach(Config::get('settings.FILTER_AGE') as $val_key => $val)
                    <option @if(isset($request->filter_age) && $request->filter_age == $val_key) selected="selected" @endif value="{{ $val_key }}">{{ $val }}{{ __('front.年以内') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="clearfix"></div>

            <div class="div100" style="padding-top: 15px">
                <input type="hidden" name="is_form_filter" value="true"> 
                <!-- from search -->
                <input type="hidden" name="key" value="{{ (isset($search) && $search['key']) ? $search['key'] : '' }}">
                <input type="hidden" name="location" value="{{ (isset($search) && $search['location']) ? $search['location'] : '' }}">
                <input type="hidden" name="category" value="{{ (isset($search) && $search['category']) ? $search['category'] : '' }}">

                <!-- from adv search -->
                <input type="hidden" name="inputCity" value="{{ isset($inputCity) ? $inputCity : null }}">
                <input type="hidden" name="inputRoute" value="{{ isset($inputRoute) ? $inputRoute : null }}">
                <input type="hidden" name="inputStation" value="{{ isset($inputStation) ? $inputStation : null }}">
                <button class="btn" type="submit">{{ __('front.上記内容で絞り込む') }}</button>
            </div>

        </div>
    </form>
    @endif
</div>
