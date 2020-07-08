<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CurrenciesRequest;
use App\Http\Requests\Admin\ProductsRequest;
use App\Models\Category;
use App\Models\CityMaster;
use App\Models\Currency;
use App\Models\FloorPlanMaster;
use App\Models\Language;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductTemp;
use App\Models\RegionMaster;
use App\Models\RouteMaster;
use App\Models\StationNameMaster;
use App\Models\Translation;
use App\Models\User;
use App\Models\ViewedProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Config;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');

    }

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $group_id=FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id){
            $value = '';
            foreach ($floor as $fl){
                if($fl -> group_id == $gr_id -> group_id){
                    $value = $value.' '.$fl->title;
                }

            }$group_id_arr[] = array('id' => $gr_id -> group_id, 'title' => $value);
        }
        return view('admin.products.create')
            ->with('currencies', $currencies)
            ->with('floor', $floor)
            ->with('group_id_arr', $group_id_arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required|min:10|max:500',
            'content' => 'required|min:50',
            'picture.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city' =>'required',
            'location' =>'required',
            'time_walking' =>'required|numeric',
            'route' =>'required',
            'station' =>'required',
            'floor' =>'required',
            'area_used' =>'required|numeric',
            'address' => 'required|min:3',
        ]);
        if ($validator->passes()) {
            $complete_time = $request->year.'-'.$request->month.'-01';
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
            $product->user_id = Auth::guard('admin')->user()->id;
            $product->user_type = Config::get('settings.TYPE_ACCOUNT.ADMIN');
            $product->currency_id = $request->currency;
            $product->location_id = $request->location;
            $product->hot = $request->hot;
            $product->approve = Config::get('settings.GLOBAL_APPROVE.ENABLED.code');
            $product->status = Config::get('settings.GLOBAL_STATUS.ENABLED.code');
            $product->save();

            $product_id = $product->id;

            //insert translations

            $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
            foreach ($language as $lang){
                $name=$lang->short_name;
                $title='title_'.$name;
                $description='description_'.$name;
                $content='content_'.$name;
                $title_lang=$request->$title;
                $description_lang=$request->$description;
                $content_lang=$request->$content;

                if($title_lang!=''){
                    Translation::create([
                        'lang_content' => $title_lang,
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'),
                    ]);
                }

                if($description_lang!=''){
                    Translation::create([
                        'lang_content' => $description_lang,
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'),
                    ]);
                }

                if($content_lang!=''){
                    Translation::create([
                        'lang_content' => $content_lang,
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'),
                    ]);
                }

            }

            // upload & insert images
            $images = array();
            if ($files = $request->file('picture')) {
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

            return redirect()->route('admin.products.index')->withSuccess(__('product.created'));
        }
//        dd($request->location);
        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $region = RegionMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $city = CityMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $route = RouteMaster::where('location_id', $request->location)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $station = StationNameMaster::where('route_master_id', $request->route)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $group_id=FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id){
            $value = '';
            foreach ($floor as $fl){
                if($fl -> group_id == $gr_id -> group_id){
                    $value = $value.' '.$fl->title;
                }

            }$group_id_arr[] = array('id' => $gr_id -> group_id, 'title' => $value);
        }

//        dd($group_id_arr);
        return view('admin.products.create')
            ->with('currencies', $currencies)
            ->with('floor', $floor)
            ->with('group_id_arr', $group_id_arr)
            ->with('request', $request->all())
            ->with('errors', $validator->messages())
            ->with('region', $region)
            ->with('route', $route)
            ->with('station', $station)
            ->with('city', $city);
    }

    /**
     * Display the specified resource.
     *
     * @param obj $location
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product): View
    {
        $id=$product->id;
        $images = ProductImages::where('product_id', $id)
            ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->get();
        $productTemp = ProductTemp::where('product_id',$id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $category = Category::select('categories.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = categories.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME") . ') as lang_category')
        )
            ->where('id', $product->category_id)->first();

        $user=User::where('id',$product->user_id)->first();
        $products = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE").') as lang_title')
        )->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->where('id', '<>', $id)
            ->where('category_id', $product->category_id)
            ->orderBy('id', 'DESC')
            ->take(Config::get('settings.GET_TAKE_10_PROD'))
            ->get();

        $group_floor =  @unserialize($product->group_floor) == true ? unserialize($product->group_floor) : array();
        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $group_id_val = "";

        foreach ($group_floor as $key => $val){
            foreach ($floor as $fl){
                if($val == $fl['id']){
                    $group_id_val= $group_id_val.' '.$fl['title'];
                }
            }
        }
        $group_id_val=$group_id_val.' <br>';


        return view('admin.products.show', [
            'product' => $product,
            'images' => $images,
            'productTemp' => $productTemp,
            'products'=> $products,
            'group_id_val' => ltrim($group_id_val, '<br>'),
            'user' => $user,
            'category' => $category

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param obj $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        $id = $product->id;
        $product = Product::where('id', $id)->first();
        $productTemp = ProductTemp::where('product_id', $id)->get();
        $currencies = Currency::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $images = ProductImages::where('product_id', $id)
            ->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->get();
        $translations = Translation::where('post_id', $id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
            ->get();

        $floor = FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $region = RegionMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $city = CityMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $route = RouteMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        $station = StationNameMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();

        $group_id=FloorPlanMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->distinct()->get(['group_id']);
        $group_id_arr = array();
        foreach ($group_id as $gr_id){
            $value = '';
            foreach ($floor as $fl){
                if($fl -> group_id == $gr_id -> group_id){
                    $value = $value.' '.$fl->title;
                }

            }$group_id_arr[] = array('id' => $gr_id -> group_id, 'title' => $value);
        }
        $getArrayFloor = @unserialize($product -> group_floor)==true?unserialize($product -> group_floor):array();
        return view('admin.products.edit', [
            'product' => $product,
            'currencies' => $currencies,
            'images' => $images,
            'translations' => $translations,
            'floor' => $floor,
            'getArrayFloor' => $getArrayFloor,
            'region' => $region,
            'city' => $city,
            'route' => $route,
            'station' => $station,
            'group_id_arr' => $group_id_arr,
            'productTemp' => $productTemp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param obj $location
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        $complete_time = $request->year.'-'.$request->month.'-01';
        Product::where('id', $id)
            ->update([
                'title' => $request->title,
                'price' => $request->price,
                'address' => $request->address,
                'currency_id' => $request->currency,
                'category_id' => $request->category,
                'description' => $request->description,
                'location_id' => $request->location,
                'content' => $request->content,
                'sold' => $request->sold,
                'hot' => $request->hot,
                'city_master_id' => $request->city,
                'group_floor' => serialize($request->floor),
                'complete_time' => date_create($complete_time),
                'area_used' => $request->area_used
            ]);



        $product_id = $id;
        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            $title='title_'.$name;
            $description='description_'.$name;
            $content='content_'.$name;
            $title_lang=$request->$title;
            $description_lang=$request->$description;
            $content_lang=$request->$content;
            //title
            if($title_lang!=''){
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'),
                    ],[
                    'lang_content' => $title_lang,

                ]);
            }elseif($title_lang==''){
                Translation::where('post_id',$product_id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE'))
                    ->delete();
            }
            // description
            if($description_lang!=''){
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'),
                    ],[
                    'lang_content' => $description_lang,

                ]);
            }elseif($description_lang==''){
                Translation::where('post_id',$product_id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION'))
                    ->delete();
            }

            // content
            if($content_lang!=''){
                Translation::updateOrCreate(
                    [
                        'post_id' => $product_id,
                        'lang_code'   =>$name,
                        'lang_type' => Config::get('settings.TYPE_LANGUAGE.PRODUCT'),
                        'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'),
                    ],[
                    'lang_content' => $content_lang,

                ]);
            }elseif($content_lang==''){
                Translation::where('post_id',$product_id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.PRODUCT'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT'))
                    ->delete();
            }
        }

        $images = array();
        if ($files = $request->file('picture')) {
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

        return redirect()->route('admin.products.edit', $id)->withSuccess(__('product.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param obj $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->withSuccess(__('product.deleted'));
    }


    public function updateApprove(Request $request)
    {
        $approve = $request->approve;
        $id = $request->productId;
        Product::where('id', $id)
            ->update(['approve' => $approve]);
        return redirect()->back();
    }

    public function updateHot(Request $request)
    {
        $hot = $request->hot;
        $id = $request->productId;
        Product::where('id', $id)
            ->update(['hot' => $hot]);
        return redirect()->back();
    }
}
