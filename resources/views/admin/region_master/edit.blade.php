@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.region.edit') }}</p>
	    @include('admin/region_master/_form')
    </div>
@endsection
