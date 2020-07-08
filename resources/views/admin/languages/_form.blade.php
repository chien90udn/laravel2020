{!! Form::model($language, ['method' => 'PATCH', 'route' => ['admin.languages.update', $language], 'enctype'=>'multipart/form-data']) !!}

  <div class="box-body">

     @include ('admin/languages/_body_form')

  </div>
  {{ link_to_route('admin.languages.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
