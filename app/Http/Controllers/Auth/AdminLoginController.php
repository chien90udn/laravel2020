<?php
namespace App\Http\Controllers\Auth;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = 'admin';
    protected $redirectTo = '/';
    public function __construct()
    {
        parent::__construct();
    }
    public function showLoginForm()
    {
        return view('auth.adminLogin');
    }
    public function guard()
    {
        return auth()->guard('admin');
    }
    public function showRegisterPage()
    {
        return view('auth.adminregister');
    }
    public function register(Request $request)
    {

        $request->validate([
            'name'      => 'required|string|max:199',
            'email'     => 'required|string|email|max:255|unique:admins',
            'password'  => 'required|string|min:6|confirmed'
        ]);
        Admin::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'status'    => Config::get('settings.GLOBAL_STATUS.ENABLED.code'),
        ]);
        return redirect()->route('admin-login')->with('success',trans('Registration Success'));
    }
    public function login(Request $request)
    {
        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password ])) {
            return redirect()->route('admin.index');
        }
        return back()->withErrors(['email' => trans('Email or password are wrong')]);
    }
}
