<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.station_name.count', $station_name_master->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.station_name.name') }}</th>
                <th style="width: 40%">{{ __('admin.station_name.position') }} <i style="color: red">({{ __('admin.station_name.The position must be a number') }})</i></th>
                <th>{{ __('admin.station_name.status') }}</th>
                <th>{{ __('admin.station_name.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($station_name_master as $station_name)
                <tr>
                    <td>{{ $station_name->name }}</td>
                    <td>
                        <input type="text" data-id="{{ $station_name->id }}" class="position_station_name" value="{{ $station_name->position }}">
                        <label  class="btnSave{{ $station_name->id }}" style="display: none">Saved</label>
                        <i class="message-error{{ $station_name->id }}"></i>
                    </td>
                    <td>{{ nameStatus($station_name->status) }}</td>
                    <td>
                        <a href="{{ route('admin.station_name_master.edit', $station_name) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.station_name.show', $station_name) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $station_name_master->links() }}
    </div>
</div>
