@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.station_name.edit') }}</p>
	    @include('admin/station_name_master/_form')
    </div>
@endsection
