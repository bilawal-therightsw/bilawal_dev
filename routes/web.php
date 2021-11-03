<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
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
    return redirect('login');
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    // products
    Route::resource('products', ProductController::class);
    Route::get('/products-dt', [ProductController::class, 'datatable'])->name('products-dt');
    // users
    Route::resource('users', UserController::class);
    Route::get('/users-dt', [UserController::class, 'datatable'])->name('users-dt');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff-dt', [StaffController::class, 'datatable'])->name('staff-dt');
});


require __DIR__.'/auth.php';
