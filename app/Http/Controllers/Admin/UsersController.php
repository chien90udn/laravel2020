<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class UsersController extends Controller
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
        $users=User::latest()->paginate(10);
        $messages=Message::whereNull('product_id')
            ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->get();
        return view('admin.users.index', [
            'users' => $users,
            'messages'=>$messages

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.users.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request): RedirectResponse
    {
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'status'    => $request->status,
        ]);
        return redirect()->route('admin.users.index')->withSuccess(__('user.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, User $user): RedirectResponse
    {
//        if ($request->filled('password')) {
//            $request->merge([
//                'password' => Hash::make($request->input('password'))
//            ]);
//        }
//        $user->update(array_filter($request->only(['name', 'email', 'password', 'status'])));
        User::find($user->id)->update(['status'=>$request->status, 'user_type'=>serialize($request->user_type)]);
//        $user->update(array_filter($request->only(['status'])));
        return redirect()->route('admin.users.edit', $user)->withSuccess(__('user.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->withSuccess(__('user.deleted'));
    }
}
