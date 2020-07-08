@extends('layouts.admin')

@section('content')
	<div class="col-md-12">
	    <p>{{ __('admin.language.edit') }}</p>
	    @include('admin/languages/_form')
    </div>
@endsection
