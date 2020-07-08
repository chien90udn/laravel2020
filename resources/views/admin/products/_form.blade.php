{!! Form::model($product, ['method' => 'PATCH', 'route' => ['admin.products.update', $product]]) !!}

<div class="box-body">
    @include ('admin/products/_body_form')
</div>
{{ link_to_route('admin.products.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
{!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
