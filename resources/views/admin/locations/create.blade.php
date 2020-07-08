@extends('layouts.admin')
@section('breadcrumb', __('admin.location.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.location.create')</h1>

	    {!! Form::open(['route' => ['admin.locations.store'], 'method' =>'POST']) !!}
	    	<div class="box-body">
		        @include ('admin/locations/_body_form')
		        {{ link_to_route('admin.locations.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		        {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
