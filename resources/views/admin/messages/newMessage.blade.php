@extends('layouts.admin')
@section('breadcrumb', __('admin.message.detail'))
@section('content')
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('admin.message.list') }}</h3>
        </div>
        <div class="box ">
            <div class="box-body">
                <caption>Name: <a target="_blank" href="{{route('admin.users.show',$user->id)}}">{{ $user->name }}</a>
                </caption>
                <hr style="border-top: 1px solid #8aa4af;">
                <div class="col-sm-12 chat-box" style="padding-top: 15px; padding-bottom: 10px; max-height: 500px">
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="contentNew" autofocus>
                    <input type="hidden" value="{{ $user->id }}" id="user_idNew">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" id="sentNew">
                            <i class="glyphicon glyphicon-send"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
