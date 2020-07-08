<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationsRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class LocationsController extends Controller
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
        return view('admin.locations.index', [
            'locations' => Location::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.locations.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(LocationsRequest $request): RedirectResponse
    {
        $location = Location::create([
            'name'      => $request->name,
            'position'  => $request->position,
            'status'    => $request->status,
        ]);

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::create([
                    'lang_content' => $request->$name,
                    'post_id' => $location->id,
                    'lang_code'   =>$lang->short_name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.LOCATION'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME'),
                ]);
            }

        }
        return redirect()->route('admin.locations.index')->withSuccess(__('admin.location.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location): View
    {
        return view('admin.locations.show', [
            'location' => $location
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location): View
    {
        $translations=Translation::where('post_id',$location->id)
            ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.LOCATION'))
            ->get();
        return view('admin.locations.edit', [
            'location' => $location,
            'translations' => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationsRequest $request, Location $location): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::updateOrCreate([
                    'post_id' => $location->id,
                    'lang_code'   =>$name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.LOCATION'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME'),
                ],[
                    'lang_content' => $request->$name,

                ]);
            }elseif($request->$name==''){
                Translation::where('post_id',$location->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.LOCATION'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.LOCATION_NAME'))
                    ->delete();
            }
        }
        $location->update(['name'=>$request->name, 'position'=>$request->position, 'status'=>$request->status]);
        return redirect()->route('admin.locations.edit', $location)->withSuccess(__('admin.location.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('admin.location.index')->withSuccess(__('admin.location.deleted'));
    }


    // Change position location

    public function changePositionLocation(Request $request){
        Location::where('id',$request->id)->update(['position'=>$request->position]);
    }
}
