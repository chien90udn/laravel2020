<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProductsRequest;
use App\Models\Category;
use App\Models\CityMaster;
use App\Models\Currency;
use App\Models\FloorPlanMaster;
use App\Models\Language;
use App\Models\Location;
use App\Models\ProductImages;
use App\Models\ProductTemp;
use App\Models\RegionMaster;
use App\Models\RouteMaster;
use App\Models\StationNameMaster;
use App\Models\Translation;
use Illuminate\Http\Request;
use Config;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // create & set default
        $filter_min_price = 0;
        $filter_max_price = 9999999999999;
        $filter_floor_plan = [];
        $filter_area = 0;
        $filter_walk_from_station = 0;
        $filter_age = 0;

        // Get the latest product
        $new_products = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE") . ') as lang_title'),
            DB::raw('(SELECT translations.lang_content FROM translations, locations WHERE translations.post_id = locations.id and locations.id=products.location_id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME") . ') as lang_location')
        )
            ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('products.approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->where('price', '>=', $filter_min_price)
            ->where('price', '<=', $filter_max_price)
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
            ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

        return view('front.index')
            ->with('new_products', $new_products);

    }

    // Advanced search

    public function advanced_search()
    {
        if (session()->has('SEARCH')) {
            session()->remove('SEARCH');
        }

        if (session()->has('SELECT_SEARCH')) {
            $selectSearch = session()->get('SELECT_SEARCH');
        } else {
            $selectSearch = ['cate_id' => null, 'location_id' => null];
        }

        return view("front.advancedSearch")
            ->with('selectSearch', $selectSearch);
    }

    //search with keyword
    public function search(Request $request)
    {
        // create & set default
        $filter_min_price = 0;
        $filter_max_price = 9999999999999;
        $filter_floor_plan = [];
        $filter_area = 0;
        $filter_walk_from_station = 0;
        $filter_age = 0;

        if (isset($request->is_form_filter)) {
            $filter_min_price = $request->filter_min_price ? $request->filter_min_price : $filter_min_price;
            $filter_max_price = $request->filter_max_price ? $request->filter_max_price : $filter_max_price;
            $filter_area = $request->filter_area ? $request->filter_area : $filter_area;
            $filter_age = $request->filter_age ? $request->filter_age : $filter_age;
            $filter_floor_plan = $request->filter_floor_plan ? $request->filter_floor_plan : $filter_floor_plan;
            $filter_walk_from_station = $request->filter_walk_from_station ? $request->filter_walk_from_station : $filter_walk_from_station;
        }


        $key = $request->input('key');
        $location = $request->input('location');
        $category = $request->input('category');

        $search = array(
            'key' => $key,
            'location' => $location,
            'category' => $category
        );
        if ($request->isMethod('post')) {
            $tmpData = [
                'search' => $search,
                'filter_min_price' => $filter_min_price,
                'filter_max_price' => $filter_max_price,
                'filter_area' => $filter_area,
                'filter_age' => $filter_age,
                'filter_floor_plan' => $filter_floor_plan,
                'filter_walk_from_station' => $filter_walk_from_station
            ];
            $tmpData['request'] = json_encode($tmpData);
            session()->put('SEARCH', $tmpData);
        } elseif (session()->has('SEARCH')) {
            $tmpData = session()->get('SEARCH');
            $search = $tmpData['search'];
            $request = isset($tmpData['request']) ? (object)json_decode($tmpData['request'], true) : null;
            $key = $search['key'];
            $location = $search['location'];
            $category = $search['category'];
            $filter_min_price = $tmpData['filter_min_price'];
            $filter_max_price = $tmpData['filter_max_price'];
            $filter_area = $tmpData['filter_area'];
            $filter_age = $tmpData['filter_age'];
            $filter_floor_plan = $tmpData['filter_floor_plan'];
            $filter_walk_from_station = $tmpData['filter_walk_from_station'];
        }

        $resultSearch = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE") . ') as lang_title'),
            DB::raw('(SELECT translations.lang_content FROM translations, locations WHERE translations.post_id = locations.id and locations.id=products.location_id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME") . ') as lang_location'),
            'products.id as product_id'
        )
            ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->where('title', 'LIKE', "%$key%")
            ->where('products.location_id', 'LIKE', "%$location%")
            ->where('products.category_id', 'LIKE', "%$category%")
            ->where('price', '>=', $filter_min_price)
            ->where('price', '<=', $filter_max_price)
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
            ->paginate(Config::get('settings.LIMIT_SEARCH_PRODUCT'));

        return view("front.search")
            ->with('resultSearch', $resultSearch)
            ->with('isMethodPostSearch', true)
            ->with('search_from', 'search')
            ->with('request', $request)
            ->with('search', $search);
    }

    //search with category id
    public function search_category($id)
    {
        $filter_min_price = 0;
        $filter_max_price = 9999999999999;
        $filter_floor_plan = [];
        $filter_area = 0;
        $filter_walk_from_station = 0;
        $filter_age = 0;

        $new_products = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE") . ') as lang_title'),
            DB::raw('(SELECT translations.lang_content FROM translations, locations WHERE translations.post_id = locations.id and locations.id=products.location_id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME") . ') as lang_location')
        )
            ->where('products.status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('products.approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->where('price', '>=', $filter_min_price)
            ->where('price', '<=', $filter_max_price)
            ->where('category_id', $id)
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
            ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

        if (count($new_products) == 0) {
            return view("errors.categoryNotFound");
        }
        $category = Category::select('categories.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = categories.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME") . ') as lang_category')
        )
            ->where('id', $id)->first();
        return view("front.category")
            ->with('new_products', $new_products)
            ->with('categorys', $category);
    }

    public function addnew()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        if (@unserialize(Auth::user()->user_type)==true){
            if (!in_array(Config::get('settings.USER_TYPE.SELLER.code'), unserialize(Auth::user()->user_type))){
                return redirect()->route('home');
            }
        }

        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $group_id = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id) {
            $value = '';
            foreach ($floor as $fl) {
                if ($fl->group_id == $gr_id->group_id) {
                    $value = $value . ' ' . $fl->title;
                }

            }
            $group_id_arr[] = array('id' => $gr_id->group_id, 'title' => $value);
        }

        return view('front.addNewProduct')
            ->with('currencies', $currencies)
            ->with('floor', $floor)
            ->with('group_id_arr', $group_id_arr)
            ->with('active_product', '');
    }

    public function getRegion(Request $request)
    {
        $location_id = $request->location_id;
        $City = CityMaster::where('location_id', $location_id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $Route = RouteMaster::where('location_id', $location_id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $city_arr = array();
        foreach ($City as $ct) {
            $city_arr[] = array('id' => $ct->id, 'title' => $ct->title);
        }
        $route_arr = array();
        foreach ($Route as $rt) {
            $route_arr[] = array('id' => $rt->id, 'title' => $rt->title);
        }
        return $data = ['city_arr' => $city_arr, 'route_arr' => $route_arr];
    }

    public function getCity(Request $request)
    {
        $region_id = $request->region_id;
        $City = CityMaster::where('region_master_id', $region_id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $data = array();
        foreach ($City as $ct) {
            $data[] = array('id' => $ct->id, 'title' => $ct->title);
        }
        return $data;
    }

    public function getStation(Request $request)
    {
        $route_id = $request->route_id;
        $Station = StationNameMaster::where('route_master_id', $route_id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $data = array();
        foreach ($Station as $st) {
            $data[] = array('id' => $st->id, 'title' => $st->title);
        }
        return $data;
    }

    public function products()
    {
        if (Auth::check()) {
            if (@unserialize(Auth::user()->user_type)==true){
                if (!in_array(Config::get('settings.USER_TYPE.SELLER.code'), unserialize(Auth::user()->user_type))){
                    return redirect()->route('home');
                }
            }
            $products = Product::where('user_id', Auth::user()->id)
                ->where('user_type', Config::get('settings.TYPE_ACCOUNT.USER'))
                ->where('status', '<>', Config::get('settings.GLOBAL_STATUS.DELETED.code'))
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));
            return view('front.products')
                ->with('products', $products)->with('active_product', '');
        } else {
            return view('auth.login');

        }
    }

    //Create new product
    public function postAddNew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required|min:10|max:500',
            'content' => 'required|min:50',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city' => 'required',
            'location' => 'required',
            'time_walking' => 'required|numeric',
            'route' => 'required',
            'station' => 'required',
            'floor' => 'required',
            'area_used' => 'required|numeric',
            'address' => 'required|min:3',
        ]);
//        dd($validator->messages());
        if ($validator->passes()) {
            $complete_time = $request->year . '-' . $request->month . '-01';
            $product = new Product();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->address = $request->address;
            $product->content = $request->content;
            $product->category_id = $request->category;
            $product->city_master_id = $request->city;
            $product->group_floor = serialize($request->floor);
            $product->area_used = $request->area_used;
            $product->complete_time = date_create($complete_time);
            $product->user_id = Auth::user()->id;
            $product->currency_id = $request->currency;
            $product->location_id = $request->location;
            $product->save();

            $product_id = $product->id;

            $productTemp = new ProductTemp();
            $productTemp->product_id = $product_id;
            $productTemp->route_master_id = $request->route;
            $productTemp->station_name_id = $request->station;
            $productTemp->distance = $request->time_walking;
            $productTemp->location_id = $request->location;
            $productTemp->status = Config::get('settings.GLOBAL_STATUS.ENABLED.code');
            $productTemp->save();

            //insert product temp

            //insert languages

            $language = Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
            foreach ($language as $lang) {
                $name = $lang->short_name;
                $title = 'title_' . $name;
                $description = 'description_' . $name;
                $content = 'content_' . $name;
                $title_lang = $request->$title;
                $description_lang = $request->$description;
                $content_lang = $request->$content;

                if ($title_lang != '') {
                    Translation::create([
                        'lang_content' => $title_lang,
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'),
                    ]);
                }

                if ($description_lang != '') {
                    Translation::create([
                        'lang_content' => $description_lang,
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'),
                    ]);
                }

                if ($content_lang != '') {
                    Translation::create([
                        'lang_content' => $content_lang,
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'),
                    ]);
                }

            }

            //insert images
            $images = array();
            if ($files = $request->file('images')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $name = date('dmyHis') . $product_id . '_' . md5($name) . '.jpg';
                    $file->move('uploads/products/' . $product_id . '/', $name);
                    $images[] = $name;
                }
            }
            foreach ($images as $img) {
                $img = 'uploads/products/' . $product_id . '/' . $img;
                ProductImages::insert([
                    'path' => $img,
                    'product_id' => $product_id,
                    'status' => Config::get('settings.GLOBAL_STATUS.ENABLED.code')
                ]);
            }

//            return response()->json(['success' => 'success'], 200);
            return redirect('user/products');
        }
        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $region = RegionMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $city = CityMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $route = RouteMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $station = StationNameMaster::where('route_master_id', $request->route)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $group_id = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id) {
            $value = '';
            foreach ($floor as $fl) {
                if ($fl->group_id == $gr_id->group_id) {
                    $value = $value . ' ' . $fl->title;
                }

            }
            $group_id_arr[] = array('id' => $gr_id->group_id, 'title' => $value);
        }

        return view('front.addNewProduct')
            ->with('currencies', $currencies)
            ->with('floor', $floor)
            ->with('group_id_arr', $group_id_arr)
            ->with('active_product', '')
            ->with('request', $request->all())
            ->with('errors', $validator->messages())
            ->with('region', $region)
            ->with('route', $route)
            ->with('station', $station)
            ->with('city', $city);
//        return response()->json($validator->messages(),200);
    }

    //
    public function postAddProductTemp(Request $request)
    {
        $productTemp = new ProductTemp();
        $productTemp->product_id = $request->getProduct_id;
        $productTemp->route_master_id = $request->route;
        $productTemp->station_name_id = $request->station;
        $productTemp->distance = $request->time_walking;
        $productTemp->location_id = $request->getLocation_id;
        $productTemp->status = Config::get('settings.GLOBAL_STATUS.ENABLED.code');
        $productTemp->save();
    }

    //Delete ProductTemp

    public function postDeleteProductTemp(Request $request)
    {
        $del = ProductTemp::find($request->id);
        $del->delete();
    }

    // Update ProductTemp

    public function postUpdateProductTemp(Request $request)
    {
//        dd($request->all());
        ProductTemp::where('id', $request->id)
            ->update([
                'route_master_id' => $request->route,
                'station_name_id' => $request->station,
                'distance' => $request->time_walking
            ]);
    }

    //Edit product
    public function productEdit($id)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        if (@unserialize(Auth::user()->user_type)==true){
            if (!in_array(Config::get('settings.USER_TYPE.SELLER.code'), unserialize(Auth::user()->user_type))){
                return redirect()->route('home');
            }
        }
        $product = Product::where('id', $id)->first();
        $productTemp = ProductTemp::where('product_id', $id)->get();
        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $product_img = ProductImages::where('product_id', $id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $translations = Translation::where('post_id', $product->id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
            ->get();

        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $region = RegionMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $city = CityMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $route = RouteMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $station = StationNameMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();

        $group_id = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id) {
            $value = '';
            foreach ($floor as $fl) {
                if ($fl->group_id == $gr_id->group_id) {
                    $value = $value . ' ' . $fl->title;
                }

            }
            $group_id_arr[] = array('id' => $gr_id->group_id, 'title' => $value);
        }
        $getArrayFloor = @unserialize($product->group_floor) == true ? unserialize($product->group_floor) : array();
        return view('front.editProduct')
            ->with('product', $product)
            ->with('currencies', $currencies)
            ->with('product_img', $product_img)
            ->with('translations', $translations)
            ->with('floor', $floor)
            ->with('getArrayFloor', $getArrayFloor)
            ->with('region', $region)
            ->with('city', $city)
            ->with('route', $route)
            ->with('station', $station)
            ->with('group_id_arr', $group_id_arr)
            ->with('productTemp', $productTemp)
            ->with('active_product', '');
    }

    //delete images
    public function deleteImageProduct(Request $request)
    {


        $id = $request->id;
        $getImage = ProductImages::where('id', $id)->first();
        unlink($getImage->path);
        ProductImages::find($id)->delete($id);

    }

    public function addImage(Request $request)
    {


//        $id=$request->id;
//        $getImage=ProductImages::where('id',$id)->first();
//        unlink($getImage->path);
//        ProductImages::find($id)->delete($id);

    }

    public function postEditProduct(ProductsRequest $request, $id)
    {
        $complete_time = $request->year . '-' . $request->month . '-01';
        Product::where('id', $id)
            ->update([
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'address' => $request->address,
                'content' => $request->content,
                'category_id' => $request->category,
                'currency_id' => $request->currency,
                'location_id' => $request->location,
                'city_master_id' => $request->city,
                'group_floor' => serialize($request->floor),
                'complete_time' => date_create($complete_time),
                'area_used' => $request->area_used,
                'sold' => $request->sold
            ]);

        //insert images
        $product_id = $id;
        $language = Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang) {
            $name = $lang->short_name;
            $title = 'title_' . $name;
            $description = 'description_' . $name;
            $content = 'content_' . $name;
            $title_lang = $request->$title;
            $description_lang = $request->$description;
            $content_lang = $request->$content;
            //title
            if ($title_lang != '') {
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'),
                    ], [
                    'lang_content' => $title_lang,

                ]);
            } elseif ($title_lang == '') {
                Translation::where('post_id', $product_id)
                    ->where('lang_code', $name)
                    ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail', Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'))
                    ->delete();
            }
            // description
            if ($description_lang != '') {
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'),
                    ], [
                    'lang_content' => $description_lang,

                ]);
            } elseif ($description_lang == '') {
                Translation::where('post_id', $product_id)
                    ->where('lang_code', $name)
                    ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail', Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'))
                    ->delete();
            }

            // content
            if ($content_lang != '') {
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code' => $name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'),
                    ], [
                    'lang_content' => $content_lang,

                ]);
            } elseif ($content_lang == '') {
                Translation::where('post_id', $product_id)
                    ->where('lang_code', $name)
                    ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail', Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'))
                    ->delete();
            }
        }
        $images = array();
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $name = date('dmyHis') . $product_id . '_' . md5($name) . '.jpg';
                $file->move('uploads/products/' . $product_id . '/', $name);
                $images[] = $name;
            }
        }
        foreach ($images as $img) {
            $img = 'uploads/products/' . $product_id . '/' . $img;
            ProductImages::insert([
                'path' => $img,
                'product_id' => $product_id,
                'status' => Config::get('settings.GLOBAL_STATUS.ENABLED.code')
            ]);
        }
        Session::flash('success', 'Update successfully!');
        return redirect()->route('productEdit', ['id' => $id])->with('active_product', '');
    }

    public function productDelete($id)
    {
        Product::where('id', $id)
            ->update([
                'status' => Config::get('settings.GLOBAL_STATUS.DELETED.code'),
            ]);
        return redirect()->back();
    }
}
