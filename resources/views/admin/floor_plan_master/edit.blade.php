@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.floor_plan.edit') }}</p>
	    @include('admin/floor_plan_master/_form')
    </div>
@endsection
