{!! Form::model($currency, ['method' => 'PATCH', 'route' => ['admin.currencies.update', $currency]]) !!}
<div class="box-body">
    @include ('admin/currencies/_body_form')
</div>
{{ link_to_route('admin.currencies.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
{!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
