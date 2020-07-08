<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.currencies.count', $currencies->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.currencies.name') }}</th>
                <th>{{ __('admin.currencies.symbol') }}</th>
                <th>{{ __('admin.currencies.status') }}</th>
                <th>{{ __('admin.currencies.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currencies as $currency)
                <tr>
                    <td>{{ $currency->long_name }}</td>
                    <td>{{ $currency->name }}</td>
                    <td>{{ nameStatus($currency->status) }}</td>
                    <td>
                        <a href="{{ route('admin.currencies.edit', $currency) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.currencies.show', $currency) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $currencies->links() }}
    </div>
</div>
