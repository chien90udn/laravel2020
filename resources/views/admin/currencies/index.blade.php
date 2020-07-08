@extends('layouts.admin')
@section('breadcrumb', __('admin.currencies.manage'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('admin.currencies.list') }}</h3>
	    </div>
		<div class="box ">
		    @include ('admin/currencies/_list')
		</div>
	</div>
	@endsection
</div>
