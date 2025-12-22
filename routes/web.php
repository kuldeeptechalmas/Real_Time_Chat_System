<?php

use App\Http\Controllers\MainController;
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

Route::redirect('/', '/login');
Route::match(['get', 'post'], '/login', [MainController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/registration', [MainController::class, 'registration'])->name('registration');
Route::match(['get', 'post'], '/logout', [MainController::class, 'logout'])->name('logout');
Route::match(['get'], '/error', [MainController::class, 'main_error'])->name('main_error');

Route::middleware('RegisterUserExist')->group(function () {
    // Email Verification
    Route::match(['get', 'post'], '/email-verification', [MainController::class, 'email_verification'])->name('email_verification');
    Route::match(['get', 'post'], '/email-generate', [MainController::class, 'email_generate'])->name('email_generate');
});

Route::middleware('AuthCheckExist')->group(function () {
    // Dashboard
    Route::match(['get', 'post'], '/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/user-profile', [UserController::class, 'user_profiles'])->name('user_profiles');

    // Ajax
    Route::match(['get', 'post'], '/search-friend', [UserController::class, 'search_friend'])->name('search_friend');
    Route::match(['get', 'post'], '/user-select', [UserController::class, 'user_select_data'])->name('user_select');
    Route::match(['get', 'post'], '/message-send', [UserController::class, 'message_send_specific_user'])->name('message_send_specific_user');
    Route::match(['get', 'post'], '/message-show', [UserController::class, 'message_show_send_receive'])->name('message_show_send_receive');
    Route::match(['get', 'post'], '/message-remove', [UserController::class, 'message_remove_current'])->name('message_remove_current');
    Route::match(['get', 'post'], '/message-remove-all', [UserController::class, 'message_remove_current_all'])->name('message_remove_current_all');
    Route::match(['get', 'post'], '/user-friend-list', [UserController::class, 'user_friend_list'])->name('user_friend_list');
});
