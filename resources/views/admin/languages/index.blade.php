@extends('layouts.admin')
@section('breadcrumb', __('admin.language.manage'))
<div class="row">
	@section('content')
	<div class="col-md-12">
	    <div class="box-header with-border">
	      <h3 class="box-title">{{ __('admin.language.list') }}</h3>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.translations_search') }}">Update translations with keywords</a>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.manage_keywords') }}">Manage keywords</a>
	    </div>
		<div class="box ">
		    @include ('admin/languages/_list')
		</div>
	</div>
	@endsection
</div>
