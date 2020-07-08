@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="col-md-12">
        <div class="d-flex sidebar-menu tree-content-center">
            <h1 class="">{{ __('admin.your infomation') }}</h1>
            <h3>{{ __('admin.user.name') }}: {{ Auth::guard('admin')->user()->name }}</h3>
            <h3>{{ __('admin.user.email') }}: {{ Auth::guard('admin')->user()->email }}</h3>
            <hr>
            <div class="form-group">
                <h2>Change password</h2>
                <form method="POST" action="{{ route('admin.changePassword') }}">
                    @csrf
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                    <div class="form-group">
                        <div class="form-group">
                            <label class="form-group">{{ __('admin.user.Current password') }}</label>
                            <input type="password" class="form-control" name="current_pass" value="{{ old('current_pass') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label class="form-group">{{ __('admin.user.New password') }}</label>
                            <input type="password" class="form-control" name="new_pass" value="{{ old('new_pass') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label class="form-group">{{ __('admin.user.New confirm password') }}</label>
                            <input type="password" class="form-control" name="new_confirm_pass" value="{{ old('new_confirm_pass') }}">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
            {{--            <div class="form-group">--}}
            {{--                <div class="form-group">--}}
            {{--                    <label class="form-group">{{ __('admin.user.name') }}</label>--}}
            {{--                    <input type="text" class="form-control" value="">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label class="form-group">{{ __('admin.user.email') }}</label>--}}
            {{--                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label class="form-group">{{ __('admin.user.phone') }}</label>--}}
            {{--                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->phone }}">--}}
            {{--                </div>--}}
            {{--                <button class="btn btn-primary">{{ __('admin.save') }}</button>--}}
            {{--            </div>--}}
            {{--        </div>--}}
        </div>
@endsection
