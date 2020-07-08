@extends('layouts.admin')
@section('breadcrumb', __('admin.product.create'))
@section('content')
    <div class="col-md-12">
        <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                       aria-selected="true">Default</a>
                </li>
                @foreach($languages as $language)
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#{{ $language->short_name }}"
                           role="tab" aria-controls="profile" aria-selected="false">{{ $language->name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="form-group">
                        <label>{{ __('front.Title') }}</label>
                        <input id="title_err"
                               style="{{ $errors->has('title')?'border-color: red':'' }} "
                               type="text"
                               name="title"
                               value="{{ isset($request['title'])?$request['title']:'' }}"
                               class="form-control">
                        <small class="form-text text-muted text-red">
                            @if($errors->has('title'))
                                {{$errors->first('title')}}
                            @endif
                        </small>

                    </div>
                    <div class="form-group">
                        <label>{{ __('front.Prefectures') }}</label>
                        <select id="location" name="location" class="input form-control" style="{{ $errors->has('location')?'border-color: red':'' }} ">
                            <option value="">{{ __('front.Please choose...') }}</option>
                            @foreach($locations as $location)
                                <option value="{{$location->id}}" {{ isset($request['location'])?($request['location']==$location->id?'Selected':''):'' }}>
                                    {{ $location->lang_location ? $location->lang_location : $location->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted text-red">
                            @if($errors->has('location'))
                                {{$errors->first('location')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.City') }}</label>
                        @if(isset($request['location']))
                            @if(isset($request['city']))
                                <select class="form-control" id="city" name="city">
                                    @foreach($city as $ct)
                                        <option value="{{ $ct->id }}" {{ $ct->id == $request['city'] ? 'selected' : '' }}>{{ $ct->title }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select style="{{ $errors->has('city')?'border-color: red':'' }}" class="form-control" id="city" name="city">
                                    @foreach($city as $ct)
                                        <option value="{{ $ct->id }}">{{ $ct->title }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @else
                            <select style="{{ $errors->has('city')?'border-color: red':'' }}" class="form-control" id="city" name="city" disabled>
                                <option>{{ __('front.Please choose a prefectures') }}</option>
                            </select>
                        @endif
                        <small class="form-text text-muted text-red">
                            @if($errors->has('city'))
                                {{$errors->first('city')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.Address') }}</label>
                        <input style="{{ $errors->has('address')?'border-color: red':'' }}" value="{{ isset($request['address'])?$request['address']:'' }}" type="text" id="address_err" name="address" class="form-control">
                        <small class="form-text text-muted text-red">
                            @if($errors->has('address'))
                                {{$errors->first('address')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.Floor') }}</label>
                        <select style="{{ $errors->has('floor')?'border-color: red':'' }}" class="selectFloor form-control" multiple="multiple" name="floor[]">
                            @foreach($floor as $gr_id)
                                <option value="{{ $gr_id['id'] }}"
                                    @php
                                        if(isset($request['floor'])){
                                            foreach ($request['floor'] as $key => $value){
                                                if($gr_id['id'] == $value){
                                                echo "Selected";
                                                }
                                            }
                                        }
                                    @endphp
                                >
                                    {{ $gr_id['title'] }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted text-red">
                        @if($errors->has('floor'))
                            {{$errors->first('floor')}}
                        @endif
                        </small>

                        <style>
                            .ms-choice {
                                border: none;
                            }

                            .ms-drop {
                                margin-left: -12px;
                            }

                            .ms-choice > span {
                                margin-top: 4px;
                            }

                            .floor {
                                border: solid 1px #999;
                                border-radius: 4px;
                                height: 120px;
                                overflow: auto;
                                padding-top: 5px;
                            }

                            .selected {
                                background: #6c757d;
                                color: white;
                            }
                        </style>
                    </div>


                    <div id="distance">
                        <div class="row">
                            <div class="col-sm-4"><strong>{{ __("front.Route") }}</strong></div>
                            <div class="col-md-4"><strong>{{ __("front.Station") }}</strong></div>
                            <div class="col-md-4">
                                <strong>{{ __("front.Walking from the station (unit: minutes)") }}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                @if(isset($request['location']))
                                    @if(isset($request['route']))
                                        <select class="form-control" name="route" id="route">
                                            @foreach($route as $rt)
                                                <option
                                                    value="{{ $rt->id }}" {{ $rt->id==$request['route']?'selected':'' }}>
                                                    {{ $rt->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select style="{{ $errors->has('route')?'border-color: red':'' }}" name="route"
                                                class="form-control" id="route">
                                            <option value="">{{ __('front.Please choose a prefectures') }}</option>
                                            @foreach($route as $rt)
                                                <option value="{{ $rt->id }}">{{ $rt->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                @else
                                    <select style="{{ $errors->has('route')?'border-color: red':'' }}" name="route"
                                            class="form-control" id="route" disabled>
                                        <option value="">{{ __('front.Please choose a prefectures') }}</option>
                                    </select>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if(isset($request['location']))
                                    @if(isset($request['route']))
                                        @if(isset($request['station']))
                                            <select class="form-control" id="station" name="station">
                                                @foreach($station as $st)
                                                    <option
                                                        value="{{ $st->id }}" {{ $st->id == $request['station'] ? 'selected' : '' }}>
                                                        {{ $st->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select style="{{ $errors->has('station')?'border-color: red':'' }}"
                                                    class="form-control" id="station" name="station">
                                                @foreach($station as $st)
                                                    <option
                                                        value="{{ $st->id }}" {{ $st->id == $request['station'] ? 'selected' : '' }}>
                                                        {{ $st->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @else
                                        <select style="{{ $errors->has('station')?'border-color: red':'' }}"
                                                class="form-control" id="station" name="station" disabled>
                                            <option value="">{{ __('front.Please choose a route') }}</option>
                                        </select>
                                    @endif
                                @else
                                    <select style="{{ $errors->has('station')?'border-color: red':'' }}"
                                            class="form-control" id="station" name="station" disabled>
                                        <option value="">{{ __('front.Please choose a route') }}</option>
                                    </select>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if(isset($request['station']))
                                    @if(isset($request['time_walking']))
                                        <input class="form-control" value="{{ $request['time_walking'] }}" min="0"
                                               type="number" name="time_walking" id="time_walking">
                                    @else
                                        <input style="{{ $errors->has('time_walking')?'border-color: red':'' }}"
                                               class="form-control" value="" min="0" type="number" name="time_walking"
                                               id="time_walking">
                                    @endif
                                @else
                                    <input style="{{ $errors->has('time_walking')?'border-color: red':'' }}"
                                           class="form-control"
                                           value="{{ isset($request['time_walking'])?$request['time_walking']:'' }}"
                                           min="0" type="number" name="time_walking" id="time_walking" disabled>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" >
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="form-text text-muted text-red">
                                            @if($errors->has('route'))
                                                {{$errors->first('route')}}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="form-text text-muted text-red">
                                            @if($errors->has('station'))
                                                {{$errors->first('station')}}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="form-text text-muted text-red">
                                            @if($errors->has('time_walking'))
                                                {{$errors->first('time_walking')}}
                                            @endif
                                        </small>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.Area used') }}</label>
                        <input style="{{ $errors->has('area_used')?'border-color: red':'' }}" value="{{ isset($request['area_used'])?$request['area_used']:'' }}" type="text" id="area_used_err" name="area_used" class="form-control">
                        <small class="form-text text-muted text-red">
                            @if($errors->has('area_used'))
                                {{$errors->first('area_used')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.Completion time') }}</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">

                                    <select class="form-control" name="month">
                                        @foreach(Config::get('settings.MONTH') as $key => $val)
                                            <option
                                                value="{{ $key }}" {{ isset($request['month'])?($key==$request['month']?'selected':''):($key==date('m')?'selected':'') }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon">{{ __('front.Month') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">

                                    <select class="form-control" name="year">
                                        @for($i = date('Y')-15; $i <= date('Y') +15; $i++)
                                            <option
                                                value="{{ $i }}" {{ isset($request['year'])?($i==$request['year']?'selected':''):($i==date('Y')?'selected':'') }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <span class="input-group-addon">{{ __('front.Year') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-4">
                        <label>{{ __('front.Price') }}</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <select name="currency"
                                        class="input form-control">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}"
                                            {{ isset($request['currency'])?($currency->id==$request['currency'])?'selected':'':'' }}
                                        >{{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <input
                                    style="{{ $errors->has('price')?'border-color: red':'' }}"
                                    type="text"
                                    name="price"
                                    id="price_err"
                                    value="{{ isset($request['price'])?$request['price']:'' }}"
                                    class="form-control">
                                <small class="form-text text-muted text-red">
                                    @if($errors->has('price'))
                                        {{$errors->first('price')}}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>



                    <div class="form-group mb-4">
                        <label>{{ __('front.Category') }}</label>
                        <select name="category"
                                class="input form-control">
                            @foreach($categories as $category)
                                <option
                                    value="{{$category->id}}" {{ isset($request['category'])?($category->id==$request['category'])?'selected':'':'' }}>
                                    {{ $category->lang_category ? $category->lang_category : $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.Description') }}</label>
                        <textarea
                            style="{{ $errors->has('description')?'border-color: red':'' }}"
                            id="description_err"
                            class="form-control"
                            name="description">{{ isset($request['description'])?$request['description']:'' }}</textarea>
                        <small class="form-text text-muted text-red">
                            @if($errors->has('description'))
                                {{$errors->first('description')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('admin.product.content') }}</label>
                        <textarea
                            id="content_err" class="editor form-control" rows="8"
                            name="content">
                            {{ isset($request['content'])?$request['content']:'' }}
                        </textarea>
                        <small class="form-text text-muted text-red">
                            @if($errors->has('content'))
                                {{$errors->first('content')}}
                            @endif
                        </small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.hot') }}</label>
                        <div class="radio">
                            <label><input type="radio" name="hot" checked
                                          value="{{ Config::get('settings.HOT_PRODUCT.NORMAL.code') }}">{{ __('admin.no') }}
                            </label>

                            <label><input type="radio" name="hot"
                                          value="{{ Config::get('settings.HOT_PRODUCT.HOT.code') }}">{{ __('admin.yes') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('front.picture') }}</label>
                        <input type="file" style="{{ $errors->has('picture.*') ? 'border-color: red' :'' }}" id="picture"
                               name="picture[]" class="form-control" multiple>
                        @error('picture.*')
                        <small class="form-text text-muted text-red">
                            {{$errors->first('picture.*','Files must be photos up to 2MB in size')}}
                        </small>
                        @enderror
                    </div>
                </div>
                @foreach($languages as $language)
                    <div class="tab-pane fade" id="{{ $language->short_name }}" role="tabpanel"
                         aria-labelledby="profile-tab">
                        <div class="form-group">
                            <label>{{ __('front.title') }}</label>
                            <input type="text" class="form-control" id="title"
                                   name="title_{{ $language->short_name }}"
                                   value="{{ old('title_'.$language->short_name) }}" placeholder="{{ __('admin.product.Enter title') }}">

                        </div>

                        <div class="form-group">
                            <label>{{ __('front.description') }}</label>
                            <textarea class="form-control" id="description"
                                      name="description_{{ $language->short_name }}"
                                      placeholder="{{ __('admin.product.Enter desciption') }}">{{ old('description_'.$language->short_name) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('front.content') }}</label>
                            <textarea class="form-control editor" id="lang{{ $language->short_name }}"
                                      name="content_{{ $language->short_name }}"
                                      placeholder="{{ __('admin.product.Enter content') }}">{{ old('content_'.$language->short_name) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src={{ URL::asset('ckeditor/ckeditor.js') }}></script>
    <script>
        $(document).ready(function () {

            $("#location").change(function () {
                var location_id = $(this).val();
                if(location_id == ''){
                    $("#city").prop( "disabled", true );
                    $("#route").prop( "disabled", true );
                    $("#city").html( '<option value="">{{ __('front.Please choose a prefectures') }}</option>' );
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
                        $("#distance").append('<div id="addDis"><div class="form-group ' + random + '"> ' +
                            '<div class="col-sm-12" > ' +
                            '<div class="row"> ' +
                            '<div class="col-md-3"><select name="route" class="form-control route" data-id="' + random + '">' + route_option + '</select></div>' +
                            '<div class="col-md-4"><select name="station" class="form-control ' + random + '" id="' + random + '" disabled><option>{{ __('front.Please choose a route') }}</option></select></div> ' +
                            '<div class="col-md-4"><input name="time_walking" class="form-control ' + random + '" type="number" min="0" id="time_walking" disabled></div> ' +
                            '<div class="col-md-1"> <label class="btn btn-danger del-distance" data-id="' + random + '"><i class="fa fa-minus-square"></i></label> </div> </div> </div> </div></div>');
                        $("#location").change(function () {
                            $("#addDis").remove();
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
