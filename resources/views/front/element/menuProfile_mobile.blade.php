<div class="menu_profile_mobile">


        <span class="icon-menu">
            <strong>
                <a href="" class="nav_profile">
                    @auth
                        {{ Auth::user()->name }}
                        @else
                        {{ __('front.Account') }}
                    @endauth
                <i class="fa fa-angle-double-down"></i>
            </a>
            </strong>
        </span>


    <ul class="side-categories" style="display:none">
        @guest
            <li class="list_menu">
                <a href="{{route("login")}}">
                    {{ __('front.Login') }}
                    <i class="fa fa-user"></i>
                </a>
            </li>
            <li class="list_menu">
                <a href="{{route("register")}}">
                    {{ __('front.Register') }}
                    <i class="fa fa-users"></i>
                </a>
            </li>

            <li class="list_menu">
                <li class="list_menu list_lang">
                    <a>
                        {{ __('front.Languages') }} <i class="fa fa-language"></i>
                    </a>
                </li>
                <ul class="lang_area">
                    @foreach($languages as $lang)
                        <li class="list_menu">
                            <a href="{{ route('change-language', ['locale'=>$lang->short_name]) }}">
                                {{ $lang->lang_language ? $lang->lang_language : $lang->name }}
                                <img style="width: 20px" src="{{ URL::asset($lang->path) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                            </a>
                        </li>
                    @endforeach
                </ul>

            </li>

        @else
            <li class="list_menu">
                <a href="{{route("profile")}}">
                    {{ __('front.Infomation') }}
                    <i class="fa fa-user"></i>
                </a>
            </li>
            <li class="list_menu">
                <a href="{{route("getMessages")}}">
                    </i> {{ __('front.Messages') }}
                    <i class="fa fa-comments"></i>
                </a>
            </li>
            @if(@unserialize(Auth::user()->user_type)==true)
                @foreach(unserialize(Auth::user()->user_type) as $key => $value)
                    @if($value == Config::get('settings.USER_TYPE.SELLER.code'))
                        <li class="list_menu">
                            <a href="{{route("products")}}">
                                {{ __('front.Your products') }}
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif

            <li class="list_menu">
                <a href="{{ route("password") }}">
                    {{ __('front.Change password') }}
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </a>
            </li>
            <li class="list_menu">
            <li class="list_menu list_lang">
                <a>
                    {{ __('front.Languages') }} <i class="fa fa-language"></i>
                </a>
            </li>
            <ul class="lang_area">
                @foreach($languages as $lang)
                    <li class="list_menu">
                        <a href="{{ route('change-language', ['locale'=>$lang->short_name]) }}">

                            {{ $lang->lang_language ? $lang->lang_language : $lang->name }}
                            <img style="width: 20px" src="{{ URL::asset($lang->path) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                        </a>
                    </li>
                @endforeach
            </ul>

            </li>
            <li class="list_menu">
                <a href="{{route("logout")}}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('front.Logout') }}
                    <i class="fa fa-sign-out"></i>
                </a>
            </li>
            {{--            <li>--}}
            {{--                <a href="{{route("change_mail")}}">--}}
            {{--                    <i class="fa fa-envelope" aria-hidden="true"></i> Change email </a>--}}
            {{--            </li>--}}
        @endguest

    </ul>

</div>


