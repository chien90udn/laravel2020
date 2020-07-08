<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.city.count', $citymaster->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.city.title') }}</th>
                <th style="width: 40%">{{ __('admin.city.position') }} <i style="color: red">({{ __('admin.city.The position must be a number') }})</i></th>
                <th>{{ __('admin.city.status') }}</th>
                <th>{{ __('admin.city.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citymaster as $city)
                <tr>
                    <td>{{ $city->title }}</td>
                    <td>
                        <input type="text" data-id="{{ $city->id }}" class="position_city" value="{{ $city->position }}">
                        <label  class="btnSave{{ $city->id }}" style="display: none">Saved</label>
                        <i class="message-error{{ $city->id }}"></i>
                    </td>
                    <td>{{ nameStatus($city->status) }}</td>
                    <td>
                        <a href="{{ route('admin.citymaster.edit', $city) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.city.show', $city) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $citymaster->links() }}
    </div>
</div>
