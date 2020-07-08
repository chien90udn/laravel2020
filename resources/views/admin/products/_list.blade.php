<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.product.count', $products->total()) }}</caption>
        <thead>
        <tr>
            <th style="width: 67px;">{{ __('admin.product.image') }}</th>
            <th>{{ __('admin.product.title') }}</th>
            <th>{{ __('admin.product.user') }}</th>
            <th>{{ __('admin.product.price') }}</th>
            <th>{{ __('admin.product.hot') }}</th>
            <th>{{ __('admin.product.status') }}</th>
            <th>{{ __('admin.product.approve') }}</th>
            <th style="width: 88px;">{{ __('admin.location.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><img src="{{ URL::asset($product->images['path']) }}" class="imgProd-sm"
                         onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';"></td>
                <td>
                    {{  str_limit($product->title) }}
                    @if($product -> sold == Config::get('settings.SOLD'))
                        <span class="sold">{{ __('admin.product.Sold') }}</span>
                    @endif
                </td>
                <td>{{  $product->user_type==Config::get('settings.TYPE_ACCOUNT.ADMIN')?$product->admin->name.'(ADMIN)':$product->user->name.'(USER)' }}</td>
                <td style="text-align: right">{{ $product->currency->name.number_format($product->price) }}</td>
                <td>{{ ($product->hot==Config::get('settings.HOT_PRODUCT.HOT.code'))?Config::get('settings.HOT_PRODUCT.HOT.name'):Config::get('settings.HOT_PRODUCT.NORMAL.name') }}</td>
                <td>{{ nameStatus($product->status) }}</td>
                <td style="color:{{$product->approve==0?'red':''}}">{{ nameApprove($product->approve) }}</td>
                <td>
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                    </a>
                    @if($product->user_type==Config::get('settings.TYPE_ACCOUNT.ADMIN'))
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm ">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>

