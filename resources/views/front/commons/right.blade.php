<div class="raovat_sieuvip_top fr">
        <h4 class="title_boxhome">
            <a href="#">
                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                {{ __('front.Hot') }}
            </a>
        </h4>
        <div class="custom-scrollbar">
            @if(isset($product_hot))
                @foreach($product_hot as $prod_hot)
                    <ul class="sliderHot">
                        <div class="ptkAcumen" ipage="1"
                             style="width: 299px; position: relative; left: 0px;">
                            <div class="items"
                                 style="display: inline-block; width: 289px; margin-right: 10px; float: left;">
                                <li>
                                    <div class="box_img_bottom">
                                        <a href="{{route('detail',['id'=>$prod_hot->id])}}">
                                            <img class="imgProdList" src="{{URL::asset($prod_hot->images['path'])}}"
                                                 onerror="this.src='{{URL::asset('assets/front/images/no_image.png')}}';">
                                        </a>
                                        @if($prod_hot -> sold == Config::get('settings.SOLD'))
                                            <label class="sold1">{{ __('front.Sold') }}</label>
                                        @endif
                                    </div>
                                    <div class="info_raovat">
                                        <h3>
                                            <a href="{{route('detail',['id'=>$prod_hot->id])}}"><img
                                                    style="margin-top: -9px;"
                                                    src="{{URL::asset('assets/front/images/hot.png')}}">
                                                {{ $prod_hot->lang_title ? $prod_hot->lang_title : $prod_hot->title }}
                                            </a>
                                        </h3>
                                        <p>
                                            {{$prod_hot->currency['name'].number_format($prod_hot->price)}}
                                        </p>
                                    </div>
                                </li>


                            </div>
                        </div>
                    </ul>
                @endforeach
            @endif
        </div>
        <script src="{{ URL::asset('assets/front/js/ptkAcumen.js') }}"></script>
        <script type="text/javascript">
            if ($(window).width() > 900)
                $(".sliderHot").ptkAcumen({
                    items: 1,
                    itemsConver: 1,
                    marginRight: 1,
                });
            function handleSearchLocation($location){
                if(!$location){
                    return;
                }
                // set data
                $("#idc").val($location);
                $('#idl').val(0);
                //  submit
                document.getElementById('formSearch').submit();
            }
        </script>

        {{--                                <div class="box_guide_post">--}}
        {{--                                    <a class="view_all" href="/tin-noi-bat">Xem thêm <em class="glyphicon glyphicon-chevron-right"></em></a>--}}
        {{--                                </div>--}}
    </div>
@if(isset($viewedProducts) && count($viewedProducts))
    <div class="raovat_sieuvip_top fr">
        <h4 class="title_boxhome">
            <a href="#">
                <i class="fa fa-history" aria-hidden="true"></i>
                {{ __('front.Seen Product') }}
            </a>
        </h4>
        <div class="custom-scrollbar">
        @foreach($viewedProducts as $prod_hot)
        <ul class="sliderHot">
            <div class="ptkAcumen" ipage="1" style="width: 299px; position: relative; left: 0px;">
                <div class="items" style="display: inline-block; width: 289px; margin-right: 10px; float: left;">
                    <li>
                        <div class="box_img_bottom">
                            <a href="{{route('detail',['id'=>$prod_hot->id])}}">
                                <img class="imgProdList" src="{{URL::asset($prod_hot->images['path'])}}" onerror="this.src='{{URL::asset('assets/front/images/no_image.png')}}';">
                            </a>
                            @if($prod_hot -> sold == Config::get('settings.SOLD'))
                                <label class="sold1">{{ __('front.Sold') }}</label>
                            @endif
                        </div>
                        <div class="info_raovat">
                            <h3>
                                <a href="{{route('detail',['id'=>$prod_hot->id])}}">
                                    {{ $prod_hot->lang_title ? $prod_hot->lang_title : $prod_hot->title }}
                                </a>
                            </h3>
                            <p>
                                {{$prod_hot->currency['name'].number_format($prod_hot->price)}}
                            </p>
                        </div>
                    </li>
                </div>
            </div>
        </ul>
        @endforeach
        </div>

    </div>
@endif
