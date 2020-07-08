<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Models\Product;
use App\Models\Category;
use App\Models\Message;
use App\Models\ProductImages;
use App\Models\User;
use App\Models\RegionMaster;
use App\Models\cityMaster;
use App\Models\RouteMaster;
use App\Models\OperatingCompany;
use App\Models\StationNameMaster;
use Config;
use Session;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        return view('front.index')
                ->with('new_products', $new_products);
    }

    /**
     * Show the select search.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function selectSearch(Request $request)
    {

        //  get type search
        $type_search = $request->type;
        $location_id = $request->location_id;
        $cate_id = $request->cate_id;
        $route_master_id = $request->route_master_id;
        $isMethodPostSearch = false;
        // check input
        if(!$cate_id || !$type_search){
            return redirect()->route('front.search');
        }

        /** create variable **/
        $listRegion = [];
        $listOperatingCompany = [];
        $listStation = [];
        $infoRouteMaster = null;
        $resultSearch = [];

        $inputCity = [];
        $inputRoute = [];
        $inputStation = [];

        $filter_min_price = 0;
        $filter_max_price = 9999999999999;
        $filter_floor_plan = [];
        $filter_area = 0;
        $filter_walk_from_station = 0;
        $filter_age = 0;
        // handle data

        if($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_REGION')){
            // get region and city
            $listRegion = RegionMaster::where('region_master.location_id', $location_id)
                            ->get();

        }elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_ROUTE')){
            // get operating company and route master
            $listOperatingCompany = OperatingCompany::select('operating_company.*')
                            ->where('route_master.location_id', $location_id)
                            ->join('route_master', 'operating_company.id', '=', 'route_master.operating_company_id')
                            ->groupBy('operating_company.title')
                            ->get();

        }elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME')){
            $infoRouteMaster = RouteMaster::find($route_master_id);
            // get station name company
            $listStation = StationNameMaster::where('station_name_master.location_id', $location_id)
                            ->where('station_name_master.route_master_id', $route_master_id)
                            ->get();
        }

        if ($request->isMethod('post')) {
            if(isset($request->is_form_filter)){
                $inputCity = $request->inputCity ? unserialize($request->inputCity) : [];
                $inputRoute = $request->inputRoute ? unserialize($request->inputRoute) : [];
                $inputStation = $request->inputStation ? unserialize($request->inputStation) : [];
                $filter_min_price = $request->filter_min_price ? $request->filter_min_price : $filter_min_price;
                $filter_max_price = $request->filter_max_price ? $request->filter_max_price : $filter_max_price;
                $filter_area = $request->filter_area ? $request->filter_area : $filter_area;
                $filter_age = $request->filter_age ? $request->filter_age : $filter_age;
                $filter_floor_plan = $request->filter_floor_plan ? $request->filter_floor_plan : $filter_floor_plan;
                $filter_walk_from_station = $request->filter_walk_from_station ? $request->filter_walk_from_station : $filter_walk_from_station;
            }else{
                $inputCity = $request->city;
                $inputRoute = $request->route;
                $inputStation = $request->station;
            }
            // create session
            $sessionSearch = [
                'inputCity'     => $inputCity,
                'inputRoute'    => $inputRoute,
                'inputStation'  => $inputStation
            ];
            Session::put('SEARCH', $sessionSearch);

            $isMethodPostSearch = true;
            if($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_REGION')){

                if($inputCity && count($inputCity)){
                    $resultSearch = Product::select('*', 'products.id as product_id')
                                    ->where('category_id' , $cate_id)
                                    ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                                    ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                                    ->where('price', '>=',$filter_min_price)
                                    ->where('price', '<=', $filter_max_price)
                                    ->whereIn('city_master_id' , $inputCity)
                                    ->when($filter_area, function ($query) use ($filter_area) {
                                        return $query->where('area_used', '>=', $filter_area);
                                    })
                                    ->where(function ($query) use ($filter_floor_plan) {
                                        if(isset($filter_floor_plan) && count($filter_floor_plan)){
                                            foreach ($filter_floor_plan as $item) {
                                                $arItem = explode(",", $item);
                                                foreach ($arItem as $item) {
                                                    $query->orWhere('group_floor', 'like', '%"'.$item.'"%');
                                                }
                                            }
                                        }
                                    })
                                    ->when($filter_age, function ($query) use ($filter_age) {
                                        $complete_time = date('Y-m-d', strtotime("-$filter_age year"));
                                        return $query->where('complete_time', '>=', $complete_time);
                                    })
                                    ->get();
                }
            }elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_ROUTE')){
                if($inputRoute && count($inputRoute)){
                    $resultSearch = Product::select('*', 'products.id as product_id')
                                            ->where('category_id' , $cate_id)
                                            ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                                            ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                                            ->where('price', '>=',$filter_min_price)
                                            ->where('price', '<=', $filter_max_price)
                                            ->join('product_temp', 'products.id', '=', 'product_temp.product_id')
                                            ->whereIn('product_temp.route_master_id' , $inputRoute)
                                            ->when($filter_area, function ($query) use ($filter_area) {
                                                return $query->where('area_used', '>=', $filter_area);
                                            })
                                            ->where(function ($query) use ($filter_floor_plan){
                                                if(isset($filter_floor_plan) && count($filter_floor_plan)){
                                                    foreach ($filter_floor_plan as $item) {
                                                        $arItem = explode(",", $item);
                                                        foreach ($arItem as $item) {
                                                            $query->orWhere('group_floor', 'like', '%"'.$item.'"%');
                                                        }
                                                    }
                                                }
                                            })
                                            ->when($filter_age, function ($query) use ($filter_age) {
                                                $complete_time = date('Y-m-d', strtotime("-$filter_age year"));
                                                return $query->where('complete_time', '>=', $complete_time);
                                            })
                                            ->groupBy('products.id')
                                            ->get();
                }
            }elseif($type_search == Config::get('settings.TYPE_SEARCH.SEARCH_BY_STATION_NAME')){
                if($inputStation && count($inputStation)){
                    $resultSearch = Product::select('*', 'products.id as product_id')
                                        ->where('category_id' , $cate_id)
                                        ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                                        ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                                        ->where('price', '>=',$filter_min_price)
                                        ->where('price', '<=', $filter_max_price)
                                        ->join('product_temp', 'products.id', '=', 'product_temp.product_id')
                                        ->where('product_temp.route_master_id', $route_master_id)
                                        ->when($filter_area, function ($query) use ($filter_area) {
                                            return $query->where('area_used', '>=', $filter_area);
                                        })
                                        ->when($filter_walk_from_station, function ($query) use ($filter_walk_from_station) {

                                            return $query->where('distance', '<=', $filter_walk_from_station);
                                        })
                                        ->where(function ($query) use ($filter_floor_plan) {
                                            if(isset($filter_floor_plan) && count($filter_floor_plan)){
                                                foreach ($filter_floor_plan as $item) {
                                                    $arItem = explode(",", $item);
                                                    foreach ($arItem as $item) {
                                                        $query->orWhere('group_floor', 'like', '%"'.$item.'"%');
                                                    }
                                                }
                                            }
                                        })
                                        ->when($filter_age, function ($query) use ($filter_age) {
                                            $complete_time = date('Y-m-d', strtotime("-$filter_age year"));
                                            return $query->where('complete_time', '>=', $complete_time);
                                        })
                                        ->whereIn('station_name_id' , $inputStation)
                                        ->groupBy('products.id')
                                        ->get();
                }
            }
        }else{

            if(Session::has('SEARCH')){
                $sessionSearch = Session::get('SEARCH');
            }else{
                $sessionSearch = [
                    'inputCity'     => [],
                    'inputRoute'    => [],
                    'inputStation'  => []
                ];
            }
            Session::put('SELECT_SEARCH', ['cate_id' => $cate_id, 'location_id' => $location_id]);

        }
        return view('front.searchs.select_search')
                ->with('type_search', $type_search)
                ->with('location_id', $location_id)
                ->with('cate_id', $cate_id)
                ->with('route_master_id', $route_master_id)
                ->with('listRegion', $listRegion)
                ->with('listOperatingCompany', $listOperatingCompany)
                ->with('listStation', $listStation)
                ->with('infoRouteMaster', $infoRouteMaster)
                ->with('resultSearch', $resultSearch)
                ->with('isMethodPostSearch', $isMethodPostSearch)
                ->with('inputCity', serialize($inputCity))
                ->with('inputRoute', serialize($inputRoute))
                ->with('inputStation', serialize($inputStation))
                ->with('request', $request)
                ->with('search_from', 'advanced_search')
                ->with('sessionSearch', $sessionSearch);
    }
}
