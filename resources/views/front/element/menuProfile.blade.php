<div class="col-md-2 hidden-xs" id="halink-left" style="padding-left: 5px;padding-right: 5px;">
    <div class="list_item_panel">
        <ul>
            <li class="{{ isset($active_profile)?'active':'' }}">
                <a href="{{route("profile")}}">
                    <i class="fa fa-user"></i>
                    {{ __('front.Infomation') }}</a>
            </li>
            <li class="{{ isset($active_message)?'active':'' }}">
                <a href="{{route("getMessages")}}">
                    <i class="fa fa-comments"></i> {{ __('front.Messages') }} </a>
            </li>

            @if(@unserialize(Auth::user()->user_type)==true)
                @foreach(unserialize(Auth::user()->user_type) as $key => $value)
                    @if($value == Config::get('settings.USER_TYPE.SELLER.code'))
                        <li class="{{ isset($active_product)?'active':'' }}">
                            <a href="{{route("products")}}">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i> {{ __('front.Your products') }} </a>
                        </li>
                    @endif
                @endforeach
            @endif


            <li class="{{ isset($active_password)?'active':'' }}">
                <a href="{{ route("password") }}">
                    <i class="fa fa-lock" aria-hidden="true"></i> {{ __('front.Change password') }} </a>
            </li>
{{--            <li>--}}
{{--                <a href="{{route("change_mail")}}">--}}
{{--                    <i class="fa fa-envelope" aria-hidden="true"></i> Change email </a>--}}
{{--            </li>--}}

        </ul>
    </div>
    <div class="col_200">
        <ul>
        </ul>
    </div>


</div>
