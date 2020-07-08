<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategorysRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Config;


class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $languages=Language::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        \Illuminate\Support\Facades\View::share('languages',$languages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('admin.categorys.index', [
            'categorys' => Category::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
//        $path = URL::asset("/assets/admin/icons.json");
//        $icons = json_decode(file_get_contents($path), true);
        return view('admin.categorys.create');
//            ->with('icons', $icons);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorysRequest $request): RedirectResponse
    {
        $file = $request->file('icon');
        if(isset($file)){
            $name = $file->getClientOriginalName();
            $name = date('dmyHis').md5($name) . '.jpg';
            $file->move('uploads/categories/', $name);
            $icon = 'uploads/categories/' . $name;
        }else{
            $icon='';
        }

        $category=Category::create([
            'name' => $request->name,
            'icon' => $icon,
            'status' => $request->status,
        ]);
        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::create([
                    'lang_content' => $request->$name,
                    'post_id' => $category->id,
                    'lang_code'   =>$lang->short_name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.CATEGORY'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME'),
                ]);
            }

        }

        return redirect()->route('admin.categorys.index')->withSuccess(__('category.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param obj $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): View
    {

        return view('admin.categorys.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param obj $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category): View
    {
//        $path = URL::asset("/assets/admin/icons.json");
//        $icons = json_decode(file_get_contents($path), true);
        $translations=Translation::where('post_id',$category->id)
            ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.CATEGORY'))
            ->get();
        return view('admin.categorys.edit', [
            'category' => $category,
//            'icons' => $icons,
            'translations' => $translations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param obj $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategorysRequest $request, Category $category): RedirectResponse
    {
        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::updateOrCreate([
                    'post_id' => $category->id,
                    'lang_code'   =>$name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.CATEGORY'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME'),
                    ],[
                    'lang_content' => $request->$name,

                ]);
            }elseif($request->$name==''){
                Translation::where('post_id',$category->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.CATEGORY'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.CATEGORY_NAME'))
                    ->delete();
            }
        }
        $file = $request->file('icon');
        if(isset($file)){
            if(file_exists($category->icon)){
                @unlink($category->icon);
            }
            $name = $file->getClientOriginalName();
            $name = date('dmyHis').md5($name) . '.jpg';

            $file->move('uploads/categories/', $name);
            $icon = 'uploads/categories/' . $name;
        }else{
            $icon = $category->icon;
        }
        Category::where('id',$category->id)
            ->update([
                'name' => $request->name,
                'icon'=>$icon,
                'position' => $request->position,
                'status' =>$request->status,
            ]);
//        $category->update(array_filter($request->only(['name', 'icon', 'position', 'status'])));

        return redirect()->route('admin.categorys.edit', $category)->withSuccess(__('category.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param obj $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categorys.index')->withSuccess(__('category.deleted'));
    }
}
