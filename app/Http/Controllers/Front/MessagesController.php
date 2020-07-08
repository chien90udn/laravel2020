<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Config;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
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
    public function getMessages(){
            $sents = Message::where('user_id_from', Auth::user()->id)
//                ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                ->where('user_id_from_type',Config::get('settings.TYPE_ACCOUNT.USER'))
                ->whereNotNull('product_id')
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

            $receiveds = Message::where('user_id_to', Auth::user()->id)
                ->where('approve', Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
//                ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                ->where('user_id_to_type',Config::get('settings.TYPE_ACCOUNT.USER'))
                ->whereNotNull('product_id')
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('settings.LIMIT_NEW_PRODUCT'));

            $check_message=Message::where('user_id_to',Auth::user()->id)
                ->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                ->first();
//            dd($check_message);
            if(isset($check_message)){
                $received_from_admin=Message::where(function ($query) {
                    $query->where('user_id_from',Auth::user()->id)
                        ->orWhere('user_id_to',Auth::user()->id);
                })
                    ->where(function ($query1) {
                        $query1->where('reply_id', Config::get('settings.ID_MESSAGES_REPLY_DEFAULT'))
                            ->orWhere('reply_id',Config::get('settings.MESSAGES_SENT_TO_ADMIN'));
                    })
                    ->get();
            }else{
                $received_from_admin='';
            }

            return view('front.messages')
                ->with('sents', $sents)
                ->with('receiveds', $receiveds)
                ->with('received_from_admin', $received_from_admin)
                ->with('active_message','');
    }

    public function messageDetail(Request $request)
    {
        $product_id = $request->product_id;
        $reply_id = $request->reply_id;
        $type=$request->type;
        $arr_get_link=[
            'type' =>$type,
            'reply_id' => $reply_id,
            'product_id' => $product_id,
        ];
        $product = Product::select('products.*',
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_TITLE").') as lang_title'),
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_CONTENT").') as lang_content'),
            DB::raw('(SELECT translations.lang_content FROM translations WHERE translations.post_id = products.id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.PRODUCT_DESCRIPTION").') as lang_description'),
            DB::raw('(SELECT translations.lang_content FROM translations, locations WHERE translations.post_id = locations.id and locations.id=products.location_id and translations.lang_code = "'.App::getLocale().'" AND translations.lang_type_detail = '.Config::get("settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME").') as lang_location')
        )->where('id', $product_id)->first();
        $images = ProductImages::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))
            ->where('product_id', $product_id)
            ->get();
        $messages = Message::where('reply_id', $reply_id)
            ->get();

//        dd($messages);
//        $message=Message::where()
        return view('front.messagesDetail')
            ->with('product',$product)
            ->with('messages', $messages)
            ->with('images',$images)
            ->with('arr_get_link', $arr_get_link)
            ->with('active_message','');
    }

    public function replyMessage(Request $request){
        $product_id = $request->product_id;
        $reply_id = $request->reply_id;
        $type=$request->type;
        $product=Product::where('id',$product_id)->first();
        $user_type=$product->user_type;

        $arr_get_link=[
            'type' =>$type,
            'product_id'=>$product_id,
            'reply_id'=>$reply_id
        ];
//        $getProduct=Product::where('id',$product_id)->first();
        $user_id_from=Auth::user()->id;
        $getmessage=Message::where('reply_id', $reply_id)
            ->whereNotNull('product_id')
            ->first();

        if($type=='sent'){
            $user_id_to=$getmessage->user_id_to;
        }else{
            $user_id_to=$getmessage->user_id_from;
        }
        $content=$request->input('content_mess');

        $messages = new Message();
        $messages->content = $content;
//        $messages->product_id = $product_id;
        $messages->user_id_from=$user_id_from;
        $messages->user_id_to=$user_id_to;
        $messages->user_id_to_type=$user_type;
        $messages->reply_id=$reply_id;
        $messages->save();



    }


    //Reply message from admin

    public function replyMessageAdmin(Request $request){
        $user_id_to=$request->id_admin;
        $user_id_to_type=1;
        $content=$request->content;

        $messages = new Message();
        $messages->content = $content;
        $messages->user_id_from=Auth::user()->id;
        $messages->user_id_to=$user_id_to;
        $messages->approve=Config::get('settings.GLOBAL_APPROVE.DISABLED.code');
        $messages->reply_id=Config::get('settings.MESSAGES_SENT_TO_ADMIN');
        $messages->user_id_to_type=$user_id_to_type;
        $messages->save();

    }
}
