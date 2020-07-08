{!! Form::model($location, ['method' => 'PATCH', 'route' => ['admin.station_name.update', $location]]) !!}

  <div class="box-body">
     @include ('admin/station_name_master/_body_form')
  </div>
  {{ link_to_route('admin.station_name.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}