@extends('layouts.admin')
@section('breadcrumb', __('Orders'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('Order List') }}</h3>
	    </div>
		<div class="box ">
		    @include ('admin/orders/_list')
		</div>
	</div>
	@endsection
</div>