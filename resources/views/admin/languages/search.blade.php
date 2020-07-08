@extends('layouts.admin')
@section('breadcrumb', __('admin.translations.manage'))
<div class="row">
    @section('content')
        <div class="col-md-12">
            <div class="box-header with-border">
                <a href="{{ route('admin.languages.index') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="box">
                <div class="box-body">
                    <div style="padding: 10px">
                        <form method="post" action="{{ route('admin.searchKey') }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="locale" id="search_keyword" value="{{ old('locale') }}"
                                       autocomplete="off" required class="form-control" placeholder="Enter your keyword...">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit" id="submitSearch">
                                        Search
                                    </button>
                                </div>
                            </div>
                            <div id="keywordsList" style="position: absolute;">
                            </div>
                        </form>

                    </div>
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
                        @if(isset($translations))
                            @foreach($translations as $tran)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $tran->locale }}</td>
                                    <td>{{ $tran->value }}</td>
                                    <td>

                                        <input type="hidden" value="{{ $tran->locale }}" class="locale{{ $tran->id }}">
                                        <input type="text" class="form-control translations" data-id="{{ $tran->id }}"
                                               value="{!! $tran->translation !!}">
                                    </td>
                                    <td><span style="font-size: 30px;color: green; display: none"
                                              class="fa fa-check-circle-o save{{$tran->id}}"></span></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="row" colspan="5"><i style="color: red">Please enter keywords</i></th>

                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endsection
</div>
