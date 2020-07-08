<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FloorPlanMasterRequest;
use App\Models\FloorPlanMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class FloorPlanMasterController extends Controller 
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
        return view('admin.floor_plan_master.index', [
            'floor_plan_master' => FloorPlanMaster::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.floor_plan_master.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(FloorPlanMasterRequest $request): RedirectResponse
    {
        $floor_plan = FloorPlanMaster::create([
            'title'     => $request->title,
            'position'  => $request->position,
            'status'    => $request->status,
        ]);

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$name!=''){
                Translation::create([
                    'lang_content' => $request->$title,
                    'post_id' => $floor_plan->id,
                    'lang_code'   =>$lang->short_name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.FLOOR_PLAN_MASTER'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.FLOOR_PLAN_MASTER_TITLE'),
                ]);
            }
        }
        return redirect()->route('admin.floor_plan_master.index')->withSuccess(__('admin.floor_plan.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $floor_plan
     * @return \Illuminate\Http\Response
     */
    public function show(FloorPlanMaster $floor_plan): View
    {
        return view('admin.floor_plan_master.show', [
            'floor_plan' => $floor_plan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $floor_plan
     * @return \Illuminate\Http\Response
     */
    public function edit(FloorPlanMaster $floor_plan): View
    {
        $translations=Translation::where('post_id',$floor_plan->id)
            ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.FLOOR_PLAN_MASTER'))
            ->get();
        return view('admin.floor_plan_master.edit', [
            'floor_plan' => $floor_plan,
            'translations' => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $floor_plan
     * @return \Illuminate\Http\Response
     */
    public function update(FloorPlanMasterRequest $request, FloorPlanMaster $floor_plan): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$title!=''){
                Translation::updateOrCreate([
                    'post_id' => $floor_plan->id,
                    'lang_code'   =>$name,
                    'lang_type' => Config::get('settings.TYPE_LANGUAGE.FLOOR_PLAN_MASTER'),
                    'lang_type_detail'=>Config::get('settings.TYPE_LANGUAGE_DETAIL.FLOOR_PLAN_MASTER_TITLE'),
                ],[
                    'lang_content' => $request->$title,

                ]);
            }elseif($request->$title==''){
                Translation::where('post_id',$floor_plan->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.FLOOR_PLAN_MASTER'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.FLOOR_PLAN_MASTER_TITLE'))
                    ->delete();
            }
        }
        $floor_plan->update(['title' => $request->title, 'position' => $request->position, 'status' => $request->status]);
        return redirect()->route('admin.floor_plan_master.edit', $floor_plan)->withSuccess(__('admin.floor_plan.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $floor_plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(FloorPlanMaster $floor_plan)
    {
        $floor_plan->delete();
        return redirect()->route('admin.floor_plan.index')->withSuccess(__('admin.floor_plan.deleted'));
    }

    // Change position floor_plan
    public function changePositionfloor_plan(Request $request){
        FloorPlanMaster::where('id', $request->id)->update(['position' => $request->position]);
    }
}
