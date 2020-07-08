{!! Form::model($category, ['method' => 'PATCH', 'route' => ['admin.categorys.update', $category], 'enctype'=>'multipart/form-data']) !!}

  @include ('admin/categorys/_body_form')

  {{ link_to_route('admin.categorys.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
