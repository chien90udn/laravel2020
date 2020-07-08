<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Session;
use function foo\func;

Auth::routes(['verify' => true]);

/*
* setting router for Front
*
*
*/




Route::get('locale/{locale}', function ($locale){
   Session::put('locale',$locale);
   return redirect()->back();
})->name('change-language');

Route::get('/', 'Front\ProductsController@index')->name('home');

Route::get('add-new','Front\ProductController@addnew')->name('add_new_product');
Route::get('products','Front\ProductController@products')->name('products');

//Contact
Route::post('detail/{id}', 'Front\ProductController@send_contact')->name('send_contact');

//Search
Route::post('/search', 'Front\ProductsController@search')->name('search');
Route::get('/search', 'Front\ProductsController@search')->name('search');
Route::get('/category/{id}', 'Front\ProductsController@search_category')->name('search_category');

//product
Route::get('detail/{id}', 'Front\ProductController@detail')->name('detail');


//agencies
Route::get('agencies', 'Front\AgenciesController@index')->name('agencies');



//Messages
Route::get('messages','Front\UsersController@messages')->name('messages');
Route::get('messages/{product_id}/{user_id_to}','Front\UsersController@messages_detail')->name('messages_detail');

// search front-end
Route::get('search/{type}/{cate_id}/{location_id}/{route_master_id?}', 'Front\SearchController@selectSearch')->name('select_search');
Route::post('search/{type}/{cate_id}/{location_id}/{route_master_id?}', 'Front\SearchController@selectSearch')->name('select_search');






//user

Route::prefix('user')->group(function () {
    Route::get('advancedSearch', 'Front\ProductsController@advanced_search')->name('advancedSearch');

    //Profile
    Route::get('profile', 'Front\UsersController@profile')->name('profile');
    Route::post('profile', 'Front\UsersController@changeProfile')->name('changeProfile');

    //Product manage
    Route::get('products','Front\ProductsController@products')->name('products');
    Route::get('add-new','Front\ProductsController@addnew')->name('add_new_product');
    Route::post('add-new','Front\ProductsController@postAddNew')->name('postAddNew');
    Route::get('product/edit/{id}' , 'Front\ProductsController@productEdit')->name('productEdit');
    Route::post('product/edit/{id}','Front\ProductsController@postEditProduct')->name('postEditProduct');

    Route::post('getRegion','Front\ProductsController@getRegion')->name('getRegion');
    Route::post('getCity','Front\ProductsController@getCity')->name('getCity');
    Route::post('getStation','Front\ProductsController@getStation')->name('getStation');

    Route::post('postAddProductTemp','Front\ProductsController@postAddProductTemp')->name('postAddProductTemp');
    Route::post('postDeleteProductTemp','Front\ProductsController@postDeleteProductTemp')->name('postDeleteProductTemp');
    Route::post('postUpdateProductTemp','Front\ProductsController@postUpdateProductTemp')->name('postUpdateProductTemp');

    Route::delete('product/delete-image','Front\ProductsController@deleteImageProduct')->name('deleteImageProduct');

    //
    Route::post('product/add-image','Front\ProductsController@addImage')->name('addImage');

    Route::get('product/delete/{id}' , 'Front\ProductsController@productDelete')->name('productDelete');

    //Change password
    Route::get('change-password', 'Front\UsersController@password')->name('password');
    Route::post('change-password', 'Front\UsersController@changePassword')->name('changePassword');

    //Message manage
    Route::get('messages','Front\MessagesController@getMessages')->name('getMessages');
    Route::get('messages/{type}/{reply_id}/{product_id}','Front\MessagesController@messageDetail')->name('messageDetail');
    Route::post('messages/{type}/{reply_id}/{product_id}','Front\MessagesController@replyMessage')->name('replyMessage');
    Route::post('replyMessageAdmin','Front\MessagesController@replyMessageAdmin')->name('replyMessageAdmin');

});


/*
* setting router for Admin
*
*
*/

Route::prefix('admin')->group(function () {

    Route::post('login', ['as' => 'admin.login', 'uses' => 'Auth\AdminLoginController@login']);

    Route::get('login', function (){
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.index');
        }
        $controller = \App()->make('\App\Http\Controllers\Auth\AdminLoginController');
        return $controller->callAction('showLoginForm', $parameters = array());
    })->name('admin.login');
    Route::get('password/request', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
});


Route::group(['middleware' => ['is_admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', 'Admin\AdminController@index')->name('index');
    Route::get('profile', 'Admin\AdminController@profile')->name('profile');
    Route::post('profile', 'Admin\AdminController@changePassword')->name('changePassword');

    Route::post('SetDefaultLang', 'Admin\LanguagesController@SetDefaultLang')->name('SetDefaultLang');

    Route::get('register','Auth\AdminLoginController@showRegisterPage');
    Route::post('updateApprove','Admin\ProductsController@updateApprove')->name('updateApprove');
    Route::post('updateHot','Admin\ProductsController@updateHot')->name('updateHot');
    Route::post('updateApproveMessage','Admin\MessagesController@updateApproveMessage')->name('updateApproveMessage');
//    Route::post('addImage','Admin\ProductsController@addImage')->name('addImage');
    Route::resource('users', 'Admin\UsersController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('categorys', 'Admin\CategoryController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);

    Route::resource('locations', 'Admin\LocationsController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::post('changePositionLocation', 'Admin\LocationsController@changePositionLocation')->name('changePositionLocation');

    Route::resource('messages', 'Admin\MessagesController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);

    Route::get('yourContact', 'Admin\MessagesController@yourContact')->name('yourContact');
    Route::post('replyContact', 'Admin\MessagesController@replyContact')->name('replyContact');
    Route::get('contactDetail/{id}/{reply_id}', 'Admin\MessagesController@contactDetail')->name('contactDetail');

    Route::get('yourMessage', 'Admin\MessagesController@yourMessage')->name('yourMessage');
    Route::get('yourMessageDetail/{user_id}', 'Admin\MessagesController@yourMessageDetail')->name('yourMessageDetail');
    Route::get('newMessage/{user_id}', 'Admin\MessagesController@newMessage')->name('newMessage');
    Route::post('sentMessageAdminNew', 'Admin\MessagesController@sentMessageAdminNew')->name('sentMessageAdminNew');
    Route::post('sentMessageAdmin', 'Admin\MessagesController@sentMessageAdmin')->name('sentMessageAdmin');


    Route::resource('currencies', 'Admin\CurrenciesController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('languages', 'Admin\LanguagesController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    //ltm translation
    Route::get('translations/update/{locale}', 'Admin\LtmTranslationController@update')->name('translations_update');
    Route::post('updateTranslation', 'Admin\LtmTranslationController@postUpdate')->name('postUpdate');

    Route::get('translations/searchKey', 'Admin\LtmTranslationController@search')->name('translations_search');
    Route::post('translations/searchKey', 'Admin\LtmTranslationController@searchKey')->name('searchKey');

    // manage keyword
    Route::get('translations/manageKey', 'Admin\LtmTranslationController@keyword_manage')->name('manage_keywords');
    Route::post('postSearchKey', 'Admin\LtmTranslationController@postSearchKey')->name('postSearchKey');

    Route::post('translations/addKey', 'Admin\LtmTranslationController@addKey')->name('addKey');
//    Route::post('translations/searchKey', 'Admin\LtmTranslationController@postSearchKey')->name('postSearchKey');
    Route::post('translations/deleteKey', 'Admin\LtmTranslationController@deleteKey');
    Route::post('translations/updateKey', 'Admin\LtmTranslationController@updateKey');

    Route::post('translations/autocomplete/fetch', 'Admin\LtmTranslationController@fetch');

    //
    Route::resource('city', 'Admin\CityMasterController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('floor_plan', 'Admin\FloorPlanMasterController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('operating_company', 'Admin\OperatingCompanyController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('region', 'Admin\RegionMasterController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);
    Route::resource('station', 'Admin\StationNameMasterController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);

    Route::resource('products', 'Admin\ProductsController')->only(['index', 'edit', 'update', 'show', 'destroy', 'create', 'store']);

});
