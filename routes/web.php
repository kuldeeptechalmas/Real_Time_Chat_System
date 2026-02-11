<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\HelpController;
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

Route::middleware('AuthToDashboard')->group(function () {

    Route::match(['get', 'post'], '/login', [MainController::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/registration', [MainController::class, 'registration'])->name('registration');
});
Route::match(['get', 'post'], '/forgotpassword', [MainController::class, 'forgotpassword'])->name('forgotpassword');
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
    Route::match(['get', 'post'], '/user-profile', [UserController::class, 'User_Profiles'])->name('user_profiles');
    Route::match(['get', 'post'], '/user-profile-image-remove', [UserController::class, 'user_profiles_image_remove'])->name('user_profiles_image_remove');
    Route::match(['get', 'post'], '/show-contact-info', [UserController::class, 'Show_Contact_Info'])->name('show.contact.info');

    // Pdf View and Download -> Not Ajax
    Route::match(['get', 'post'], '/pdf-view/{filename}', [UserController::class, 'pdf_view'])->name('pdf.view');
    Route::match(['get', 'post'], '/pdf-download/{filename}', [UserController::class, 'pdf_download'])->name('pdf.download');

    // Ajax
    Route::match(['get', 'post'], '/search-friend', [UserController::class, 'search_friend'])->name('search_friend');
    Route::match(['get', 'post'], '/user-select', [UserController::class, 'user_select_data'])->name('user_select_data');
    Route::match(['get', 'post'], '/message-send', [UserController::class, 'message_send_specific_user'])->name('message_send_specific_user');
    Route::match(['get', 'post'], '/message-show', [UserController::class, 'message_show_send_receive'])->name('message_show_send_receive');
    Route::match(['get', 'post'], '/message-clean', [UserController::class, 'message_clean'])->name('message.clean');

    Route::match(['get', 'post'], '/message-show-pusher', [UserController::class, 'message_show_send_receive_pusher'])->name('message_show_send_receive_pusher');
    Route::match(['get', 'post'], '/current-user-type-pusher', [UserController::class, 'Current_User_Type_Pusher'])->name('Current_User_Type_Pusher');

    Route::match(['get', 'post'], '/message-remove', [UserController::class, 'message_remove_current'])->name('message_remove_current');
    Route::match(['get', 'post'], '/message-remove-all', [UserController::class, 'message_remove_current_all'])->name('message_remove_current_all');
    Route::match(['get', 'post'], '/user-friend-list', [UserController::class, 'user_friend_list'])->name('user_friend_list');
    Route::match(['get', 'post'], '/user-send-request', [UserController::class, 'user_send_request'])->name('user_send_request');

    Route::match(['get', 'post'], '/user-notification', [UserController::class, 'user_show_notification'])->name('user_show_notification');
    Route::match(['get', 'post'], '/user-friendlist', [UserController::class, 'user_friendlist_show'])->name('user_friendlist_show');

    Route::match(['get', 'post'], '/user-request-remove', [UserController::class, 'user_request_remove'])->name('user_request_remove');
    Route::match(['get', 'post'], '/user-unfollow', [UserController::class, 'user_unfollow'])->name('user_unfollow');
    Route::match(['get', 'post'], '/user-request-accept', [UserController::class, 'user_request_accept'])->name('user_request_accept');

    Route::match(['get', 'post'], '/message-emoji-add', [UserController::class, 'message_emoji_add'])->name('message_emoji_add');
    Route::match(['get', 'post'], '/user-last-seen-time', [UserController::class, 'user_last_seen_time'])->name('user_last_seen_time');

    Route::match(['get', 'post'], '/edit-get-message', [UserController::class, 'Edit_Get_Message'])->name('edit.get_message');

    Route::match(['get', 'post'], '/user-forword-message', [UserController::class, 'user_forword_message'])->name('user_forword_message');

    // Star Add and Remove
    Route::match(['get', 'post'], '/star-friend', [UserController::class, 'user_star_show'])->name('user.star.show');

    Route::match(['get', 'post'], '/user-star-add', [UserController::class, 'user_star_add'])->name('user.star.add');
    Route::match(['get', 'post'], '/user-star-remove', [UserController::class, 'user_star_remove'])->name('user.star.remove');

    // Create Group
    Route::match(['get', 'post'], '/groups', [GroupController::class, 'Group_Show'])->name('group.show');

    Route::match(['get', 'post'], '/create-group-final', [GroupController::class, 'create_group_final'])->name('create.group.final');
    Route::match(['get', 'post'], '/create-group', [GroupController::class, 'create_group'])->name('create.group');

    Route::match(['get', 'post'], '/group-chatbort', [GroupController::class, 'Group_Chatbort'])->name('group.chatbort');
    Route::match(['get', 'post'], '/group-send-message', [GroupController::class, 'Group_Send_Message'])->name('group.send.message');
    Route::match(['get', 'post'], '/group-message-show', [GroupController::class, 'Group_Message_Show'])->name('group.message.show');

    Route::match(['get', 'post'], '/group-in-all-user', [GroupController::class, 'Group_user_Show_All'])->name('group.user.show.all');
    Route::match(['get', 'post'], '/group-exit', [GroupController::class, 'Group_Exit'])->name('group.exit');

    Route::match(['get', 'post'], '/group-message-emoji', [GroupController::class, 'Group_Message_Emoji'])->name('group.message.emoji');
    Route::match(['get', 'post'], '/group-message-remove', [GroupController::class, 'Group_Message_Remove'])->name('group.message.remove');
    Route::match(['get', 'post'], '/group-message-remove-all', [GroupController::class, 'Group_Message_Remove_All'])->name('group.message.remove.all');
    Route::match(['get', 'post'], '/group-forword-message', [GroupController::class, 'Group_Forword_Message'])->name('group.forword.message');
    Route::match(['get', 'post'], '/group-add-friend-page', [GroupController::class, 'Group_Friend_add_Page'])->name('group.add.friend.page');
    Route::match(['get', 'post'], '/group-add-friend', [GroupController::class, 'Group_In_Add_Friend'])->name('group.add.friend');
    Route::match(['get', 'post'], '/group-friend-remove', [GroupController::class, 'Group_Friend_Remove'])->name('group.friend.remove');
    Route::match(['get', 'post'], '/group-image-store', [GroupController::class, 'Group_Image_Store'])->name('group.image.store');
    Route::match(['get', 'post'], '/group-image-remove', [GroupController::class, 'Group_Image_Remove'])->name('group.image.remove');
    Route::match(['get', 'post'], '/group-message-clean', [GroupController::class, 'Group_Message_Clean'])->name('group.message.clean');
    Route::match(['get', 'post'], '/group-search', [GroupController::class, 'Group_Search'])->name('group.search');

    Route::match(['get', 'post'], '/group-message-view-pusher', [GroupController::class, 'Group_Message_View_Pusher'])->name('group.message.view.pusher');

    Route::match(['get', 'post'], '/help', [HelpController::class, 'Help_Page'])->name('help.page');
    Route::match(['get', 'post'], '/help-user-select', [HelpController::class, 'Help_user_select'])->name('help.user.select');

    Route::match(['get', 'post'], '/Get_Message_Not_View_Count', [UserController::class, 'Get_Message_Not_View_Count'])->name('get.message.not.view.count');
});
