<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperatingCompanyRequest;
use App\Models\OperatingCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Config;

class OperatingCompanyController extends Controller
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
        return view('admin.operating_company_master.index', [
            'operating_company_master' => OperatingCompany::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        return view('admin.operating_company_master.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(OperatingCompanyRequest $request): RedirectResponse
    {
        $operating_company = OperatingCompany::create([
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
                    'post_id' 			=> $operating_company->id,
                    'lang_code'   		=> $lang->short_name,
                    'lang_type' 		=> Config::get('settings.TYPE_LANGUAGE.OPERATING_COMPANY_MASTER'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.OPERATING_COMPANY_MASTER_TITLE'),
                ]);
            }
        }
        return redirect()->route('admin.operating_company_master.index')->withSuccess(__('admin.operating_company.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  obj  $operating_company
     * @return \Illuminate\Http\Response
     */
    public function show(OperatingCompany $operating_company): View
    {
        return view('admin.operating_company_master.show', [
            'operating_company' => $operating_company
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  obj  $operating_company
     * @return \Illuminate\Http\Response
     */
    public function edit(OperatingCompany $operating_company): View
    {
        $translations=Translation::where('post_id',$operating_company->id)
            ->where('lang_type', Config::get('settings.TYPE_LANGUAGE.OPERATING_COMPANY_MASTER'))
            ->get();
        return view('admin.operating_company_master.edit', [
            'operating_company' 		=> $operating_company,
            'translations'  => $translations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  obj  $operating_company
     * @return \Illuminate\Http\Response
     */
    public function update(OperatingCompanyRequest $request, OperatingCompany $operating_company): RedirectResponse
    {

        $language=Language::where('status',Config::get('settings.GLOBAL_STATUS.ENABLED.code'))->get();
        foreach ($language as $lang){
            $name=$lang->short_name;
            if($request->$title != ''){
                Translation::updateOrCreate([
                    'post_id' 		 	=> $operating_company->id,
                    'lang_code'  	 	=> $name,
                    'lang_type'		 	=> Config::get('settings.TYPE_LANGUAGE.OPERATING_COMPANY_MASTER'),
                    'lang_type_detail'	=> Config::get('settings.TYPE_LANGUAGE_DETAIL.OPERATING_COMPANY_MASTER_TITLE'),
                ],[
                    'lang_content' => $request->$title,

                ]);
            }elseif($request->$title == ''){
                Translation::where('post_id',$operating_company->id)
                    ->where('lang_code',$name)
                    ->where('lang_type',Config::get('settings.TYPE_LANGUAGE.OPERATING_COMPANY_MASTER'))
                    ->where('lang_type_detail',Config::get('settings.TYPE_LANGUAGE_DETAIL.OPERATING_COMPANY_MASTER_TITLE'))
                    ->delete();
            }
        }
        $operating_company->update(['title' => $request->title, 'position' => $request->position, 'status' => $request->status]);
        return redirect()->route('admin.operating_company_master.edit', $operating_company)->withSuccess(__('admin.operating_company.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $operating_company
     * @return \Illuminate\Http\Response
     */
    public function destroy(OperatingCompany $operating_company)
    {
        $operating_company->delete();
        return redirect()->route('admin.operating_company.index')->withSuccess(__('admin.operating_company.deleted'));
    }

    // Change position operating_company
    public function changePositionoperating_company(Request $request){
        OperatingCompany::where('id', $request->id)->update(['position' => $request->position]);
    }
}
