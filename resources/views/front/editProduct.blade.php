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


                    <div class="main-tit clear"><h2>{{ $product->title }}</h2></div>
                    <div style="padding: 10px">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12" style="font-weight: bold; color: red;">
                                </div>
                                @if (Session::has('success'))
                                    <div style="color: green">{{ Session::get('success') }}</div>
                                @endif
                                <div class="col-md-12">
                                    <div class="box box-info">
                                        <div class="box-body">
                                            <form method="post" method="POST" action="{{ route('postEditProduct',['id'=>$product->id]) }}" id="myform" name="laivt_frm_ajax_search"
                                                  class="form-horizontal" action="" enctype="multipart/form-data">
                                                    @csrf
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item active">
                                                        <a class="nav-link " id="home-tab" data-toggle="tab"
                                                           href="#home" role="tab" aria-controls="home"
                                                           aria-selected="true">{{ __('front.Default') }}</a>
                                                    </li>
                                                    @foreach($languages as $language)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="profile-tab" data-toggle="tab"
                                                               href="#{{ $language->short_name }}"
                                                               role="tab" aria-controls="profile"
                                                               aria-selected="false">{{ $language->lang_language ? $language->lang_language : $language->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul><br>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane active" id="home" role="tabpanel"
                                                         aria-labelledby="home-tab">

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Title') }}</label>
                                                            <div class="col-sm-9">
                                                                <input style="{{ $errors->has('title')?'border-color:red':'' }}"
                                                                       type="text"
                                                                       name="title"
                                                                       value="{{ $errors->all()?old('title'):$product->title }}"
                                                                       class="form-control">
                                                                <div class="dk-a">
                                                                    @if($errors->has('title'))
                                                                        {{$errors->first('title')}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Prefectures') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <select id="location" name="location" class="input form-control" style="{{ $errors->has('location')?'border-color: red':'' }} ">
                                                                            @foreach($locations as $location)
                                                                                <option
                                                                                    value="{{$location->id}}" {{ $errors->all()?((old('location')== $location->id)?'selected':''):(($location->id==$product->location_id)?'selected':'') }}>
                                                                                    {{ $location->lang_location ? $location->lang_location : $location->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="dk-a location_err">
                                                                            @if($errors->has('location'))
                                                                                {{$errors->first('location')}}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.City') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <select class="form-control" id="city" name="city">
                                                                            @foreach($city as $ct)
                                                                                    @if($ct->location_id == $product->location_id)
                                                                                        <option value="{{ $ct->id }}" {{ $ct->id == $product->city_master_id ? 'selected' : '' }}>
                                                                                            {{ $ct->title }}
                                                                                        </option>
                                                                                    @endif
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="dk-a city_err">
                                                                            @if($errors->has('city'))
                                                                                {{$errors->first('city')}}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Address') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <input style="{{ $errors->has('address')?'border-color: red':'' }}" value="{{ $errors->all()?old('address'):$product -> address }}" type="text" id="address_err" name="address" class="form-control">
                                                                        <div class="dk-a address_err">
                                                                            @if($errors->has('address'))
                                                                                {{$errors->first('address')}}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">{{ __('front.Floor') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row" style="padding: 0px 15px">
                                                                    <select style="{{ $errors->has('floor')?'border-color: red':'' }}" class="selectFloor form-control" multiple="multiple" name="floor[]">
                                                                        @foreach($floor as $gr_id)
                                                                            <option value="{{ $gr_id['id'] }}"
                                                                            @foreach($getArrayFloor as $key => $value)
                                                                                {{ $gr_id['id'] == $value ? 'selected':'' }}
                                                                            @endforeach
                                                                            >
                                                                                {{ $gr_id['title'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="dk-a address_err">
                                                                        @if($errors->has('floor'))
                                                                            {{$errors->first('floor')}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <style>
                                                            .ms-choice{
                                                                border: none;
                                                            }
                                                            .ms-drop {
                                                                margin-left: -12px;
                                                            }
                                                            .ms-choice>span {
                                                                margin-top: 4px;
                                                            }
                                                        </style>

                                                        <div id="distance">
                                                            <div class="form-group">
                                                                <div class="col-sm-12" >
                                                                    <div class="row">
                                                                        <div class="col-sm-3"><strong>{{ __("front.Route") }}</strong></div>
                                                                        <div class="col-md-4"><strong>{{ __("front.Station") }}</strong></div>
                                                                        <div class="col-md-4"><strong>{{ __("front.Walking from the station (unit: minutes)") }}</strong></div>
                                                                        <div class="col-md-1">
                                                                            <label class="btn btn-primary add-distance-unable" id="add-distance" data-id="0"><i class="fa fa-plus-square"></i></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @foreach($productTemp as $proTemp)
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <select class="form-control route_{{ $proTemp -> id }}" name="route" id="route">
                                                                                    @foreach($route as $rt)
                                                                                        @if($rt -> location_id  == $proTemp -> location_id)
                                                                                            <option value="{{ $rt -> id }}" {{ $rt -> id == $proTemp -> route_master_id ? 'selected':'' }}>{{ $rt->title }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <select class="form-control station_{{ $proTemp -> id }}" id="station" name="station">
                                                                                    @foreach($station as $st)
                                                                                        @if($st -> route_master_id  == $proTemp -> route_master_id)
                                                                                            <option value="{{ $st->id }}" {{ $st->id == $proTemp -> station_name_id ? 'selected' : '' }}>{{ $st->title }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <input class="form-control time_walking_{{ $proTemp -> id }}" value="{{ $proTemp -> distance }}" min="0" type="number" name="time_walking" id="time_walking">
                                                                            </div>
                                                                            <div class="col-md-1"><label class="btn btn-primary save_distance" data-id="{{ $proTemp -> id }}"><i class="fa fa-save"></i></label>
                                                                            </div>


                                                                        <div class="col-md-1"><label class="btn btn-danger delete_distance" data-id="{{ $proTemp -> id }}"><i class="fa fa-minus-square"></i></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Area used') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <input
                                                                            style="{{ $errors->has('area_used')?'border-color: red':'' }}"
                                                                            value="{{ $errors->all()?old('area_used'):$product->area_used }}"
                                                                            type="text" id="area_used_err"
                                                                            name="area_used" class="form-control">
                                                                        <div class="dk-a area_used_err">
                                                                            @if($errors->has('area_used'))
                                                                                {{$errors->first('area_used')}}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">{{ __('front.Completion time') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <select class="form-control" name="month">
                                                                                @foreach(Config::get('settings.MONTH') as $key => $val)
                                                                                    <option value="{{ $key }}" {{ $errors->all()?($key==old('month')?'selected':''):($key==date_format(date_create($product->complete_time),'m')?'selected':'') }}>{{ $val }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="input-group-addon">{{ __('front.Month') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <select class="form-control" name="year">
                                                                                @for($i = date('Y')-15; $i <= date('Y') +15; $i++)
                                                                                    <option value="{{ $i }}" {{ $errors->all()?($i==old('year')?'selected':''):($i==date_format(date_create($product->complete_time),'Y')?'selected':'') }}>{{ $i }}</option>
                                                                                @endfor
                                                                            </select>
                                                                            <span class="input-group-addon">{{ __('front.Year') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Price') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <select name="currency"
                                                                                class="input form-control">
                                                                            @foreach($currencies as $currency)
                                                                                <option value="{{$currency->id}}"
                                                                                    {{ $errors->all()?(old("currency")==$product->currency_id?'selected':''):($currency->id==$product->currency_id?'selected':'') }}
                                                                                >{{ $currency->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                        <input
                                                                            style="{{$errors->has('price')?'border-color:red':''}}"
                                                                            type="text"
                                                                            name="price"
                                                                            value="{{ $errors->all()?old('price'):$product->price }}"
                                                                            class="form-control">
                                                                        <div class="dk-a">
                                                                            @if($errors->has('price'))
                                                                                {{$errors->first('price')}}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Category') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <select name="category"
                                                                                class="input form-control">
                                                                            @foreach($categories as $category)
                                                                                <option
                                                                                    value="{{$category->id}}" {{ $errors->all()?((old('category') == $product->category_id)?'selected':''):(($category->id == $product->category_id)?'selected':'') }}>
                                                                                    {{ $category->lang_category ? $category->lang_category : $category->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Description') }}</label>
                                                            <div class="col-sm-9">
                                                         <textarea
                                                             style="{{$errors->has('description')?'border-color:red':''}}"
                                                             class="form-control"
                                                             name="description">{{ $errors->all()?old('description'):$product->description }}</textarea>
                                                                <div class="dk-a">
                                                                    @if($errors->has('description'))
                                                                        {{$errors->first('description')}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Content') }}</label>
                                                            <div class="col-sm-9">
                                                        <textarea
                                                            style="{{$errors->has('content')?'border-color:red':''}}"
                                                            id="text" class="input editor" rows="8"
                                                            name="content">
                                                                {{ $errors->all()?old('content'):$product->content }}
                                                        </textarea>
                                                                <div class="dk-a">
                                                                    @if($errors->has('content'))
                                                                        {{$errors->first('content')}}
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">{{ __('front.Picture') }}</label>
                                                            <div class="col-sm-9">
                                                                <div class="dk-f">
                                                                    <input id="img_source" type="file" class="form-control"
                                                                           name="images[]" multiple >
                                                                    <input id="product_id" type="hidden" value="{{ $product->id }}">
                                                                    {{--                                                            <label id="add_img" class="btn btn-danger"><i class="fa fa-plus"></i> Add picture</label>--}}
                                                                    <div class="product-img" id="placehere">
                                                                        @foreach($product_img as $pro_img)
                                                                            <div class="img_area" id="{{ $pro_img->id }}">
                                                                                <img src="{{ URL::asset($pro_img->path) }}" alt="Lights" class="img-product">                                                                       <div class="caption">
                                                                                    <span data-id="{{ $pro_img->id }}" class="deleteImg">Delete</span>                                                                     </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                                <div class="dk-a">
                                                                    @if($errors->has('images.*'))
                                                                        {{$errors->first('images.*','Files must be photos up to 2MB in size')}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="col-sm-3 control-label">{{ __('front.Sold') }}</label>
                                                            <div class="col-sm-9">
                                                                <input type="checkbox" name="sold" value="1" {{ $product->sold == Config::get('settings.SOLD')?'checked':'' }}>
                                                                <div class="dk-a">
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    @foreach($languages as $language)
                                                        <div class="tab-pane fade" id="{{ $language->short_name }}"
                                                             role="tabpanel"
                                                             aria-labelledby="profile-tab">
                                                            <div class="form-group">
                                                                <label
                                                                    class="col-sm-3 control-label">{{ __('front.Title') }}</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                           id="title"
                                                                           name="title_{{ $language->short_name }}"
                                                                           value="@foreach($translations as $translation){{ $translation->lang_code == $language->short_name && $translation->lang_type_detail == Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE')?$translation->lang_content:'' }}@endforeach"
                                                                           class="form-control">
                                                                    <div class="dk-a">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="col-sm-3 control-label">{{ __('front.Description') }}</label>
                                                                <div class="col-sm-9">
                                                         <textarea class="form-control"
                                                                   id="description"
                                                                   name="description_{{ $language->short_name }}">@foreach($translations as $translation){{ $translation->lang_code == $language->short_name && $translation->lang_type_detail == Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION')?$translation->lang_content:'' }}@endforeach</textarea>
                                                                    <div class="dk-a">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="col-sm-3 control-label">{{ __('front.Content') }}</label>
                                                                <div class="col-sm-9">
                                                                <textarea id="lang{{ $language->short_name }}"
                                                                          class="input editor"
                                                                          rows="8"
                                                                          name="content_{{ $language->short_name }}">@foreach($translations as $translation){{ $translation->lang_code == $language->short_name && $translation->lang_type_detail == Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT')?$translation->lang_content:'' }}@endforeach</textarea>
                                                                    <div class="dk-a">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>


{{--                                                Submit button--}}
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        </label>
                                                    <div class="col-sm-9">
                                                        <input type="submit" value="{{ __('front.Update') }}" name="btn_OK" class="btn btn-info">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection

@section('scripts')
    <script src={{ URL::asset('ckeditor/ckeditor.js') }}></script>
    <script>
        $(document).ready(function () {

            $("#location").change(function () {
                var location_id = $(this).val();
                if(location_id == ''){
                    $("#route").prop( "disabled", true );
                    $("#route").html( '<option value="">{{ __('front.Please choose a prefectures') }}</option>' );
                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('getRegion') }}",
                        method: "POST",
                        data: {location_id: location_id},
                        success: function (data) {
                            var city_option ='<option value="">{{ __('front.Please choose...') }}</option>';
                            var route_option ='<option value="">{{ __('front.Please choose...') }}</option>';
                            $.each( data, function( key, value ) {
                                if(key == 'city_arr'){
                                    $.each(value, function (id,title) {
                                        city_option +='<option value="'+title['id']+'">'+title['title']+'</option>';
                                    });
                                }else{
                                    $.each(value, function (id,title) {
                                        route_option +='<option value="'+title['id']+'">'+title['title']+'</option>';
                                    });
                                }

                            });

                            $("#city").prop( "disabled", false );
                            $("#route").prop( "disabled", false );



                            $("#station").prop( "disabled", true );
                            $("#station").html('<option value="">{{ __('front.Please choose a route') }}</option>');


                            $("#time_walking").prop( "disabled", true );
                            $("#time_walking").val("");

                            $("#city").html(city_option);
                            $("#route").html(route_option);
                        }
                    });
                }

            });

            $("#location").change(function () {
                if($("#location").val() != ""){
                    $(".add-distance-disable").hide();
                    $(".add-distance-unable").show();
                }else{
                    $(".add-distance-disable").show();
                    $(".add-distance-unable").hide();
                }
            })


            $("#add-distance").click(function () {
                var random = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for (var i = 0; i < length; i++)
                    random += possible.charAt(Math.floor(Math.random() * possible.length));
                var location_id = $("#location").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('getRegion') }}",
                    method: "POST",
                    data: {location_id: location_id},
                    success: function (data) {
                        var route_option = '<option>{{ __('front.Please choose...') }}</option>';
                        $.each(data, function (key, value) {
                            if (key == 'route_arr') {
                                $.each(value, function (id, title) {
                                    route_option += '<option value="' + title['id'] + '">' + title['title'] + '</option>';
                                });
                            }
                        });
                        $("#distance").append('<form id="form_' + random + '"><div id="addDis"><div class="form-group ' + random + '"> ' +
                            '<div class="col-sm-12" > ' +
                            '<div class="row"><input type="hidden" value="'+ {{ $product->id }} +'" name="getProduct_id"> <input type="hidden" value="'+ location_id +'" name="getLocation_id">' +
                            '<div class="col-md-3"><select name="route" id="route" class="form-control route" data-id="' + random + '">' + route_option + '</select></div>' +
                            '<div class="col-md-4"><select name="station" class="form-control ' + random + '" id="' + random + '" disabled><option>{{ __('front.Please choose a route') }}</option></select></div> ' +
                            '<div class="col-md-3"><input name="time_walking" id="time_walking_'+ random +'" class="form-control ' + random + '" type="number" min="0" required id="time_walking" disabled></div> ' +
                            '<div class="col-md-1"> <label class="btn btn-primary save-distance" data-id="' + random + '"><i class="fa fa-save"></i></label> </div>' +
                            '<div class="col-md-1"> <label class="btn btn-danger del-distance" data-id="' + random + '"><i class="fa fa-minus-square"></i></label> </div> </div> </div> </div></div></form>');
                        $("#location").change(function () {
                            $("#addDis").remove();
                        })

                        $(".save-distance").click(function () {
                            var id_form="form_"+$(this).data('id');
                            var form_res=$("#"+id_form).serialize()
                            // console.log(form_res);
                            if($("#time_walking_" + random).val()==''){
                                $("#time_walking_" + random).css('border-color','red');
                            }else{
                                $.ajax({
                                    url: "{{ route('postAddProductTemp') }}",
                                    method: "POST",
                                    data: form_res,
                                    success: function (data) {
                                        location.reload();
                                    }
                                })
                            }

                        })

                        deleteDistance();

                        $(".route").change(function () {
                            var key = $(this).data('id');
                            var route_id = $(this).val();
                            $.ajax({
                                url: "{{ route('getStation') }}",
                                method: "POST",
                                data: {route_id: route_id},
                                success: function (data) {
                                    var station_option = '';
                                    $.each(data, function (key, value) {
                                        station_option += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                                    });
                                    $("#" + key).html(station_option);
                                    $("." + key).removeAttr('disabled');
                                }
                            });

                        });
                    }
                });

            });
            deleteDistance();

            function deleteDistance() {
                $(".del-distance").click(function () {
                    var random = $(this).data('id');
                    // alert(random)
                    $("." + random + "").remove();
                })
            }

            $("#region").change(function () {

                var region_id = $(this).val();
                if(region_id == ""){
                    $("#city").prop( "disabled", true );
                    $("#city").html('<option value="">{{ __('front.Please choose a region') }}</option>');
                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('getCity') }}",
                        method: "POST",
                        data: {region_id: region_id},
                        success: function (data) {
                            var city_option = '';
                            $.each(data, function (key, value) {
                                city_option += '<option value="' + value['id'] + '">' + value['title'] + '</option>';
                            });
                            $("#city").prop("disabled", false);
                            $("#city").html(city_option);
                            $(".city_err").html("");
                            $("#city").removeAttr('style');
                        }
                    });
                }

            });
            $("#route").change(function () {

                var route_id = $(this).val();
                if(route_id == ''){
                    $("#time_walking").prop( "disabled", true );
                    $("#station").prop( "disabled", true );
                    $("#station").html('<option value="">{{ __('front.Please choose a route') }}</option>');

                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('getStation') }}",
                        method: "POST",
                        data: {route_id: route_id},
                        success: function (data) {
                            var station_option ='';
                            $.each( data, function( key, value ) {
                                station_option +='<option value="'+value['id']+'">'+value['title']+'</option>';
                            });
                            $("#time_walking").prop( "disabled", false );
                            $("#station").prop( "disabled", false );
                            $("#station").html(station_option);
                        }
                    });
                }

            });

            $(".delete_distance").click(function () {
                var id = $(this).data('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if(confirm("Are you sure delete this item?") == true){
                    $.ajax({
                        url: "{{ route('postDeleteProductTemp') }}",
                        method: "POST",
                        data: {id:id},
                        success: function (data) {
                            location.reload();
                        }
                    })
                }
            })

            //update_distance
            $(".save_distance").click(function () {
                var id = $(this).data('id');
                var route = $(".route_" + $(this).data('id')).val();
                var station = $(".station_" + $(this).data('id')).val();
                var time_walking = $(".time_walking_" + $(this).data('id')).val();
                var id_form = {id:id, route:route, station:station, time_walking:time_walking};
                if(time_walking==''){
                    $(".time_walking_" + $(this).data('id')).css('border-color','red')
                }else{
                    $(".time_walking_" + $(this).data('id')).removeAttr('style')
                    $(this).html('<i class="fa fa-spinner fa-spin"></i>');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('postUpdateProductTemp') }}",
                        method: "POST",
                        data: id_form,
                        success: function (data) {
                            $(".save_distance").html('<i class="fa fa-save"></i>')
                        }
                    });
                }


            })
        });

        $(".editor").each(function () {
            let id = $(this).attr('id');
            CKEDITOR.replace(id, {
                filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',

            });
        });
    </script>
    @include('ckfinder::setup')
@endsection
