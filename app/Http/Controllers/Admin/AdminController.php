<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UsersRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Response;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');

    }
    public function index()
    {
        return view('/admin/index');
    }

    public function profile(){
        return view('/admin/profile');
    }

    public function changePassword(ChangePasswordRequest $request){
        Admin::find( Auth::guard('admin')->user()->id)->update(['password'=> Hash::make($request->new_pass)]);
        Session::flash('success', 'Change successfully!');
        return redirect()->route('admin.profile');

    }


}
