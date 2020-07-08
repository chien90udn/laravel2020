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
                    <input type="hidden" value="" id="crp">
                    <div class="main-tit">
                        <span>{{$product->title}}</span>

                    </div>
                    <ul class="nav nav-tabs" style="margin-left: 0px;" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#chat">{{ __('front.Messages') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#detail">{{ __('front.Detail') }}</a>
                        </li>
                    </ul>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="chat" class="tab-pane active"><br>
                                        <div id="dynamic_field">
                                            @foreach($messages as $message)
                                                @if($message->user_id_from == Auth::user()->id && $message->user_id_from_type == Config::get('settings.TYPE_ACCOUNT.USER'))
                                                    <p colspan="2" align="right">
                                                        {{ $message->content }}<br>
                                                        <small style="color: red">
                                                            <i>
                                                                @if($message->approve == Config::get('settings.GLOBAL_APPROVE.DISABLED.code'))
                                                                    {{ Config::get('settings.GLOBAL_APPROVE.DISABLED.name') }}
                                                                @endif
                                                            </i>
                                                        </small>
                                                    </p>
                                                @else
                                                    @if($message->approve == Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                                                        <p colspan="2">
                                                            <strong>{{ $message->user_id_from_type == Config::get('settings.TYPE_ACCOUNT.ADMIN')?$message->admin_from->name:$message->users->name}}</strong>
                                                            {{': '.$message->content}}
                                                        </p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <form id="add_reply">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="content_mess" id="content_mess">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" id="send">
                                                        <i class="fa fa-send"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div id="detail" class="tab-pane"><br>
                                            <div class="col-sm-6">
{{--                                                <div id="bx-slider">--}}
{{--                                                    {{dd(count($images))}}--}}

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

{{--                                                @if(count($images)==0)--}}
{{--                                                        <img src="{{ URL::asset('assets/front/images/no_image.png') }}">--}}
{{--                                                    @else--}}
{{--                                                        @foreach($images as $img)--}}
{{--                                                            <img src="{{ URL::asset($img->path) }}"--}}
{{--                                                                 onerror="this.src='{{ URL::asset('assets/front/images/no_image.png') }}';">--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="col-sm-6">
                                                        <h3>{{ $product->lang_title ? $product->lang_title : $product->title }}</h3>
                                                <div class="col-sm-4"><i class="fa fa-location-arrow"></i> {{ $product->lang_location ? $product->lang_location : $product->locations['name'] }}</div>
                                                <div class="col-sm-8"><i class="fa fa-calendar"></i> {{ date_format($product->created_at, 'H:i d/m/Y') }}</div>
                                                <div class="col-sm-4 btn btn-danger">{{ __('front.Price') }}: {{ $product->currency['name'].$product->price }}</div>
                                                <div class="col-sm-12"><strong>{{ $product->lang_description ? $product->lang_description : $product->description }}</strong></div>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! $product->lang_content ? $product->lang_content : $product->content !!}
                                            </div>



                                    </div>
                                </div>

                                <div class="paging"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        var i = 1;
        $('#send').click(function () {
            var content = $('#content_mess').val();
            $.ajax({
                url: "{{ route('replyMessage', ['type'=>$arr_get_link['type'],'product_id'=>$arr_get_link['product_id'],'reply_id'=>$arr_get_link['reply_id']]) }}",
                method: "POST",
                data: $('#add_reply').serialize(),
                success: function (data) {
                    i++;
                    $('#dynamic_field').append('<p colspan="2" align="right" id="row' + i + '">' + content + '<br><small style="color: red"><i>Disabled</i></small></p>');
                    $('#content_mess').attr('value','');
                    var objDiv = document.getElementById("dynamic_field");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            });

        return false;
        });
    });
</script>
@endsection
