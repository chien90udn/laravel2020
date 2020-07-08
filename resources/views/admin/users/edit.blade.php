@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.user.edit') }}</p>
	    @include('admin/users/_form')
    </div>
@endsection
