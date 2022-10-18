<?php

use Illuminate\Support\Facades\Route;

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
/*Route::get('/', function(){
    return \Illuminate\Support\Facades\Redirect::to('/login', 301);
});*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'admin'], function () {


    /***************** Start Route pdf *****************/
    Route::get('admin/invoice/invoice-pdf/{id}',[\App\Http\Controllers\Admin\AdminInvoiceController::class,'invoice_pdf']);
    Route::get('admin/factor/factor-pdf/{id}',[\App\Http\Controllers\Admin\AdminFactorController::class,'factor_pdf']);
    /***************** End Route pdf *****************/


    Route::resource('admin/dashboard', \App\Http\Controllers\Admin\AdminDashboardController::class);
    Route::get('admin/factors/delete-factor-row', [\App\Http\Controllers\Admin\AdminFactorController::class,'delete']);
    Route::resource('admin/members', \App\Http\Controllers\Admin\AdminMemberController::class);
    Route::resource('admin/factors', \App\Http\Controllers\Admin\AdminFactorController::class);
    Route::resource('admin/products', \App\Http\Controllers\Admin\AdminProductsController::class);
    Route::resource('admin/categories', \App\Http\Controllers\Admin\AdminCategoriseController::class);
    Route::resource('admin/brands', \App\Http\Controllers\Admin\AdminBrandsController::class);
    Route::resource('admin/profile', \App\Http\Controllers\Admin\AdminProfileController::class);
    Route::resource('admin/settings', \App\Http\Controllers\Admin\AdminSettingsController::class);
    Route::get('/admin/invoice/show-invoice/{id}', [\App\Http\Controllers\Admin\AdminInvoiceController::class,'show_invoice']);
    Route::resource('admin/invoice', \App\Http\Controllers\Admin\AdminInvoiceController::class);


    /***************** Start Admin Ajax *****************/
    Route::post('admin/Ajax/delete-all', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'delete_all_items'])->name('Ajax.delete-all-items');
    Route::post('admin/Ajax/delete-solo', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'delete_solo_item'])->name('Ajax.delete-solo-item');
    Route::post('admin/Ajax/delete-all-factors', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'delete_all_factors'])->name('Ajax.delete-all-factors');
    Route::post('admin/Ajax/delete-solo-factor', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'delete_solo_factor'])->name('Ajax.delete-solo-factor');
    Route::post('admin/Ajax/delete-solo-invoice', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'delete_solo_invoice'])->name('Ajax.delete-solo-invoice');
    Route::post('admin/Ajax/set-factor-row', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'set_factor_row'])->name('Ajax.set-factor-row');
    Route::post('admin/Ajax/update-factor', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'update_factor'])->name('Ajax.update-factor');
    Route::post('admin/Ajax/change-price', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'change_price'])->name('Ajax.change-price');
    Route::post('admin/Ajax/get-price-factor', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'get_price_factor'])->name('Ajax.get-price-factor');
    Route::post('admin/Ajax/get-price-factor-row', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'get_price_factor_row'])->name('Ajax.get-price-factor-row');
    Route::post('admin/Ajax/uploadimageprofile', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'uploadimageprofile'])->name('uploadimageprofile');
    Route::post('admin/Ajax/numberToword', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'numberToword'])->name('Ajax.numberToword');
    Route::post('admin/Ajax/get-product', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'get_product'])->name('Ajax.get-product');
    Route::post('admin/Ajax/get-product-price', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'get_product_price'])->name('Ajax.get-product-price');
    Route::post('admin/Ajax/get-brands', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'get_brands'])->name('Ajax.get-brands');
    Route::post('admin/Ajax/update-Ordering', [\App\Http\Controllers\Admin\Ajax\AdminAjaxController::class, 'updateOrdering'])->name('Ajax.updateOrdering');
    /***************** End Admin Ajax *****************/
});
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function(){
    return \Illuminate\Support\Facades\Redirect::to('/admin/factors', 301);
});
Route::get('/home', function(){
    return \Illuminate\Support\Facades\Redirect::to('/admin/factors', 301);
});
