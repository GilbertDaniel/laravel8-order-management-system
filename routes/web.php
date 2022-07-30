<?php

use App\Http\Controllers\Backend\ItemCategoryController;
use App\Http\Controllers\Backend\ProfileController;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    // user management routes
    Route::prefix('manageuser')->group(function () {
        Route::get('/account', function () {
            return view('backend.account.index');
        })->name('account');

        Route::get('/role', function () {
            return view('backend.role.index');
        })->name('role');

        Route::get('/permission', function () {
            return view('backend.permission.index');
        })->name('permission');
    });

    //user profile route
    Route::prefix('user')->group(function () {
        Route::get('/profile', function () {
            return view('backend.profile.index');
        })->name('profile');

        Route::put('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

        Route::put('/profile/changepassword', [ProfileController::class, 'changePassword'])
        ->name('profile.changepassword');
    });

    // item management routes
    Route::prefix('items')->group(function () {
        Route::get('/', function () {
            return view('backend.item.index');
        })->name('item');
    });

    // category management routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [ItemCategoryController::class, 'index'])
        ->name('categories');
    });

    // order management routes
    Route::prefix('orders')->group(function () {
        Route::get('/', function () {
            return view('backend.order.index');
        })->name('order');
    });
});

require __DIR__ . '/auth.php';
