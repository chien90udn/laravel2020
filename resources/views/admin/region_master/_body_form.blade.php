<div class="form-group">
    {!! Form::label('name', __('admin.region.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('admin.region.placeholder.name'), 'required']) !!}
    @error('name')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>

@if(isset($translations))
    @foreach($languages as $lang)
        <div class="form-group">
            {!! Form::label('name', __('admin.region.name').' ('.$lang->short_name.')') !!}
            <input type="text" name="{{ $lang->short_name }}"
                   value="@foreach($translations as $translation){{ $translation->lang_code == $lang->short_name?$translation->lang_content:'' }}@endforeach"
                   class="form-control"
                   placeholder="{{ __('admin.region.placeholder.name').' ('.$lang->short_name.')' }}">
            @error('name')
            <span class="invalid-feedback text-red">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
@else
    @foreach($languages as $lang)
        <div class="form-group">
            {!! Form::label('name', __('admin.region.name').' ('.$lang->short_name.')') !!}
            <input type="text" name="{{ $lang->short_name }}"
                   value=""
                   class="form-control"
                   placeholder="{{ __('admin.region.placeholder.name').' ('.$lang->short_name.')' }}">
            @error('name')
            <span class="invalid-feedback text-red">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('position', __('admin.region.position')) !!}
    {!! Form::text('position', null, ['class' => 'form-control' . ($errors->has('position') ? ' is-invalid' : ''), 'placeholder' => __('admin.region.placeholder.position')]) !!}
    @error('position')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('status', __('admin.region.status')) !!}
    {!! Form::select('status', globalStatus(), null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
    @error('status')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
