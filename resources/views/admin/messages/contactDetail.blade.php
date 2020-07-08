@extends('layouts.admin')
@section('breadcrumb', __('admin.message.manageYourContact'))
@section('content')
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.message.contact') }}</h3>
        </div>
        <div class="box ">
            <div class="box-body">
                <caption>
                     <a target="_blank" href="{{ route('admin.products.show', $prod_info->id) }}">{{ $prod_info->title }}</a>
                </caption>

                <hr style="border-top: 1px solid #8aa4af;">
                <div class="col-sm-12" id="message-box">
                    @foreach($messages as $message)
                        @if($message->user_id_from ==Auth::guard('admin')->user()->id && $message->user_id_from_type == 1)
                            <p style="text-align: right">{{ $message->content }}</p>
                        @else
                            <p style="text-align: left"><strong><a target="_blank" href="{{route('admin.users.show',$user->id)}}">{{$user->name}}:</a> </strong>{{ $message->content }}</p>
                        @endif
                    @endforeach

                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="content" autofocus>
                    <input type="hidden" value="{{ $user->id }}" id="user_id">
                    <input type="hidden" value="{{ $reply_id }}" id="reply_id">
                    <input type="hidden" value="{{ $product_id }}" id="product_id">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" id="replyContact">
                            <i class="glyphicon glyphicon-send"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
