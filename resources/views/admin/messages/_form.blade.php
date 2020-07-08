{!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user]]) !!}
<div class="box-body">
    @include ('admin/users/_body_form')
</div>
{{ link_to_route('admin.users.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
{!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
