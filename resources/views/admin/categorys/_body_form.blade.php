<div class="box-body">
    <div class="form-group">
        {!! Form::label('name', __('admin.category.name')) !!}
        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('admin.category.placeholder.name'), 'required']) !!}
        @error('name')
        <span class="invalid-feedback text-red">{{ $message }}</span>
        @enderror
    </div>


    @if(isset($translations))
        @foreach($languages as $lang)
            <div class="form-group">
                {!! Form::label('name', __('admin.category.name').' ('.$lang->short_name.')') !!}
                <input type="text" name="{{ $lang->short_name }}"
                       value="@foreach($translations as $translation){{ $translation->lang_code == $lang->short_name?$translation->lang_content:'' }}@endforeach"
                       class="form-control"
                       placeholder="{{ __('admin.category.placeholder.name').' ('.$lang->short_name.')' }}">
                @error('name')
                <span class="invalid-feedback text-red">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    @else
        @foreach($languages as $lang)
            <div class="form-group">
                {!! Form::label('name', __('admin.category.name').' ('.$lang->short_name.')') !!}
                <input type="text" name="{{ $lang->short_name }}"
                       value=""
                       class="form-control"
                       placeholder="{{ __('admin.category.placeholder.name').' ('.$lang->short_name.')' }}">
                @error('name')
                <span class="invalid-feedback text-red">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    @endif


    <div class="form-group">
        {!! Form::label('icon', __('admin.category.icon')) !!}
        @if(!empty($category))
            <img class="icon_img" src="{{ URL::asset($category->icon) }}"
                 onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
        @endif
        <input type="file" class="form-control" name="icon">
        @error('icon')
        <span class="invalid-feedback text-red">{{$errors->first('icon.*','Files must be photos up to 2MB in size')}}</span>
        @enderror
    </div>
    <div class="form-group">
        {!! Form::label('status', __('admin.category.status')) !!}
        {!! Form::select('status', globalStatus(4), null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
        @error('status')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
