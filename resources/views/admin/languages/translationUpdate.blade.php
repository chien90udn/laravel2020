@extends('layouts.admin')
@section('breadcrumb', __('admin.translations.manage'))
<div class="row">
    @section('content')
    <div class="col-md-12">
        <div class="box-header with-border">
            <a href="{{ route('admin.languages.index') }}" class="btn btn-sm btn-primary">Back</a>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.translations_search') }}">Update translations with keywords</a>
        </div>
        <div class="box ">
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Locale</th>
                        <th scope="col">Value</th>
                        <th scope="col">Translation</th>
                        <th scope="col" style="width: 50px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($translations as $tran)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $tran->locale }}</td>
                            <td>{{ $tran->value }}</td>
                            <td style="width: 45%;">

                                <input type="hidden" value="{{ $tran->locale }}" class="locale{{ $tran->id }}">
                                <input type="text" class="form-control translations" data-id="{{ $tran->id }}" value="{{ stripslashes($tran->translation) }}">
                            </td>
                            <td><span style="font-size: 30px;color: green; display: none" class="fa fa-check-circle-o save{{$tran->id}}"></span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @endsection
</div>
