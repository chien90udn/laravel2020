<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Config;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


class UsersController extends Controller
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

    public function profile(){
        if (Auth::check()) {
            return view('front.profile')->with('active_profile','');
        } else {
            return view('auth.login');

        }
    }
    public function changeProfile(Request $request){
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'You must enter your name',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            User::where('id', Auth::user()->id)
                ->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone
                ]);
            Session::flash('success', 'Update successfully!');
            return redirect()->route('profile')->with('active_profile','');
        }
    }

    public function messages(){

    }


    //Change password
    public function password(){
        return view("front.changePassword")->with('active_password','');
    }

    public function changePassword(Request $request){

        $request->validate([
            'current_pass' => ['required', new MatchOldPassword],
            'new_pass' => ['required'],
            'confirm_new_pass' => ['same:new_pass'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_pass)]);

        Session::flash('success', 'Update successfully!');
        return redirect()->route('password')->with('active_profile','');

    }

}
