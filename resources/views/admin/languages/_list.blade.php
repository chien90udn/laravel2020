<div class="box-body">
    <table class="table table-bordered">
        <caption>{{ trans_choice('admin.language.count', $languages->total()) }}</caption>
        <div id="MessageUpdate" class="alert alert-success alert-dismissible">
            {{ __('admin.language.successMess') }}


        </div>
        <thead>
            <tr>
                <th>{{ __('admin.language.name') }}</th>
                <th>{{ __('admin.language.short_name') }}</th>
                <th>{{ __('admin.language.default') }}</th>
                <th>{{ __('admin.language.status') }}</th>
                <th>{{ __('admin.language.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($languages as $language)
                <tr>
                    <td>{{ $language->name }}</td>
                    <td>{{ $language->short_name }}</td>
                    <td>
                        <input type="radio" class="setDefaultLang" data-id="{{  $language->id }}" {{ $language->default==Config::get('settings.DEFAULT_LANGUAGE.DEFAULT')?'checked':'' }} name="default"></td>
                    <td>{{ nameStatus($language->status) }}</td>
                    <td>
                        <a href="{{ route('admin.languages.edit', $language) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('admin.languages.show', $language) }}" class="btn btn-primary btn-sm" >
                            <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </a>

                        <a href="{{ route('admin.translations_update',['locale'=>$language->short_name]) }}" title="Translations" class="btn btn-primary btn-sm" >
                            <i class="fa fa-language" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $languages->links() }}
    </div>
</div>
