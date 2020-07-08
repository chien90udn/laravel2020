<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.location.count', $locations->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.location.name') }}</th>
                <th style="width: 40%">{{ __('admin.location.position') }} <i style="color: red">({{ __('admin.location.The position must be a number') }})</i></th>
                <th>{{ __('admin.location.status') }}</th>
                <th>{{ __('admin.location.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($locations as $location)
                <tr>
                    <td>{{ $location->name }}</td>
                    <td>
                        <input type="text" data-id="{{ $location->id }}" class="position_location" value="{{ $location->position }}">
                        <label  class="btnSave{{ $location->id }}" style="display: none">Saved</label>
                        <i class="message-error{{ $location->id }}"></i>
                    </td>
                    <td>{{ nameStatus($location->status) }}</td>
                    <td>
                        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.locations.show', $location) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $locations->links() }}
    </div>
</div>
