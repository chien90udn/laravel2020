<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategorysRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Config;


class OrdersController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $languages=Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        \Illuminate\Support\Facades\View::share('languages',$languages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::latest()->paginate(10)
        ]);
    }

    
}
