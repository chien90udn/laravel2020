@extends('layouts.admin')
@section('breadcrumb', __('admin.language.manage'))
@section('content')
	<div class="col-md-12">
	    <h1>@lang('admin.language.create')</h1>

	    {!! Form::open(['route' => ['admin.languages.store'], 'method' =>'POST', 'enctype'=>'multipart/form-data']) !!}

	    	@include ('admin/languages/_body_form')

		    {{ link_to_route('admin.languages.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
		    {!! Form::submit(__('admin.forms.actions.save'), ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	   </div>
@endsection
