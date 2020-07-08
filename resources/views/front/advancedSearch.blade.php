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

    </style>
<div class="center" id="hlcenter" style="; border: none;">
    <div id="container" class="w-clear">
        <div class="row" style="margin-right: -5px;margin-left: -5px;">
            @include('front.element.menuPC')
            <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                <div class="row" style="margin-right: -5px;margin-left: -5px;">
                    <div class="col-md-8" style="padding-left: 5px;padding-right: 5px;">
                        <div id="advancedSearch">
                            <div class="form-group">
                                <label>{{ __('front.カテゴリー') }}</label>
                                <select class="form-control" name="cate_id" id="cate_id">
                                    @foreach($categories as $category)
                                    <option {{ (isset($selectSearch) && $selectSearch['cate_id'] == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->lang_category ? $category->lang_category : $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pwd">{{ __('front.都道府県') }}</label>
                                <select class="form-control" name="location_id" id="location_id">
                                    @foreach($locations as $location)
                                    <option value="{{$location->id}}" {{ (isset($selectSearch) && $selectSearch['location_id'] == $location->id) ? 'selected' : '' }}>
                                        {{ $location->lang_location ? $location->lang_location : $location->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn" onclick="handleRedirectSearch('region')">{{ __('front.地域で検索') }}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn"  onclick="handleRedirectSearch('station_name')">{{ __('front.駅名で検索') }}</button>
                            </div>
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
<script src="{{ URL::asset('assets/front/js/ptkAcumen.js') }}"></script>
<script type="text/javascript">
    if ($(window).width() > 900) {
        $(".sliderHot").ptkAcumen({
            items: 1,
            itemsConver: 1,
            marginRight: 1,
        });
    }

    function handleRedirectSearch(type_name) {
        let location_id = $('#location_id').val();
        let cate_id = $('#cate_id').val();
        let type_search = 1; // SEARCH_BY_REGION
        if (type_name == 'region') {
            type_search = 1;
        } else {
            type_search = 2; // SEARCH_BY_ROUTE
        }
        window.location.href = "/search/" + type_search + '/' + cate_id + '/' + location_id;
    }
</script>
@endsection
