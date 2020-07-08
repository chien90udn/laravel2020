@extends('layouts.admin')
@section('breadcrumb', __('admin.category.manage'))
@section('content')

	<div class="col-md-12">
	    <h1>@lang('admin.category.create')</h1>

	    {!! Form::open(['route' => ['admin.categorys.store'], 'method' =>'POST', 'enctype'=>'multipart/form-data']) !!}

	    	@include ('admin/categorys/_body_form')

		    {{ link_to_route('admin.categorys.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		    {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
