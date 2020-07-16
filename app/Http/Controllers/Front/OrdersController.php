<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OrderRequest;
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


class OrdersController extends Controller
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

    public function order(OrderRequest $request)
    {

        
        return redirect()->route('orderSuccess');
    }

    public function orderSuccess()
    {
        return view('front.orderSuccess');
    }
}
