@extends('layouts.admin')
@section('breadcrumb', __('admin.product.list'))
<div class="row">
    @section('content')
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('admin.product.list') }}</h3>
            </div>
            <div class="box ">
                @include ('admin/products/_list')
            </div>
        </div>
    @endsection
</div>
