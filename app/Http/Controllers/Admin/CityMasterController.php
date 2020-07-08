<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityMasterRequest;
use App\Models\CityMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;


class CityMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $regionMasters = CityMaster::where('status', Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->orderBy('position', 'ASC')->get();
        view()->share('regionMasters', $regionMasters);
    }

    public function index(): View
    {
        return view('admin.citymaster.index', [
            'citymaster' => CityMaster::latest()->paginate(10)
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.citymaster.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(CityMasterRequest $request): RedirectResponse
    {
        $city = CityMaster::create([
            'title'     => $request->title,
            'position'  => $request->position,
            'status'    => $request->status,
            'region_master_id'    => $request->region_master_id,
        ]);

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$title!=''){
                Translation::create([
                    'lang_content'      => $request->$title,
                    'post_id'           => $city->id,
                    'lang_code'         => $lang->short_name,
                    'lang_type'         => Config::get('settings.TYPE_LANGUAGE.CITY_MASTER'),
                    'lang_type_detail'  => Config::get('settings.TYPE_LANGUAGE_DETAIL.CITY_MASTER_TITLE'),
                ]);
            }
        }
        return redirect()->route('admin.citymaster.index')->withSuccess(__('admin.city.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $city
     * @return \Illuminate\Http\Response
     */
    public function show(CityMaster $city): View
    {
        return view('admin.citymaster.show', [
            'city' => $city
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(CityMaster $city): View
    {
        $translations=Translation::where('post_id',$city->id)
            ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.CITY_MASTER'))
            ->get();
        return view('admin.citymaster.edit', [
            'city'          => $city,
            'translations'  => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityMasterRequest $request, city $city): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name = $lang->short_name;
            if($request->$title != ''){
                Translation::updateOrCreate([
                    'post_id'           => $city->id,
                    'lang_code'         => $name,
                    'lang_type'         => Config::get('settings.TYPE_LANGUAGE.CITY_MASTER'),
                    'lang_type_detail'  => Config::get('settings.TYPE_LANGUAGE_DETAIL.CITY_MASTER_TITLE'),
                ],[
                    'lang_content'      => $request->$title,

                ]);
            }elseif($request->$title == ''){
                Translation::where('post_id', $city->id)
                    ->where('lang_code', $name)
                    ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.CITY_MASTER'))
                    ->where('lang_type_detail', Config::get('settings.TYPE_LANGUAGE_DETAIL.CITY_MASTER_TITLE'))
                    ->delete();
            }
        }
        $city->update(['title' => $request->title, 'position' => $request->position, 'status' => $request->status, 'region_master_id' => $request->region_master_id]);
        return redirect()->route('admin.citymaster.edit', $city)->withSuccess(__('admin.city.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityMaster $city)
    {
        $city->delete();
        return redirect()->route('admin.city.index')->withSuccess(__('admin.city.deleted'));
    }

    // Change position city
    public function changePositioncity(Request $request){
        CityMaster::where('id', $request->id)->update([ 'position' => $request->position]);
    }
}
