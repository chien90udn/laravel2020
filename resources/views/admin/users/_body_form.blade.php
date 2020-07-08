<div class="form-group">
    {!! Form::label('name', __('admin.user.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('admin.user.placeholder.name'), 'required', 'readonly']) !!}
    @error('name')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('email', __('admin.user.email')) !!}
    {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('admin.user.placeholder.email'), 'required', 'readonly']) !!}
    @error('email')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>


<div class="form-group">
    @foreach(Config::get('settings.USER_TYPE') as $key => $userType)
        <input type="checkbox" name="user_type[]" value="{{ $userType['code'] }}"
        @if(@unserialize($user->user_type)==true)
            @foreach(unserialize($user->user_type) as $key1 => $value)
                    {{ $userType['code'] == $value? 'Checked':'' }}
            @endforeach
        @endif
        >{{ $key }}<br>
    @endforeach
    @error('status')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
{{--<div class="form-group">--}}
{{--    {!! Form::label('password', __('admin.user.password')) !!}--}}
{{--    {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('admin.user.placeholder.password'), 'readonly']) !!}--}}
{{--    @error('password')--}}
{{--    <span class="invalid-feedback text-red">{{ $message }}</span>--}}
{{--    @enderror--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('password_confirmation', __('admin.user.password_confirmation')) !!}--}}
{{--    {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('admin.user.placeholder.password_confirmation')]) !!}--}}
{{--    @error('password_confirmation')--}}
{{--    <span class="invalid-feedback text-red">{{ $message }}</span>--}}
{{--    @enderror--}}
{{--</div>--}}
<div class="form-group">
    {!! Form::label('status', __('admin.user.status')) !!}
    {!! Form::select('status', globalStatus(4), null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
    @error('status')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
