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
                            <div style="color: red" class="vip width_common box_category box_home">
                                {{ __('front.Product not found') }}
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
