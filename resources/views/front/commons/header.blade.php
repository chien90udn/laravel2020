<div id="banner" style="">
    <div id="myvne_taskbar_raovat" class="center">
        <div class="myvne_container">
            <a href="{{ route('home') }}" class="logo_vne">
                <img title="Matching site" src="{{ URL::asset('assets/front/images/logo.png') }}" alt="@yield('title')"
                     class="logo"/>
            </a>

                @if(Auth::check())
                    @if (@unserialize(Auth::user()->user_type)==true)
                        @if (!in_array(Config::get('settings.USER_TYPE.SELLER.code'), unserialize(Auth::user()->user_type)))
                        @else
                        <div class="txt_dangtin right1" style="margin-top: 6px; padding: 0px 10px;">
                            <a href="{{ route("add_new_product") }}" class="myvne_submit">{{ __('front.Publish your ad for free') }}</a>
                        </div>
                        @endif
                    @endif
                @else
                    <div class="txt_dangtin right1" style="margin-top: 6px; padding: 0px 10px;">
                        <a href="{{ route("login") }}" class="myvne_submit"
                           onclick="{{'alert("'.__('front.You are not logged in, log in to post').'");'}}">{{ __('front.Publish your ad for free') }}</a>
                    </div>
                @endif

            <ul class="myvne_form_log right1 hidden-xs" style="border: none">
                <li class="myvne_user">
                    @guest
                        <a href="{{ route('login') }}">
                            <i class="fa fa-lock"></i>{{ __('front.Login') }}
                        </a>
                        |
                        <a href="{{ route('register') }}">
                            {{ __('front.Register') }}
                        </a>
                    @else
                        <a href="{{ route('profile') }}"> {{ Auth::user()->name }} </a> | <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('front.Logout') }}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </li>
            </ul>

            @foreach($languages as $lang)
                <div class="dropdown right1 myvne_form_log hidden-xs">
                    <a role="menuitem" tabindex="-1" href="{{ route('change-language', ['locale'=>$lang->short_name]) }}">
                        <img class="picture_lang" src="{{ URL::asset($lang->path) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                    </a>
                </div>
            @endforeach
            <div class="dropdown right1 myvne_form_log hidden-xs">
                <a role="menuitem" tabindex="-1" href="{{ route('agencies') }}">
                    <button type="button" class="btn btn-primary btn-xs">{{ __('front.Agencies') }}</button>
                </a>
            </div>
{{--            <div class="dropdown right1 myvne_form_log hidden-xs">--}}
{{--                <button class="btn btn-default btn-sm dropdown-toggle button_lang" type="button" id="menu1" data-toggle="dropdown">--}}
{{--                    <img class="picture_lang" src="{{ URL::asset($language_session->path) }}"--}}
{{--                         onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">--}}
{{--                    {{ $language_session->lang_sl_language ? $language_session->lang_sl_language : $language_session->name }}--}}
{{--                    <span class="caret"></span></button>--}}
{{--                <ul class="dropdown-menu menu-language" role="menu" aria-labelledby="menu1">--}}
{{--                    @foreach($languages as $lang)--}}
{{--                    <li role="presentation">--}}
{{--                        <a role="menuitem" tabindex="-1" href="{{ route('change-language', ['locale'=>$lang->short_name]) }}">--}}
{{--                            <img class="picture_lang" src="{{ URL::asset($lang->path) }}"--}}
{{--                                 onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">--}}
{{--                            {{ $lang->lang_language ? $lang->lang_language : $lang->name }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
            <div class="clear"></div>
        </div>
    </div>
    <script>
        $('#halink-menu').on('click', function () {
            $('.dropdown-menu').toggle();
        });
    </script>
</div>
<div style="
    padding: 0 15px;
    max-width: 1140px;
    margin: 0 auto;
    /* max-width: 980px; */
    max-width: 1140px;
    position: relative;
    text-align: center; padding-top:15px;  padding-bottom:10px;">
    <div id="search-dm">
        <div class="row" style="">
            <form id="formSearch" action="{{ route('search') }}" method="post">
                @csrf
                <div class="col-md-4 halink-layout">
                    <input class="form-control halink-form no-border" id="keywords"
                           value="{{isset($search)?$search['key']:''}}"
                           placeholder=" {{ __('front.Search...') }}"
                           name="key" id="srch-term"
                           type="text" onkeypress="doEnters(event)">
                    <i class="form-control-search fa fa-search hidden-xs"></i>
                </div>
                <div class="col-md-3 halink-layout">
                    <i id="mbn-top-search-city-icon" class="fa fa-map-marker hidden-xs"></i>
                    <select name="location" class="form-control halink-form no-border" id="idc">
                        <option value="">{{ __('front.Locations') }}</option>
                        @foreach($locations as $location)
                            <option
                                value="{{$location->id}}" {{isset($search)?($search['location']==$location->id?'selected':''):''}}>
                                {{ $location->lang_location ? $location->lang_location : $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 halink-layout">
                    <div class="input-group add-on">
                        <i class="fa fa-th-large hidden-xs" id="idl-icon"></i>
                        <select name="category" id="idl" class="form-control halink-form no-border">
                            <option value="">{{ __('front.Categories') }}</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{$category->id}}" {{isset($search)?($search['category']==$category->id?'selected':''):''}}>
                                    {{ $category->lang_category ? $category->lang_category : $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-btn">
                            <button
                                style="border-color: white;background: #ed1c24 none repeat scroll 0 0; color: #fff;"
                                class="btn btn-default" type="submit"><i class="fa fa-search"></i> {{ __('front.Search') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
                <div class="col-md-2 halink-layout">
                    <div class="">
                        <a href="{{ route('advancedSearch') }}">
                            <button
                                style="border-color: white;background: #ed1c24 none repeat scroll 0 0; width: 100%; color: #fff;"
                                class="btn btn-default" >{{ __('front.Advanced search') }}
                            </button>
                        </a>
                    </div>
                </div>
        </div>
    </div>
</div>
@include('front.element.menu_mobile')
@include('front.element.menuProfile_mobile')

