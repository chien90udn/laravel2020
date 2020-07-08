<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\LtmTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Config;

class LtmTranslationController extends Controller
{
    public function update($locale)
    {
        $translations = LtmTranslation::where('locale', $locale)->get();
        return view('admin.languages.translationUpdate')->with('translations', $translations);
    }

    public function postUpdate(Request $request)
    {
        $locale = $request->locale;
        $id = $request->id;
        $value = $request->value;
        $tran = LtmTranslation::find($id);
        $tran->translation = $value;
        $tran->save();


        $translations = LtmTranslation::where('locale', $locale)->get();

        $arrar_start = "<?php return[";
        $arrar_body = '';

        foreach ($translations as $arr) {
            $arrar_body = $arrar_body . "'" . addslashes($arr->value) . "'" . "=>'" . addslashes($arr->translation) . "',";
        }
        $arrar_end = "];";
        $arra_lang = $arrar_start . $arrar_body . $arrar_end;
        $myfile = fopen(resource_path('lang/' . $locale . '/front.php'), 'w');
        fwrite($myfile, $arra_lang);

    }

    //
    public function search()
    {
        return view('admin.languages.search');
    }

    //
    public function searchKey(Request $request)
    {
        $key = $request->input('locale');
        $translations = LtmTranslation::where('value', 'LIKE', "%{$key}%")->where('parent_id', '<>', 0)->get();
        return view('admin.languages.search')->with('translations', $translations);
    }

    public function fetch(Request $request)
    {

        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('ltm_translations')
                ->select('value')
                ->distinct()
                ->where('value', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get();
            if (count($data) > 0) {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '
       <li class="getKey"><a href="#">' . $row->value . '</a></li>
       ';
                }
                $output .= '</ul>';
                echo $output;
            } else {
                echo $output = '<ul class="dropdown-menu" style="display:block; position:relative"><span style="color: red; padding: 10px">No data found</span></ul>';
            }

        }
    }


// Danh sách key
    public function keyword_manage()
    {
        $translations = LtmTranslation::where('parent_id', Config::get('settings.PARENT_ID_DEFAULT'))->get();
        return view('admin.languages.keyword_manage')->with('translations', $translations);
    }


    // Delete key
    public function deleteKey(Request $request)
    {
        LtmTranslation::where('id', $request->id)->orWhere('parent_id', $request->id)->delete();

        $getLocale = Language::get(); //lấy được locale

        foreach ($getLocale as $getLoc) {

            $local = $getLoc->short_name;
            $getTranslationsKey = LtmTranslation::where('parent_id', '<>', Config::get('settings.PARENT_ID_DEFAULT'))->where('locale', $local)->get();
            $arrar_start = "<?php return[";
            $arrar_body = '';
            foreach ($getTranslationsKey as $getTran) {
                $arrar_body = $arrar_body . "'" . addslashes($getTran->value) . "'" . "=>'" . addslashes($getTran->translation) . "',";
            }
            $arrar_end = "];";
            $arra_lang = $arrar_start . $arrar_body . $arrar_end;
            $myfile = fopen(resource_path('lang/' . $local . '/front.php'), 'w');
            fwrite($myfile, $arra_lang);
        }
    }

    // Search key
    public function postSearchKey(Request $request){
        $key=$request->input('locale');
        $translations = LtmTranslation::where('value', 'LIKE', "%{$key}%")->where('parent_id',Config::get('settings.PARENT_ID_DEFAULT'))->get();
        return view('admin.languages.keyword_manage')->with('translations', $translations);
    }

    // Add key

    public function addKey(Request $request)
    {

        $value = $request->keyword;
        $tran = new LtmTranslation();
        $tran->status = 1;
        $tran->value = $value;
        $tran->translation = '';
        $tran->save();

        $getLocale = Language::get(); //lấy được locale

        foreach ($getLocale as $getLoc){

            $locale=$getLoc->short_name;
            $tran1 = new LtmTranslation();
            $tran1->status = 1;
            $tran1->value = $value;
            $tran1->locale=$locale;
            $tran1->translation = '';
            $tran1->parent_id = $tran->id;
            $tran1->save();

            $getTranslationsKey=LtmTranslation::where('parent_id','<>',Config::get('settings.PARENT_ID_DEFAULT'))->where('locale', $locale)->get();
            $arrar_start = "<?php return[";
            $arrar_body = '';
            foreach ($getTranslationsKey as $getTran){
                $arrar_body = $arrar_body . "'" . addslashes($getTran->value) . "'" . "=>'".addslashes($getTran->translation)."',";
            }
            $arrar_end = "];";
            $arra_lang = $arrar_start . $arrar_body . $arrar_end;
            $myfile = fopen(resource_path('lang/'.$locale.'/front.php'), 'w');
            fwrite($myfile, $arra_lang);
        }
        Session::flash('success', 'Add successfully!');
        return redirect()->route('admin.manage_keywords');

    }


    //Update key
    public function updateKey(Request $request){
        $id = $request->id;
        $value = $request->value;
        LtmTranslation::where(function($query) use ($id){
            $query->where('id', $id)
                ->orWhere('parent_id', $id);
        })
            ->update(['value'=>$value]);


        $getLocale = Language::get(); //lấy được locale

        foreach ($getLocale as $getLoc) {
            $locale=$getLoc->short_name;
            $getTranslationsKey = LtmTranslation::where('parent_id', '<>', Config::get('settings.PARENT_ID_DEFAULT'))->where('locale', $locale)->get();
            $arrar_start = "<?php return[";
            $arrar_body = '';
            foreach ($getTranslationsKey as $getTran) {
                $arrar_body = $arrar_body . "'" . addslashes($getTran->value) . "'" . "=>'" . addslashes($getTran->translation) . "',";
            }
            $arrar_end = "];";
            $arra_lang = $arrar_start . $arrar_body . $arrar_end;
            $myfile = fopen(resource_path('lang/' . $locale . '/front.php'), 'w');
            fwrite($myfile, $arra_lang);
        }

    }
}
