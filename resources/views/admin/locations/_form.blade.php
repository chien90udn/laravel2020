{!! Form::model($location, ['method' => 'PATCH', 'route' => ['admin.locations.update', $location]]) !!}

  <div class="box-body">
     @include ('admin/locations/_body_form')
  </div>
  {{ link_to_route('admin.locations.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}