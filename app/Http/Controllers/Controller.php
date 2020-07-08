<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Currency;
use App\Models\FloorPlanMaster;
use App\Models\Language;
use App\Models\Location;
use App\Models\ViewedProduct;
use App\Models\Product;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Config;
use Cache;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $categories = Category::select('categories.*',
                DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = categories.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME") . ') as lang_category')
            )
                ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                ->orderBy('position', 'ASC')
                ->get();
            View::share('categories', $categories);
            $locations = Location::select('locations.*',
                DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = locations.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME") . ') as lang_location')
            )
                ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->orderBy('position', 'ASC')->get();
            View::share('locations', $locations);
            $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->orderBy('position', 'ASC')->get();
            View::share('currencies', $currencies);
            $languages = Language::select('languages.*',
                DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = languages.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LANGUAGE_NAME") . ') as lang_language')
            )
                ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
            View::share('languages', $languages);

            $language_session=Language::select('languages.*',
                DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = languages.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LANGUAGE_NAME") . ') as lang_sl_language')
            )
                ->where('short_name',App::getLocale())
                ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                ->first();
            View::share('language_session', $language_session);


            $filter_min_price = 0;
            $filter_max_price = 9999999999999;
            $filter_floor_plan = [];
            $filter_area = 0;
            $filter_walk_from_station = 0;
            $filter_age = 0;
            $product_hot = Product::select('products.*',
                DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE") . ') as lang_title')
            )
                ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                ->where('products.approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                ->where('price', '>=', $filter_min_price)
                ->where('price', '<=', $filter_max_price)
                ->where('hot', Config::get('settings.HOT_PRODUCT.HOT.code'))
                ->join('product_temp', 'products.id', '=', 'product_temp.product_id')
                ->when($filter_area, function ($query) use ($filter_area) {
                    return $query->where('area_used', '>=', $filter_area);
                })
                ->when($filter_walk_from_station, function ($query) use ($filter_walk_from_station) {
                    return $query->where('distance', '<=', $filter_walk_from_station);
                })
                ->where(function ($query) use ($filter_floor_plan) {
                    if (isset($filter_floor_plan) && count($filter_floor_plan)) {
                        foreach ($filter_floor_plan as $items) {
                            $arItem = explode(",", $items);
                            foreach ($arItem as $item) {
                                $query->orWhere('group_floor', 'like', '%"' . $item . '"%');
                            }
                        }
                    }
                })
                ->when($filter_age, function ($query) use ($filter_age) {
                    $complete_time = date('Y-m-d', strtotime("-$filter_age year"));
                    return $query->where('complete_time', '>=', $complete_time);
                })
                ->groupBy('products.id')
                ->orderBy('created_at', 'desc')
                ->get();
            View::share('product_hot', $product_hot);

            $listGroupFloorPlan = FloorPlanMaster::select('*', DB::raw('group_concat(title) as titles'), DB::raw('group_concat(id) as list_id'))
                                                    ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                                                    ->groupBy('group_id')
                                                    ->get();
            View::share('listGroupFloorPlan', $listGroupFloorPlan);

            //
            if(Auth::check()){
                $viewedProducts = Product::select('products.*',
                    DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE") . ') as lang_title')
                )
                    ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                    ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                    ->join('viewed_products', 'products.id', '=', 'viewed_products.product_id')
                    ->where('viewed_products.user_id', Auth::user()->id)
                    ->orderBy('viewed_products.updated_at', 'DESC')
                    ->take(Config::get('settings.GET_TAKE_10_PROD'))
                    ->get();
                View::share('viewedProducts', $viewedProducts);
            }

            //
            if(Cache::has('BTC')){
                $exchangeRateBTC = Cache::get('BTC');
            }else{
                $exchangeRateBTC = 0;
            }
            View::share('exchangeRateBTC', $exchangeRateBTC);

            return $next($request);


        });
    }
}
