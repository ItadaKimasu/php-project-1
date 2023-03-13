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
// Route::get('/reset-password/abc@gmail.com/123456', [UserController::class, 'myAction']);
Route::get('/reset-password/abc@gmail.com/123456', [UserController::class, 'reset'])->name('reset');



Route::post('/register', [UserController::class, 'saveUser']) -> name('auth.register');
Route::post('/', [UserController::class, 'loginUser']) -> name('auth.login');
Route::post('/forgot-password', [UserController::class, 'forgotPassword']) -> name('auth.forgot');
Route::post('/reset-password/abc@gmail.com/123456', [UserController::class, 'resetPassword']) -> name('auth.reset');

Route::group(['middleware' => ['LoginCheck']], function () {
    Route::get('/profile', [UserController::class, 'profile']) -> name('profile');
    Route::get('/', [UserController::class, 'index']);
    Route::get('/logout', [UserController::class, 'logout']) -> name('auth.logout');
    
});
Route::post('/profile-image', [UserController::class, 'profileImageUpdate']) -> name('profile.image');
Route::post('/profile-update', [UserController::class, 'profileUpdate']) -> name('profile.update');
