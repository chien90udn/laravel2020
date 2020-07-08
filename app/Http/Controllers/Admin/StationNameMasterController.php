<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StationNameMasterRequest;
use App\Models\StationNameMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class StationNameMasterController extends Controller
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
        return view('admin.station_name_master.index', [
            'station_name_master' => StationNameMaster::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.station_name_master.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(StationNameMasterRequest $request): RedirectResponse
    {
        $station_name = StationNameMaster::create([
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
                    'post_id' 			=> $station_name->id,
                    'lang_code'   		=> $lang->short_name,
                    'lang_type' 		=> Config::get('settings.TYPE_LANGUAGE.STATION_NAME_MASTE'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.STATION_NAME_MASTER_TITLE'),
                ]);
            }
        }
        return redirect()->route('admin.station_name_master.index')->withSuccess(__('admin.station_name.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $station_name
     * @return \Illuminate\Http\Response
     */
    public function show(StationNameMaster $station_name): View
    {
        return view('admin.station_name_master.show', [
            'station_name' => $station_name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $station_name
     * @return \Illuminate\Http\Response
     */
    public function edit(StationNameMaster $station_name): View
    {
        $translations=Translation::where('post_id',$station_name->id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.STATION_NAME_MASTER'))
            ->get();
        return view('admin.station_name_master.edit', [
            'station_name' 		=> $station_name,
            'translations'  => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $station_name
     * @return \Illuminate\Http\Response
     */
    public function update(StationNameMasterRequest $request, StationNameMaster $station_name): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$title != ''){
                Translation::updateOrCreate([
                    'post_id' 		 	=> $station_name->id,
                    'lang_code'  	 	=> $name,
                    'lang_type'		 	=> Config::get('settings.TYPE_LANGUAGE.STATION_NAME_MASTER'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.STATION_NAME_MASTER_TITLE'),
                ],[
                    'lang_content' => $request->$title,

                ]);
            }elseif($request->$title == ''){
                Translation::where('post_id',$station_name->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.STATION_NAME_MASTER'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.STATION_NAME_MASTER_TITLE'))
                    ->delete();
            }
        }
        $station_name->update(['title' => $request->title, 'position' => $request->position, 'status' => $request->status]);
        return redirect()->route('admin.station_name_master.edit', $station_name)->withSuccess(__('admin.station_name.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $station_name
     * @return \Illuminate\Http\Response
     */
    public function destroy(StationNameMaster $station_name)
    {
        $station_name->delete();
        return redirect()->route('admin.station_name.index')->withSuccess(__('admin.station_name.deleted'));
    }

    // Change position station_name
    public function changePositionstation_name(Request $request){
        StationNameMaster::where('id', $request->id)->update(['position' => $request->position]);
    }
}
