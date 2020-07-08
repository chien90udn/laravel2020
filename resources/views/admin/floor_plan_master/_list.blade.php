<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.floor_plan.count', $floor_plan_master->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.floor_plan.name') }}</th>
                <th style="width: 40%">{{ __('admin.floor_plan.position') }} <i style="color: red">({{ __('admin.floor_plan.The position must be a number') }})</i></th>
                <th>{{ __('admin.floor_plan.status') }}</th>
                <th>{{ __('admin.floor_plan.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($floor_plan_master as $floor_plan)
                <tr>
                    <td>{{ $floor_plan->name }}</td>
                    <td>
                        <input type="text" data-id="{{ $floor_plan->id }}" class="position_floor_plan" value="{{ $floor_plan->position }}">
                        <label  class="btnSave{{ $floor_plan->id }}" style="display: none">Saved</label>
                        <i class="message-error{{ $floor_plan->id }}"></i>
                    </td>
                    <td>{{ nameStatus($floor_plan->status) }}</td>
                    <td>
                        <a href="{{ route('admin.floor_plan_master.edit', $floor_plan) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.floor_plan.show', $floor_plan) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $floor_plan_master->links() }}
    </div>
</div>
