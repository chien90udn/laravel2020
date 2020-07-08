@extends('layouts.admin')
@section('breadcrumb', __('admin.city.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.city.create')</h1>

	    {!! Form::open(['route' => ['admin.city.store'], 'method' =>'POST']) !!}
	    	<div class="box-body">
		        @include ('admin/citymaster/_body_form')
		        {{ link_to_route('admin.city.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		        {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
