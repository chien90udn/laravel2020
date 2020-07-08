{!! Form::model($location, ['method' => 'PATCH', 'route' => ['admin.floor_plan.update', $location]]) !!}

  <div class="box-body">
     @include ('admin/floor_plan_master/_body_form')
  </div>
  {{ link_to_route('admin.floor_plan.index', __('admin.forms.actions.back'), [], ['class' => 'btn btn-secondary']) }}
  {!! Form::submit(__('admin.forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}