<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Location;
use App\Models\Translation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $id = App::getLocale();


////        dd(App::getLocale());
//        $categories = Category::select('categories.*',
//            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = categories.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME").') as lang_category')
//        )
//            ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
//            ->orderBy('position', 'ASC')
//            ->get();
////        dd($categories);
//        View::share('categories', $categories);
//        $locations = Location::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->orderBy('position', 'ASC')->get();
//        View::share('locations', $locations);
//        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->orderBy('position', 'ASC')->get();
//        View::share('currencies',$currencies);
//        $languages=Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
//        View::share('languages',$languages);

//        $translations_prod= Translation::where('lang_code', App::getLocale())
//            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
//            ->get();
//        View::share('translations_prod',$translations_prod);
//        $translations_cat= Translation::where('lang_code', App::getLocale())
//            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.CATEGORY'))
//            ->get();
//        View::share('translations_cat',$translations_cat);
//        $translations_lang= Translation::where('lang_code', App::getLocale())
//            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.LANGUAGE'))
//            ->get();
//        View::share('translations_lang',$translations_lang);
        Schema::defaultStringLength(191);
    }
}
