<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.region.count', $region_master->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.region.name') }}</th>
                <th style="width: 40%">{{ __('admin.region.position') }} <i style="color: red">({{ __('admin.region.The position must be a number') }})</i></th>
                <th>{{ __('admin.region.status') }}</th>
                <th>{{ __('admin.region.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($region_master as $region)
                <tr>
                    <td>{{ $region->name }}</td>
                    <td>
                        <input type="text" data-id="{{ $region->id }}" class="position_region" value="{{ $region->position }}">
                        <label  class="btnSave{{ $region->id }}" style="display: none">Saved</label>
                        <i class="message-error{{ $region->id }}"></i>
                    </td>
                    <td>{{ nameStatus($region->status) }}</td>
                    <td>
                        <a href="{{ route('admin.region_master.edit', $region) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.region.show', $region) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $region_master->links() }}
    </div>
</div>
