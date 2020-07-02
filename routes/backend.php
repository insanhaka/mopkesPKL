<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// LOGIN
Route::get('/', function () {
    return view('auth.login');
})->name('admin.login');
Route::get('/login', function () {
    return view('auth.login');
})->name('admin.login');
Route::post('/login', 'LoginController@doLogin')->name('admin.dologin');

Route::group(['middleware' => ['auth:web'],'as'=>'admin.'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user/changepass', 'UserController@changePass')->name('user.changepass');
    Route::get('/user/{user}/resetpass','UserController@resetPass')->name('user.resetpass');
    Route::post('/user/changepass', 'UserController@updateChangePass')->name('user.updatechangepass');
    Route::match(['put', 'patch'], '/user/resetpass/{user}', 'UserController@updateResetPass')->name('user.updateresetpass');
    Route::resource('user', 'UserController');
    Route::post('user/delete', 'UserController@delete')->name('user.delete');

    Route::post('/menu/geturimenu', 'MenuController@getUriMenu')->name('menu.geturimenu');
    Route::resource('menu', 'MenuController');
    Route::post('menu/delete', 'MenuController@delete')->name('menu.delete');

    Route::resource('role', 'RoleController');
    Route::post('role/delete', 'RoleController@delete')->name('role.delete');

    Route::get('/permission/getdataserverside', 'PermissionController@getDataServerSide')->name('permission.getdataserverside');
    Route::resource('permission', 'PermissionController');
    Route::post('permission/delete', 'PermissionController@delete')->name('permission.delete');

    Route::resource('sector', 'SectorController');
    // Route::post('product/delete', 'ProductController@delete')->name('product.delete');
    Route::get('/sector/{id}/delete', 'SectorController@delete');

    Route::resource('business', 'BusinessController');
    // Route::post('seller/delete', 'SellerController@delete')->name('seller.delete');
    Route::get('/business/{id}/delete', 'BusinessController@delete');
    Route::post('/business/active', 'BusinessController@activation');

    Route::resource('agreement', 'AgreementController');
    // Route::post('agreement/delete', 'AgreementController@delete')->name('agreement.delete');
    Route::get('/agreement/{id}/delete', 'AgreementController@delete');

    Route::resource('report', 'ReportController');
    // Route::post('report/delete', 'ReportController@delete')->name('report.delete');
    Route::get('/report/{id}/delete', 'ReportController@delete');

    Route::resource('communities', 'CommunityController');
    // Route::post('kelompok/delete', 'KelompokController@delete')->name('kelompok.delete');
    Route::get('/communities/{id}/delete', 'CommunityController@delete');

    Route::match(['get', 'post'],'/logout','LoginController@doLogout')->name('logout');

    Route::post('/getRegenciesFromProvince', function (Request $request) {
        $arrRegencies = App\Regency::where('province_id', $request->paramid)->orderBy('name','asc')->pluck('id','name')->prepend('','');
        return response()->json(['code' => 200,'data' => $arrRegencies], 200);
    })->name('getregenciesfromprovince');

    Route::post('/getDistrictsFromRegency', function (Request $request) {
        $arrDistricts = App\District::where('regency_id', $request->paramid)->orderBy('name','asc')->pluck('id','name')->prepend('','');
        return response()->json(['code' => 200,'data' => $arrDistricts], 200);
    })->name('getdistrictsfromregency');

    Route::post('/getVillagesFromDistrict', function (Request $request) {
        $arrVillages = App\Village::where('district_id', $request->paramid)->orderBy('name','asc')->pluck('id','name')->prepend('','');
        return response()->json(['code' => 200,'data' => $arrVillages], 200);
    })->name('getvillagesfromdistrict');
});

// Route::get('/qrcode', 'ReportController@preview');
