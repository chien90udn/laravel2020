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
use Mail;
use App\Models\Order;
use App\Mail\SendContactOrder;


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
        Order::create([
            'order_name' => $request->order_name,
            'order_phone' => $request->order_phone,
            'order_address' => $request->order_address,
            'order_product' => $request->order_product,
            'order_comment' => $request->order_comment,
        ]);
        Mail::to(env('MAIL_DRIVER', "chien90udn@gmail.com"))->send(new SendContactOrder($request));
        return redirect()->route('orderSuccess');
    }

    public function orderSuccess()
    {
        return view('front.orderSuccess');
    }
}
