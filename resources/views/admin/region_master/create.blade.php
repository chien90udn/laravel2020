@extends('layouts.admin')
@section('breadcrumb', __('admin.region.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.region.create')</h1>

	    {!! Form::open(['route' => ['admin.region.store'], 'method' =>'POST']) !!}
	    	<div class="box-body">
		        @include ('admin/region_master/_body_form')
		        {{ link_to_route('admin.region.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		        {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
