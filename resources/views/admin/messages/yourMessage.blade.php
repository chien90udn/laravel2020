@extends('layouts.admin')
@section('breadcrumb', __('admin.message.manageYourMess'))
@section('content')
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.message.list') }}</h3>
        </div>
        <div class="box ">
            <div class="box-body">
                <table class="table table-bordered">
                    <caption>{{ trans_choice('admin.message.count', $messages->total()) }}</caption>
                    <thead>
                    <tr>
                        <th>{{ __('admin.message.user') }}</th>
                        <th>{{ __('admin.message.email') }}</th>
                        <th>{{ __('admin.message.reply') }}</th>
                        <th>{{ __('admin.message.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->user_to->name }}</td>
                                <td>{{ $message->user_to->email }}</td>
                                <td>
                                    @php
                                        $user_id= $message->user_id_to;
                                        $countReply=array();
                                        $replyApprove=array();
                                    foreach($total_message as $total){
                                        if($total->user_id_from == $user_id || $total->user_id_to == $user_id){
                                            $countReply[]=$total->id ;
                                            if($total->approve == Config::get('setting.GLOBAL_APPROVE.DISABLED.code')){
                                                $replyApprove[]=$total->approve;
                                            }
                                        }
                                    }
                                    @endphp
                                    {{ count($countReply) }}
                                    @if(count($replyApprove)>Config::get('settings.ID_MESSAGES_REPLY_DEFAULT') || $message->approve == Config::get('setting.GLOBAL_APPROVE.DISABLED.code'))
                                        <i class="fa fa-circle fa-circle-shadow"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.yourMessageDetail', ['user_id'=>$user_id ]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
