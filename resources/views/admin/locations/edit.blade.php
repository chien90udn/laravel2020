@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.location.edit') }}</p>
	    @include('admin/locations/_form')
    </div>
@endsection
