@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.currencies.edit') }}</p>
	    @include('admin/currencies/_form')
    </div>
@endsection
