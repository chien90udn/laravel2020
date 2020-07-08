<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.user.count', $users->total()) }}</caption>
        <thead>
            <tr>
                <th>{{ __('admin.user.name') }}</th>
                <th>{{ __('admin.user.email') }}</th>
                <th>{{ __('admin.user.User type') }}</th>
                <th>{{ __('admin.user.status') }}</th>
                <th>{{ __('admin.user.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(@unserialize($user->user_type) == true)
                            @foreach(unserialize($user->user_type) as $key => $value)
                                {{ nameUserType($value) }}
                            @endforeach
                        @endif
                    </td>
                    <td>{{ nameStatus($user->status) }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.yourMessageDetail', ['user_id'=>$user->id]) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-comments" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
