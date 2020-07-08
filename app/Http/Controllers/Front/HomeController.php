<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Config;
use App\Models\Product;
use Illuminate\Support\Facades\App;


class HomeController extends Controller
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
            ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->orderBy('created_at', 'desc')
            ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

        // Get the list categories
        // Get the
        $product_hot = Product::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
            ->where('hot', Config::get('settings.HOT_PRODUCT.HOT.code'))
            ->orderBy('created_at', 'desc')
            ->take(Config::get('settings.GET_TAKE_10_PROD'))
            ->get();

        return view('front.index')
            ->with('new_products', $new_products)
            ->with('product_hot', $product_hot);

    }
}
