<div id="smenu">
    <img src="{{ URL::asset('assets/front/images/menu.png') }}" alt="Menu" class="i-menu" />
    <a href="{{ Auth::check()?route("add_new_product"):route("login") }}" onclick="{{Auth::check()? '' : 'alert("'.__('front.You are not logged in, log in to post').'");'}}">
        <i class="fa fa-pencil" style="
                    display:  inline-block;
                    font-size: 14px;
                    padding-top: -10px;
                "></i>
        <span style="vertical-align: middle;">{{ __('front.Publish your ad for free') }}</span>
    </a>
</div>
<div id="menus">
    <div class="smenu-menu">
        <ul id="main-menus" class="sm sm-blue">
            <li class="{{!isset($categorys)?'active':''}}">
                <a href="{{route("home")}}">
                    <i class="fa fa-folder-open"></i>
                    {{ __('front.All') }}</a>
            </li>
            @foreach($categories as $category)
                <li class="{{ isset($categorys)?(($categorys->id==$category->id)?'active':''):'' }}">
                    <a href="{{route('search_category',['id'=>$category->id])}}"><img class="icon_img" src="{{ URL::asset($category->icon) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
                        {{ $category->lang_category ? $category->lang_category : $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

