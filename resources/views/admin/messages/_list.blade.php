<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.message.count', $messages->total()) }}</caption>
        <thead>
        <tr>
            <th>{{ __('admin.message.productTitle') }}</th>
            <th>From</th>
            <th>To</th>
            <th>{{ __('admin.message.reply') }}</th>
            <th>{{ __('admin.message.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($messages as $message)
            @if($message->products['status']==Config::get('settings.GLOBAL_STATUS.ENABLED.code') && $message->products['approve']==Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                <tr>
                    <td>{{ $message->products['title'] }}</td>
                    <td>{{ $message->users['name'] }}</td>
                    <td>{{ $message->user_to['name'] }}</td>
                    <td>
                        @php
                            $reply_id = $message->reply_id;
                            $countReply = array();
                            $replyApprove=array();
                        foreach($total_message as $total){
                            if($total->reply_id == $reply_id){
                                $countReply[]=$total->reply_id ;
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
                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
</div>
