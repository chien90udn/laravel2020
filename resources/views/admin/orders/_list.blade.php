<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('Count', $orders->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('Họ và tên') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Sản phẩm') }}</th>
                <th>{{ __('Nội dung') }}</th>
                <th>{{ __('Ngày đặt hàng') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)

                <tr>
                    <td>{{ $order->order_name }}</td>
                    <td>{{ $order->order_phone }}</td>
                    <td>{{ $order->order_address }}</td>
                    <td>{{ $order->order_product }}</td>
                    <td>{{ $order->order_comment }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
