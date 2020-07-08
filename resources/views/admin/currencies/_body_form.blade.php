<div class="form-group">
    {!! Form::label('name', __('admin.currencies.name')) !!}
    {!! Form::text('long_name', null, ['class' => 'form-control' . ($errors->has('long_name') ? ' is-invalid' : ''), 'placeholder' => __('admin.currencies.name'), 'required']) !!}
    @error('long_name')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('symbol', __('admin.currencies.symbol')) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('admin.currencies.symbol'), 'required']) !!}
    @error('name')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('status', __('admin.currencies.status')) !!}
    {!! Form::select('status', globalStatus(), null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
    @error('status')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
