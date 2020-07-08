@extends('layouts.admin')
@section('breadcrumb', __('admin.message.detail'))
<div class="row">
    @section('content')
        <div class="col-sm-12">
            <div class="alert alert-success" id="MessageUpdate"></div>
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered">
                        <caption>
                            <h4>
                                {{ $message->products['title'] }} <a target="_blank" class="btn btn-danger btn-sm"
                                                                     href="{{ route('admin.products.show', $message->product_id) }}">Detail</a>
                            </h4>

                        </caption>
                        <thead>
                        <tr>
                            <th>{{ __('admin.message.user') }}</th>
                            <th>{{ __('admin.message.content') }}</th>
                            <th>{{ __('admin.message.date') }}</th>
                            <th>{{ __('admin.message.status') }}</th>
                            <th>{{ __('admin.message.action') }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $msg)
                            <tr>
                                <td>
                                    @if($msg->user_id_from_type == Config::get('settings.TYPE_ACCOUNT.USER'))
                                        <a href="" title="{{ __('admin.message.detailUser') }}">
                                            {{ $msg->users['name'] }}
                                        </a>
                                    @else
                                        <a href="" title="{{ __('admin.message.detailUser') }}">
                                            {{ $msg->admins['name'] }}
                                        </a>
                                    @endif

                                </td>
                                <td>{{ $msg->content }}</td>
                                <td>{{ date_format($msg->created_at,'H:i d/m/Y') }}</td>
                                <td class="status{{ $msg->id }}">{{ nameApprove($msg->approve) }}</td>
                                <td class="{{ $msg->id }}">
                                    @if($msg->approve == Config::get('settings.GLOBAL_APPROVE.DISABLED.code'))
                                        <button id="{{ $msg->id }}" data-id="{{ $msg->id }}" class="btn btn-danger btn-sm btn-approve UpdateApprove">Enable</button>
                                    @else
                                        <label disabled class="btn btn-disabled btn-sm btn-approve"></label>
                                    @endif
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
</div>
