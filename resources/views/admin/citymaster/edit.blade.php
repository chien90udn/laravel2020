@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.city.edit') }}</p>
	    @include('admin/citymaster/_form')
    </div>
@endsection
