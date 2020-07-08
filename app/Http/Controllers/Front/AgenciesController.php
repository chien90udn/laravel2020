<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgenciesController extends Controller
{
    public function index(){
        return view('front.agencies.index');
    }
}
