<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.category.count', $categorys->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.category.name') }}</th>
                <th>{{ __('admin.category.icon') }}</th>
                <th>{{ __('admin.category.status') }}</th>
                <th>{{ __('admin.category.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorys as $category)

                <tr>
                    <td>{{ $category->name }}</td>
                    <td><img class="icon_img" src="{{ URL::asset($category->icon) }}" onerror="this.src='{{URL::asset("assets/front/images/no_image.png")}}';"></td>
                    <td>{{ nameStatus($category->status) }}</td>
                    <td>
                        <a href="{{ route('admin.categorys.edit', $category) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.categorys.show', $category) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $categorys->links() }}
    </div>
</div>
