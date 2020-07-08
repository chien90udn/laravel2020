<?php

namespace App\Http\Controllers\Admin;

use App\Models\LtmTranslation;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguagesRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Config;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');

    }

    public function index(): View
    {
        return view('admin.languages.index', [
            'languages' => Language::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguagesRequest $request): RedirectResponse
    {

        $file = $request->file('picture');
        $locale=$request->short_name;
        if (isset($file)) {
            $name = $file->getClientOriginalName();
            $name = date('dmyHis') . md5($name) . '.jpg';
            $file->move('uploads/languages/', $name);
            $picture = 'uploads/languages/' . $name;
        } else {
            $picture = '';
        }

        $language = Language::create([
            'name' => $request->name,
            'short_name' => $locale,
            'status' => $request->status,
            'default' => Config::get('settings.DEFAULT_LANGUAGE.NORMAL'),
            'path' => $picture,
        ]);

        //Check tồn tại thư mục để tạo thư mục và file front.php
        if(file_exists(resource_path('lang/'.$locale))){
            $arrays=LtmTranslation::where('parent_id',Config::get('settings.PARENT_ID_DEFAULT'))->get();
            $arrar_start = "<?php return[";
            $arrar_body = '';
            foreach ($arrays as $arr) {
                $tran = new LtmTranslation();
                $tran->status = 1;
                $tran->locale = $locale;
                $tran->value = $arr->value;
                $tran->translation = '';
                $tran->parent_id=$arr->id;
                $tran->save();
                $arrar_body = $arrar_body . "'" . addslashes($arr->value) . "'" . "=>'',";
            }
            $arrar_end = "];";

            $arra_lang = $arrar_start . $arrar_body . $arrar_end;
            $myfile = fopen(resource_path('lang/'.$locale.'/front.php'), 'w');
            fwrite($myfile, $arra_lang);
        }else{
            $arrays=LtmTranslation::where('parent_id',Config::get('settings.PARENT_ID_DEFAULT'))->get();
            $arrar_start = "<?php return[";
            $arrar_body = '';
            foreach ($arrays as $arr) {
                $tran = new LtmTranslation();
                $tran->status = 1;
                $tran->locale = $locale;
                $tran->value = $arr->value;
                $tran->translation = '';
                $tran->parent_id=$arr->id;
                $tran->save();
                $arrar_body = $arrar_body . "'" . addslashes($arr->value) . "'" . "=>'',";
            }
            $arrar_end = "];";

            $arra_lang = $arrar_start . $arrar_body . $arrar_end;

            mkdir(resource_path('lang/'.$locale), 0777, true);
            $myfile = fopen(resource_path('lang/'.$locale.'/front.php'), 'w');
            fwrite($myfile, $arra_lang);
        }


        // thêm translations cho languages
        $languages = Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($languages as $lang) {
            $name = $lang->short_name;
            if ($request->$name != '') {
                Translation::create([
                    'lang_content' => $request->$name,
                    'post_id' => $language->id,
                    'lang_code' => $lang->short_name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.LANGUAGE'),
                    'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.LANGUAGE_NAME'),
                ]);
            }

        }

        return redirect()->route('admin.languages.index')->withSuccess(__('admin.language.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param obj $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language): View
    {
        return view('admin.languages.show', [
            'language' => $language
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param obj $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language): View
    {
        $translations = Translation::where('post_id', $language->id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.LANGUAGE'))
            ->get();
        return view('admin.languages.edit', [
            'language' => $language,
            'translations' => $translations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param obj $language
     * @return \Illuminate\Http\Response
     */
    public function update(LanguagesRequest $request, Language $language): RedirectResponse
    {
        $languages = Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($languages as $lang) {
            $name = $lang->short_name;
            if ($request->$name != '') {
//                dd($request->$name);
                Translation::updateOrCreate([
                    'post_id' => $language->id,
                    'lang_code' => $name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.LANGUAGE'),
                    'lang_type_detail' => Config::get('settings.TYPE_LANGUAGE_DETAIL.LANGUAGE_NAME'),
                ], [
                    'lang_content' => $request->$name,

                ]);
            } elseif ($request->$name == '') {
                Translation::where('post_id', $language->id)
                    ->where('lang_code', $name)
                    ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.LANGUAGE'))
                    ->where('lang_type_detail', Config::get('settings.TYPE_LANGUAGE_DETAIL.LANGUAGE_NAME'))
                    ->delete();
            }
        }
        $file = $request->file('picture');
        if (isset($file)) {
            if (file_exists($language->path)) {
                @unlink($language->path);
            }
            $name = $file->getClientOriginalName();
            $name = date('dmyHis') . md5($name) . '.jpg';

            $file->move('uploads/languages/', $name);
            $picture = 'uploads/languages/' . $name;
        } else {
            $picture = $language->path;
        }
        Language::where('id', $language->id)
            ->update([
                'name' => $request->name,
                'path' => $picture,
                'status' => $request->status,
            ]);

//        $language->update(['name'=>$request->name, 'short_name'=>$request->short_name, 'status'=>$request->status]);
        return redirect()->route('admin.languages.edit', $language)->withSuccess(__('admin.language.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param obj $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('admin.language.index')->withSuccess(__('admin.language.deleted'));
    }


// Set default language
    public function SetDefaultLang(Request $request)
    {
        Language::where('default', Config::get('settings.DEFAULT_LANGUAGE.DEFAULT'))
            ->update(['default' => Config::get('settings.DEFAULT_LANGUAGE.NORMAL')]);
        Language::where('id', $request->id)
            ->update(['default' => Config::get('settings.DEFAULT_LANGUAGE.DEFAULT')]);
        Session::flash('success', 'Change successfully!');
        return redirect()->route('admin.index');
    }

}
