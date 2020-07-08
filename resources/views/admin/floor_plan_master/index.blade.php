@extends('layouts.admin')
@section('breadcrumb', __('admin.floor_plan.manage'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('admin.floor_plan.list') }}</h3>
	    </div>
		<div class="box ">
		    @include ('admin/floor_plan_master/_list')
		</div>
	</div>
	@endsection
</div>