<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/forgot-password', [UserController::class, 'forgot']);
Route::get('/reset-password', [UserController::class, 'reset']);


Route::post('/register', [UserController::class, 'saveUser']) -> name('auth.register');
Route::post('/', [UserController::class, 'loginUser']) -> name('auth.login');


Route::group(['middleware' => ['LoginCheck']], function () {
    Route::get('/profile', [UserController::class, 'profile']) -> name('profile');
    Route::get('/', [UserController::class, 'index']);
    Route::get('/logout', [UserController::class, 'logout']) -> name('auth.logout');
    
});
Route::post('/profile-image', [UserController::class, 'profileImageUpdate']) -> name('profile.image');
Route::post('/profile-update', [UserController::class, 'profileUpdate']) -> name('profile.update');
