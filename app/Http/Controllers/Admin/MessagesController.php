<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MessagesRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class MessagesController extends Controller
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
        $messages=Message::where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.USER'))
            ->where('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.USER'))
            ->whereNotNull('product_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $total_message=Message::where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.USER'))
            ->where('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.USER'))
            ->get();
        return view('admin.messages.index', [
            'messages' => $messages,
            'total_message' => $total_message,
        ]);
    }

    /* Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        $messages=Message::where(function ($query) {
            $query->where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
                ->orWhere('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'));
            })
            ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $total_message=Message::where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
            ->orWhere('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
            ->get();
        return view('admin.messages.create', [
            'messages' => $messages,
            'total_message' => $total_message,
        ]);
    }

    /**
     * View your contact list.
     */

    public function yourContact()
    {
        $messages=Message::where('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
            ->whereNotNull('product_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $total_message=Message::where('reply_id','<>', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->where(function ($query) {
                $query->where('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
                    ->orWhere('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'));
            })
            ->get();
        return view('admin.messages.yourContact', [
            'messages' => $messages,
            'total_message' => $total_message,
        ]);
    }

    public function contactDetail(Request $request){
        $product_id=$request->id;
        $reply_id=$request->reply_id;
        $messages=Message::where('reply_id',$reply_id)
            ->get();
        $prod_info=Product::where('id', $product_id)->first();
        //update approve
        Message::where('reply_id',$reply_id)
            ->update(['approve'=>Config::get('settings.GLOBAL_APPROVE.ENABLED.code')]);

        $user=Message::where('reply_id',$reply_id)
            ->whereNotNull("product_id")
            ->first();
//        dd($user);
        return view('admin.messages.contactDetail',[
           'messages'=>$messages,
            'user' => $user,
            'reply_id' => $reply_id,
            'product_id' => $product_id,
            'prod_info'  => $prod_info
        ]);
    }

    public function replyContact(Request $request){
        $content=$request->content;
        $product_id=$request->product_id;
        $user_id=$request->user_id;
        $reply_id=$request->reply_id;
        $message = new Message();
        $message->content = $content;
        $message->product_id = $product_id;
        $message->user_id_from=Auth::guard('admin')->user()->id;
        $message->user_id_to=$user_id;
        $message->user_id_from_type=Config::get('settings.TYPE_ACCOUNT.ADMIN');
        $message->approve=Config::get('settings.GLOBAL_APPROVE.ENABLED.code');
        $message->reply_id=$reply_id;
        $message->save();
    }


    public function yourMessage()
    {

        $messages=Message::where('user_id_from',Auth::guard('admin')->user()->id)
            ->where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.ADMIN'))
            ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

        $total_message=Message::where(function ($query) {
            $query->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                ->orWhere('reply_id', Config::get('settings.MESSAGES_SENT_TO_ADMIN'));
        })
            ->get();

        return view('admin.messages.yourMessage', [
            'messages' => $messages,
            'total_message' => $total_message
        ]);
    }

    public function newMessage(Request $request)
    {
        $user_id=$request->user_id;
        $check_message=Message::whereNull('product_id')
            ->where('reply_id',Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->where('user_id_to',$user_id)
            ->first();
        if(isset($check_message)){
            return redirect()->action('Admin\MessagesController@yourMessageDetail', ['id'=>$check_message->id,'reply_id'=>$user_id]);
        }else{
            $user=User::where('id', $user_id)->first();
            return view('admin.messages.newMessage', [
                'user'  => $user,
                'user_id' => $user_id,
            ]);
        }


    }

    public function yourMessageDetail(Request $request)
    {

        $user_id = $request->user_id; //id message
        Message::where('user_id_from', $user_id)
            ->orWhere('user_id_to', $user_id)
            ->update(['approve' => Config::get('settings.GLOBAL_APPROVE.ENABLED.code')]);
        $check_message = Message::where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
            ->where('user_id_to', $user_id)
            ->first();
        if (!$check_message) {
            return redirect()->action('Admin\MessagesController@newMessage', ['user_id' => $user_id]);
        }


        $messages = Message::where(function ($query) {
            $query->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                ->orWhere('reply_id', Config::get('settings.MESSAGES_SENT_TO_ADMIN'));
        })
            ->where(function ($query) use ($user_id){
                $query->where('user_id_from', $user_id)
                    ->orWhere('user_id_to', $user_id);
            })
            ->get();
        $user = User::where('id', $user_id)->first();
        return view('admin.messages.yourMessageDetail', [
            'messages' => $messages,
            'user' => $user
        ]);

    }


    public function sentMessageAdminNew(Request $request){

        $content=$request->content;
        $user_id=$request->user_id;

        $message = new Message();
        $message->content = $content;
        $message->user_id_from=Auth::guard('admin')->user()->id;
        $message->user_id_to=$user_id;
        $message->user_id_from_type=Config::get('settings.TYPE_ACCOUNT.ADMIN');
        $message->approve=Config::get('settings.GLOBAL_APPROVE.ENABLED.code');
        $message->save();



    }

    public function sentMessageAdmin(Request $request){
        $content=$request->content;
        $user_id=$request->user_id;
//        $reply_id=$request->reply_id;
        $message = new Message();
        $message->content = $content;
        $message->user_id_from=Auth::guard('admin')->user()->id;
        $message->user_id_to=$user_id;
        $message->user_id_from_type=Config::get('settings.TYPE_ACCOUNT.ADMIN');
        $message->approve=Config::get('settings.GLOBAL_APPROVE.ENABLED.code');
        $message->reply_id=Config::get('settings.MESSAGES_SENT_TO_ADMIN');
        $message->save();

    }


     /**
     * Store a newly created resource in storage.
     */
    public function store(MessagesRequest $request): RedirectResponse
    {
        return redirect()->route('admin.messages.index')->withSuccess(__('message.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message): View
    {

        $messages=Message::where('reply_id', $message->reply_id)
            ->latest()
            ->paginate(10);
        return view('admin.messages.show', [
            'message' => $message,
            'messages' => $messages
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message): View
    {
        return view('admin.messages.edit', [
            'message' => $message
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $message
     * @return \Illuminate\Http\Response
     */
    public function update(MessagesRequest $request, Message $message): RedirectResponse
    {
        if ($request->filled('password')) {
            $request->merge([
                'password' => Hash::make($request->input('password'))
            ]);
        }
        $message->update(array_filter($request->only(['name', 'email', 'password', 'status'])));
        return redirect()->route('admin.messages.edit', $message)->withSuccess(__('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->withSuccess(__('message.deleted'));
    }



    //Update message status
    public function updateApproveMessage(Request $request){
        $id=$request->messId;
        Message::where('id', $id)
            ->update(['approve' => Config::get('settings.GLOBAL_APPROVE.ENABLED.code')]);
        return redirect()->back();
    }
}
