@extends('layouts.admin')
@section('breadcrumb', __('admin.currencies.manage'))
@section('content')
<div class="col-md-12">
    <h1>@lang('admin.currencies.create')</h1>
    {!! Form::open(['route' => ['admin.currencies.store'], 'method' =>'POST']) !!}
    <div class="box-body">
        @include ('admin/currencies/_body_form')
    </div>
    {{ link_to_route('admin.currencies.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
    {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
@endsection
