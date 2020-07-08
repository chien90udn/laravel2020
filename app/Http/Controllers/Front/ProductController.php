<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProductRequest;
use App\Models\Category;
use App\Models\FloorPlanMaster;
use App\Models\Message;
use App\Models\ProductImages;
use App\Models\ProductTemp;
use App\Models\ViewedProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Config;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;


class ProductController extends Controller
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
        // Get the latest product

        $new_products = Product::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
                        ->orderBy('created_at', 'desc')
                        ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

        return view('front.index')
                ->with('new_products', $new_products);
    }

    //Get product detail
    public  function detail($id){
        $product = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE").') as lang_title'),
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT").') as lang_content'),
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION").') as lang_description'),
            DB::raw('(SELECT translations.lang_content FROM translations, locations WHERE translations.post_id = locations.id and locations.id=products.location_id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME").') as lang_location')
        )->where('id', $id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->first();
        $productTemp = ProductTemp::where('product_id',$id)->where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        if(!$product){
            return view("errors.productNotFound");
        }
        $category = Category::select('categories.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = categories.id and translations.lang_code = "' . App::getLocale() . '" AND translations.lang_type_detail = ' . Config::get("settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME") . ') as lang_category')
        )
            ->where('id', $product->category_id)->first();
        $user=User::where('id',$product->user_id)->first();
        if(Auth::check()){
            $message=Message::where('product_id',$id)->where('user_id_from', Auth::user()->id)->get();
            $message=count($message);

            $viewedpData = ViewedProduct::firstOrNew(
                ['product_id' => $id, 'user_id' => Auth::user()->id]
            );
            $viewedpData->updated_at = date('Y-m-d H:i:s');
            $viewedpData->save();
        }else{
            $message="";
        }
        $images=ProductImages::where('product_id',$id)->where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
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
        if ($products) {
            return view("front.detail")
                ->with('product', $product)
                ->with('productTemp', $productTemp)
                ->with('products', $products)
                ->with('message', $message)
                ->with('group_id_val', ltrim($group_id_val, '<br>'))
                ->with('user',$user)
                ->with('images',$images)
                ->with('category',$category);
        } else {
            return "Product deleted";
        }
    }
    public function send_contact(ProductRequest $request, $id)
    {

            $product=Product::where('id',$id)->first();
            $user_type=$product->user_type;

            $messages = new Message();
            $messages->name = $request->name;
            $messages->email = $request->email;
            $messages->phone = $request->phone;
            $messages->content = $request->content;
            $messages->product_id=$id;
            $messages->user_id_from=Auth::user()->id;
            $messages->user_id_to=$request->id_to;
            $messages->user_id_to_type=$request->user_type;
            $messages->reply_id=Config::get('settings.ID_MESSAGES_REPLY_DEFAULT');
            $messages->save();

            $message_repUpdate = Message::find($messages->id);
            $message_repUpdate->reply_id=$messages->id.Auth::user()->id;
            $message_repUpdate->save();

            $errors = new MessageBag(['sendSuccess' => 'Send successfully!']);
            return redirect()->back()->withInput()->withErrors($errors);
    }
}
