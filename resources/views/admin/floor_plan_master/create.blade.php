@extends('layouts.admin')
@section('breadcrumb', __('admin.floor_plan.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.floor_plan.create')</h1>

	    {!! Form::open(['route' => ['admin.floor_plan.store'], 'method' =>'POST']) !!}
	    	<div class="box-body">
		        @include ('admin/floor_plan_master/_body_form')
		        {{ link_to_route('admin.floor_plan.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		        {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
