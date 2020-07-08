@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.category.edit') }}</p>
	    @include('admin/categorys/_form')
    </div>
@endsection
