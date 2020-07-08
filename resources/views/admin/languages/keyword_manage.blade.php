@extends('layouts.admin')
@section('breadcrumb', __('admin.translations.manageKey'))
<div class="row">
    @section('content')
        <div class="col-md-12">
            <div class="box-header with-border">
                <a href="{{ route('admin.languages.index') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="box">
                <div style="padding: 10px">
                    <form method="post" action="{{ route('admin.addKey') }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="keyword" id="keyword" autocomplete="off" required class="form-control" placeholder="Enter your keyword...">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    Add
                                </button>
                            </div>
                        </div>
                        @if (Session::has('success'))
                            <div style="color: green">{{ Session::get('success') }}</div>
                        @endif
{{--                        @error('keyword')--}}
{{--                        <span class="invalid-feedback text-red">{{ $message }}</span>--}}
{{--                        @enderror--}}
                    </form>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">KEYWORD</th>
                        <th scope="col" style="width: 50px"></th>
                        <th scope="col" style="width: 80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>#</th>
                        <td>
                            <form method="post" action="{{ route('admin.postSearchKey') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="locale" id="search_keyword" value="{{ old('locale') }}" autocomplete="off" required class="form-control" placeholder="Enter your keyword...">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit" id="submitSearch">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div id="keywordsList" style="position: absolute;">
                            </div>
                        </td>
                    </tr>
                    @php
                        $i=1;
                    @endphp
                    @foreach($translations as $tran)
                        <tr class="tr_key{{ $tran->id }}">
                            <th scope="row">{{ $i++ }}</th>
                            <td>
                                <input type="hidden" value="{{ $tran->locale }}" class="locale">
                                <input type="text" class="form-control keyword" data-id="{{ $tran->id }}" value="{{ $tran->value }}">
                            </td>
                            <td><span style="font-size: 30px;color: green; display: none" class="fa fa-check-circle-o save{{$tran->id}}"></span></td>
                            <td><span class="btn btn-danger deleteKey" data-id="{{ $tran->id }}">Delete</span> </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
</div>
@endsection
</div>
