
<div class="form-group">
    {!! Form::label('region_master_id', __('admin.city.region_master')) !!}
    {!! Form::select('region_master_id', $regionMasters, null, ['class' => 'form-control' . ($errors->has('staturegion_master_ids') ? ' is-invalid' : ''), 'required']) !!}
    @error('region_master_id')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('title', __('admin.city.title')) !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => __('admin.city.placeholder.title'), 'required']) !!}
    @error('title')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>

@if(isset($translations))
    @foreach($languages as $lang)
        <div class="form-group">
            {!! Form::label('title', __('admin.city.title').' ('.$lang->short_name.')') !!}
            <input type="text" name="{{ $lang->short_name }}"
                   value="@foreach($translations as $translation){{ $translation->lang_code == $lang->short_name?$translation->lang_content:'' }}@endforeach"
                   class="form-control"
                   placeholder="{{ __('admin.city.placeholder.title').' ('.$lang->short_name.')' }}">
            @error('title')
            <span class="invalid-feedback text-red">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
@else
    @foreach($languages as $lang)
        <div class="form-group">
            {!! Form::label('name', __('admin.city.city').' ('.$lang->short_name.')') !!}
            <input type="text" name="{{ $lang->short_name }}"
                   value=""
                   class="form-control"
                   placeholder="{{ __('admin.city.placeholder.name').' ('.$lang->short_name.')' }}">
            @error('city')
            <span class="invalid-feedback text-red">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('position', __('admin.city.position')) !!}
    {!! Form::text('position', null, ['class' => 'form-control' . ($errors->has('position') ? ' is-invalid' : ''), 'placeholder' => __('admin.city.placeholder.position')]) !!}
    @error('position')
    <span class="invalid-feedback text-red">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('status', __('admin.city.status')) !!}
    {!! Form::select('status', globalStatus(), null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
    @error('status')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
