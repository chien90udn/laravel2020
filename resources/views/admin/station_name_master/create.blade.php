@extends('layouts.admin')
@section('breadcrumb', __('admin.station_name.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.station_name.create')</h1>

	    {!! Form::open(['route' => ['admin.station_name.store'], 'method' =>'POST']) !!}
	    	<div class="box-body">
		        @include ('admin/station_name_master/_body_form')
		        {{ link_to_route('admin.station_name.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		        {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
