@extends('layouts.admin')
@section('breadcrumb', __('admin.station_name.manage'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('admin.station_name.list') }}</h3>
	    </div>
		<div class="box ">
		    @include ('admin/station_name_master/_list')
		</div>
	</div>
	@endsection
</div>