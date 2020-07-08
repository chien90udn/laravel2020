<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegionMasterRequest;
use App\Models\RegionMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class RegionMasterController extends Controller
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
        return view('admin.region_master.index', [
            'region_master' => RegionMaster::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.region_master.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(RegionMasterRequest $request): RedirectResponse
    {
        $region = RegionMaster::create([
            'title'     => $request->title,
            'position'  => $request->position,
            'status'    => $request->status,
        ]);

        $language=Language::where('status',	Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::create([
                    'lang_content' 		=> $request->$title,
                    'post_id' 			=> $region->id,
                    'lang_code'   		=> $lang->short_name,
                    'lang_type' 		=> Config::get('settings.TYPE_LANGUAGE.REGION_MASTER'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.REGION_MASTER_TITLE'),
                ]);
            }
        }
        return redirect()->route('admin.region_master.index')->withSuccess(__('admin.region.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $region
     * @return \Illuminate\Http\Response
     */
    public function show(RegionMaster $region): View
    {
        return view('admin.region_master.show', [
            'region' => $region
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(RegionMaster $region): View
    {
        $translations=Translation::where('post_id',$region->id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.REGION_MASTER'))
            ->get();
        return view('admin.region_master.edit', [
            'region' 		=> $region,
            'translations'  => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $region
     * @return \Illuminate\Http\Response
     */
    public function update(RegionMasterRequest $request, RegionMaster $region): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$title != ''){
                Translation::updateOrCreate([
                    'post_id' 		 	=> $region->id,
                    'lang_code'  	 	=> $name,
                    'lang_type'		 	=> Config::get('settings.TYPE_LANGUAGE.REGION_MASTER'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.REGION_MASTER_TITLE'),
                ],[
                    'lang_content' => $request->$title,

                ]);
            }elseif($request->$title == ''){
                Translation::where('post_id',$region->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.REGION_MASTER'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.REGION_MASTER_TITLE'))
                    ->delete();
            }
        }
        $region->update(['title' => $request->title, 'position' => $request->position, 'status' => $request->status]);
        return redirect()->route('admin.region_master.edit', $region)->withSuccess(__('admin.region.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegionMaster $region)
    {
        $region->delete();
        return redirect()->route('admin.region.index')->withSuccess(__('admin.region.deleted'));
    }

    // Change position region
    public function changePositionregion(Request $request){
        RegionMaster::where('id', $request->id)->update(['position' => $request->position]);
    }
}
