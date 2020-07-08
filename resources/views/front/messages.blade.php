@extends('layouts.front')

@section('styles')
    {{--styles--}}
@endsection

@section('content')

    <div class="center" id="hlcenter" style="; border: none;">
        <div id="container" class="w-clear">
            <div class="row" style="margin-right: -5px;margin-left: -5px;">
                @include('front.element.menuProfile')
                <div class="col-md-10" id="halink-right" style="padding-left: 5px;padding-right: 5px;">
                    <input type="hidden" value="" id="crp">
                    <div class="main-tit">
                        <h2>{{ __('front.Messages') }}</h2>
                    </div>
                    <ul class="nav nav-tabs" style="margin-left: 0px;" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#sent">{{ __('front.Sent') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#received">{{ __('front.Received') }}</a>
                        </li>
                        @if($received_from_admin!='')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" id="formAdminclick" href="#fromAdmin">{{ __('front.From admin') }}</a>
                            </li>
                        @endif
                    </ul>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="sent" class="tab-pane active"><br>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th style="min-width:150px;" class="hidden-xs">{{ __('front.Product name') }}</th>
                                                <th style="max-width:70px;" class="hidden-xs">{{ __('front.Detail') }}</th>
                                            </tr>
                                            @foreach($sents as $sent)
                                                @php
                                                    if($sent->user_id_to_type==Config::get('settings.TYPE_ACCOUNT.USER')){
                                                        $user_id_to=$sent->user_id_to;
                                                    }else{
                                                        $user_id_to=$sent->user_id_from;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{$sent->products->title}}</td>
                                                    <td align="center">
                                                        <a href="{{ route('messageDetail',['type'=>'sent', 'reply_id'=>$sent->reply_id,'product_id'=>$sent->product_id]) }}">
                                                            <i class="fa fa-comments"
                                                               style="font-size:24px;color:red"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="received" class="tab-pane fade"><br>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th style="min-width:150px;" class="hidden-xs">{{ __('front.Product name') }}</th>
                                                <th style="min-width:150px;" class="hidden-xs">{{ __('front.Name') }}</th>
                                                <th style="min-width:150px;" class="hidden-xs">{{ __('front.Email') }}</th>
                                                <th style="width:50px;" class="hidden-xs">{{ __('front.Detail') }}</th>
                                            </tr>
                                            @foreach($receiveds as $received)
                                                <tr>
                                                    <td>{{$received->products->title}}</td>
                                                    <td>{{$received->users->name}}</td>
                                                    <td>{{$received->email}}</td>
                                                    <td align="center">
                                                        <a href="{{route('messageDetail',['type'=>'received','reply_id'=>$received->reply_id,'product_id'=>$received->product_id])}}">
                                                            <i class="fa fa-comments"
                                                               style="font-size:24px;color:red"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($received_from_admin!='')
                                        <div id="fromAdmin" class="tab-pane fade"><br>
                                            <div id="dynamic_field">
{{--                                                {{dd($received_from_admin)}}--}}
                                                @foreach($received_from_admin as $fromAdmin)
{{--                                                    @php--}}
{{--                                                        if($fromAdmin->reply_id == Config::get('settings.ID_MESSAGES_REPLY_DEFAULT')){--}}
{{--                                                            $reply_id=$fromAdmin->id.$fromAdmin->user_id_to;--}}
{{--                                                            $id=$fromAdmin->admins->id;--}}
{{--                                                        }--}}
{{--                                                    @endphp--}}
                                                    @if($fromAdmin->user_id_from == Auth::user()->id && $fromAdmin->user_id_from_type==Config::get('settings.TYPE_ACCOUNT.USER') )
                                                        <p colspan="2" align="right">
                                                            {{ $fromAdmin->content }}<br>
                                                            <small style="color: red">
                                                                <i>
                                                                    @if($fromAdmin->approve == Config::get('settings.GLOBAL_APPROVE.DISABLED.code'))
                                                                        {{ Config::get('settings.GLOBAL_APPROVE.DISABLED.name') }}
                                                                    @endif
                                                                </i>
                                                            </small>
                                                        </p>
                                                    @else
                                                        @if($fromAdmin->approve == Config::get('settings.GLOBAL_APPROVE.ENABLED.code'))
                                                            <p colspan="2">
                                                                <strong>{{ $fromAdmin->admins->name }}</strong>
                                                                {{': '.$fromAdmin->content}}
                                                            </p>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <form id="add_reply_admin">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="text" class="form-control" required name="content_mess" id="content_mess_admin">
                                                    <input class="form-control" type="hidden" name="id_admin"
                                                           id="id_admin"
                                                           value="{{ Config::get('settings.TYPE_ACCOUNT.ADMIN') }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-default" type="submit" id="send_admin">
                                                            <i class="fa fa-send"></i>
                                                        </button>
                                                    </div>
                                                </div>
{{--                                                <div class="col-sm-10">--}}
{{--                                                    <input class="form-control" required type="text" name="content_mess"--}}
{{--                                                           id="content_mess_admin">--}}
{{--                                                    <input class="form-control" type="hidden" name="id_admin"--}}
{{--                                                           id="id_admin"--}}
{{--                                                           value="{{ $id }}">--}}
{{--                                                    <input type="hidden" id="reply_id" value="{{ $reply_id }}">--}}
{{--                                                </div>--}}
{{--                                                <div class="col-sm-2">--}}
{{--                                                    <button class="btn btn-danger" id="send_admin">Send</button>--}}
{{--                                                </div>--}}
                                            </form>
                                        </div>
                                    @endif
                                </div>


                                <div class="paging"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection
@section('scripts')
@endsection
