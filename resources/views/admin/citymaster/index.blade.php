@extends('layouts.admin')
@section('breadcrumb', __('admin.city.manage'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('admin.city.list') }}</h3>
	    </div>
		<div class="box ">
		    @include ('admin/citymaster/_list')
		</div>
	</div>
	@endsection
</div>