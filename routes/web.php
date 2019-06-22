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

Route::get('/', function () {
    return view('welcome');
});
// Admin  routes  for user
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Auth::routes();
    Route::get('password', 'UserController@getPassword');
    Route::post('password', 'UserController@postPassword');
    Route::get('/', 'ResourceController@home')->name('home');
    Route::get('/dashboard', 'ResourceController@dashboard')->name('dashboard');
    Route::resource('banner', 'BannerResourceController');
    Route::post('/banner/destroyAll', 'BannerResourceController@destroyAll');

    Route::resource('car', 'CarResourceController');
    Route::post('/car/destroyAll', 'CarResourceController@destroyAll')->name('car.destroy_all');
    Route::put('/car/updateField/{car}', 'CarResourceController@updateField')->name('car.update_field');
    Route::post('/car/destroyCarFinancial', 'CarResourceController@destroyCarFinancial')->name('car.destroy_car_financial');
    Route::post('/car/destroyCarColor', 'CarResourceController@destroyCarColor')->name('car.destroy_car_color');
    Route::get('brandColors', 'CarResourceController@brandColors')->name('car.brand_colors');

    Route::resource('brand', 'BrandResourceController');
    Route::post('/brand/destroyAll', 'BrandResourceController@destroyAll')->name('brand.destroy_all');

    Route::resource('order', 'OrderResourceController');
    Route::post('/order/destroyAll', 'OrderResourceController@destroyAll')->name('order.destroy_all');

    Route::resource('user', 'UserResourceController');
    Route::post('/user/destroyAll', 'UserResourceController@destroyAll')->name('user.destroy_all');

    Route::resource('financial_product', 'FinancialProductResourceController');
    Route::post('/financial_product/destroyAll', 'FinancialProductResourceController@destroyAll')->name('financial_product.destroy_all');

    Route::resource('system_page', 'SystemPageResourceController');
    Route::post('/system_page/destroyAll', 'SystemPageResourceController@destroyAll')->name('system_page.destroy_all');
    Route::get('/setting/company', 'SettingResourceController@company')->name('setting.company.index');
    Route::post('/setting/updateCompany', 'SettingResourceController@updateCompany');
    Route::get('/setting/publicityVideo', 'SettingResourceController@publicityVideo')->name('setting.publicity_video.index');
    Route::post('/setting/updatePublicityVideo', 'SettingResourceController@updatePublicityVideo');
    Route::get('/setting/station', 'SettingResourceController@station')->name('setting.station.index');
    Route::post('/setting/updateStation', 'SettingResourceController@updateStation');

    Route::resource('link', 'LinkResourceController');
    Route::post('/link/destroyAll', 'LinkResourceController@destroyAll')->name('link.destroy_all');
    Route::resource('permission', 'PermissionResourceController');
    Route::resource('role', 'RoleResourceController');



    Route::group(['prefix' => 'page','as' => 'page.'], function ($router) {
        Route::resource('page', 'PageResourceController');
        Route::resource('category', 'PageCategoryResourceController');

    });
    Route::group(['prefix' => 'page','as' => 'page.','namespace' => 'Page'], function ($router) {
        Route::get('/about_rent/show', 'AboutRentResourceController@show')->name('about_rent.show');
        Route::post('/about_rent/store', 'AboutRentResourceController@store')->name('about_rent.store');
        Route::put('/about_rent/update/{page}', 'AboutRentResourceController@update')->name('about_rent.update');
    });
    Route::group(['prefix' => 'menu'], function ($router) {
        Route::get('index', 'MenuResourceController@index');
    });

    Route::group(['prefix' => 'nav','as' => 'nav.'], function ($router) {
        Route::resource('nav', 'NavResourceController');
        Route::post('/nav/destroyAll', 'NavResourceController@destroyAll')->name('nav.destroy_all');
        Route::resource('category', 'NavCategoryResourceController');
        Route::post('/category/destroyAll', 'NavCategoryResourceController@destroyAll')->name('category.destroy_all');
    });

    Route::post('/upload/{config}/{path?}', 'UploadController@upload')->where('path', '(.*)');

    Route::resource('admin_user', 'AdminUserResourceController');
    Route::post('/admin_user/destroyAll', 'AdminUserResourceController@destroyAll')->name('admin_user.destroy_all');
    Route::resource('permission', 'PermissionResourceController');
    Route::post('/permission/destroyAll', 'PermissionResourceController@destroyAll')->name('permission.destroy_all');
    Route::resource('role', 'RoleResourceController');
    Route::post('/role/destroyAll', 'RoleResourceController@destroyAll')->name('role.destroy_all');
    Route::get('logout', 'Auth\LoginController@logout');
});
Route::group([
    'namespace' => 'Pc',
    'as' => 'pc.',
], function () {
    Auth::routes();
    Route::get('/user/login','Auth\LoginController@showLoginForm');
    Route::get('/','HomeController@home')->name('home');


    Route::get('email-verification/index','Auth\EmailVerificationController@getVerificationIndex')->name('email-verification.index');
    Route::get('email-verification/error','Auth\EmailVerificationController@getVerificationError')->name('email-verification.error');
    Route::get('email-verification/check/{token}', 'Auth\EmailVerificationController@getVerification')->name('email-verification.check');
    Route::get('email-verification-required', 'Auth\EmailVerificationController@required')->name('email-verification.required');

});


//Route::get('
///{slug}.html', 'PagePublicController@getPage');
/*
Route::group(
    [
        'prefix' => trans_setlocale() . '/admin/menu',
    ], function () {
    Route::post('menu/{id}/tree', 'MenuResourceController@tree');
    Route::get('menu/{id}/test', 'MenuResourceController@test');
    Route::get('menu/{id}/nested', 'MenuResourceController@nested');

    Route::resource('menu', 'MenuResourceController');
   // Route::resource('submenu', 'SubMenuResourceController');
});
*/