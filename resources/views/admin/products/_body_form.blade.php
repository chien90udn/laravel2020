<div class="row">
    <div class="col-sm-4">
        <img src="{{ URL::asset($product->image['path']) }}" style="width: 100%"
             onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';">
    </div>
    <div class="col-sm-8">
        <h2>{{ $product->title }}</h2>
        <div class="col-sm-4">
            <i class="fa fa-user"></i> {{ $product->user['name'] }}
        </div>
        <div class="col-sm-4">
            <i class="fa fa-calendar"></i> {{ date_format($product->created_at, 'H:i - d/m/Y') }}
        </div>
        <div class="col-sm-4">
            <i class="fa fa-location-arrow"></i> {{ $product->locations['name'] }}
        </div>
        <div class="col-sm-12">
            <h4 style="border: solid red 1px; padding: 10px; background-color: #fffbe6">
                {{ $product->description }}
            </h4>
        </div>
    </div>
    <div class="col-sm-12">
        <h4>
            {!! $product->content !!}
        </h4>
    </div>

</div>

<div class="form-group">
    {!! Form::label('status', __('admin.product.status')) !!}
    {!! Form::select('approve', globalApprove(), null, ['class' => 'form-control' . ($errors->has('approve') ? ' is-invalid' : ''), 'required']) !!}
    @error('approve')
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
