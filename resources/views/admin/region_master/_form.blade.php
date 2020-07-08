{!! Form::model($location, ['method' => 'PATCH', 'route' => ['admin.region.update', $location]]) !!}

  <div class="box-body">
     @include ('admin/region_master/_body_form')
  </div>
  {{ link_to_route('admin.region.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}