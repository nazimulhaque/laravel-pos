<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LocationTableDetailsController;
use App\Http\Controllers\PrinterGroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ModifiersCategoryController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('department', DepartmentController::class);
    Route::resource('location', LocationController::class);
    Route::resource('location_table_details', LocationTableDetailsController::class);
    Route::resource('tax', TaxController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('modifiers_category', ModifiersCategoryController::class);
    Route::resource('printer_group', PrinterGroupController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);

    Route::get('/new_location', [LocationController::class, 'newLocation'])->name('location.new_location');

    // Routes for search
    Route::get('/search_unit', [UnitController::class, 'search'])->name('unit.search');
    Route::get('/search_tax', [TaxController::class, 'search'])->name('tax.search');
});
