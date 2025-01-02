<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerJourneyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductDiscoveryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';
Auth::routes();

Route::get('/home', 'App\Http\Controllers\DashboardController@index')->name('home')->middleware('auth');

Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('dashboard', DashboardController::class)->except(['show']);
    Route::put('tasks/{id}', [DashboardController::class, 'update'])->name('tasks.update');
});


Route::get('admin', function () {
    return redirect('admin/dashboards/main');
})->name('admin')->middleware('nova');


Route::group(['middleware' => 'auth'], function () {
    Route::resource('product', ProductController::class)->except(['show']);
    Route::get('product/search', [ProductController::class,'search'])->name('product.search');
});


Route::group(['middleware' => 'auth'], function () {
    Route::resource('productdiscovery', ProductDiscoveryController::class);
    Route::get('productdiscovery/{id}',[ProductDiscoveryController::class, 'show'])-> name ('productdiscovery.show');
});


Route::group(['middleware' => 'auth'], function () {
    Route::resource('customer', CustomerController::class)->except(['show']);
    Route::get('customer/search', [CustomerController::class, 'search'])->name('customer.search');
    Route::get('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('customerjourney', CustomerJourneyController::class)->except(['show']);
    Route::get('customerjourney/searchPhoneNumber', [CustomerJourneyController::class, 'searchPhoneNumber'])->name('customerjourney.searchPhoneNumber');
    Route::get('customerjourney/searchProducts', [CustomerJourneyController::class, 'searchProducts'])->name('customerjourney.searchProducts');
    Route::get('/customerjourney/searchJourneys', [CustomerJourneyController::class, 'searchJourneys'])->name('customerjourney.searchJourneys');
});


Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['middleware' => 'auth'], function () {
	Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
	Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
});