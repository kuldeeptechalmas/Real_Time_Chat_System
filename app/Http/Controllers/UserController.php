<?php

namespace App\Http\Controllers;

use App\Events\EmojiResponseEvent;
use App\Events\SenderTypingEvent;
use App\Events\SendFollowNotification;
use App\Events\SendMeesages;
use App\Events\UserFollowORUnFollowEvent;
use App\Events\ViewToReceiver;
use App\Models\Friendship;
use App\Models\Group;
use App\Models\GroupMessageDeleteAt;
use App\Models\GroupUser;
use App\Models\HelpMessagesTable;
use App\Models\Message;
use App\Models\StarUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\File\File;

class UserController extends Controller
{
    // User Profiles
    public function User_Profiles(Request $request)
    {
        if (Auth::check()) {

            if ($request->isMethod('post')) {
                $Validator = Validator::make($request->all(), [
                    'username' => [
                        'required',
                        'string',
                        'alpha_dash',
                        Rule::unique('users', 'name')->ignore($request->id)
                    ],
                    'phone' => [
                        'required',
                        'numeric',
                        'digits:10',
                        Rule::unique('users', 'phone')->ignore($request->id)
                    ],
                    'email' => [
                        'required',
                        'email',
                        'email:rfc,dns',
                        'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo|yopmail)\.com$/',
                        Rule::unique('users', 'email')->ignore($request->id)
                    ],
                    'file' => 'image|mimes:jpeg,png,jpg|max:2048',
                ], [
                    'username.required' => 'Enter User Name is Required',
                    'gender.required' => 'Enter Gender is Required',
                    'username.alpha_dash' => 'Enter Only Letters, Numbers, Dashes and Underscores is Required',
                    'username.unique' => 'Enter User Name is Already Exist',
                    'phone.required' => 'Enter Phone No. is Required',
                    'phone.unique' => 'Enter Phone No. is Already Exist',
                    'phone.numeric' => 'Enter Only Digits is Required',
                    'phone.digits' => 'Enter 10 Digits is Required',
                    'email.required' => 'Enter Email Address is Required',
                    'email.unique' => 'Enter Email Address is Already Exist',
                    'email.email' => 'Enter Valid Email Address is Required',
                    'email.regex' => 'Enter only Gmail,Yahoo,Yopmail Domain is Required',
                    'file.image' => 'Enter Only Images is Required',
                    'file.mimes' => 'Enter Images is Jpg or Png Required',
                    'file.max' => 'Enter Images is Max Size 2 MB Required',
                ]);

                if ($Validator->fails()) {
                    return redirect()->back()->withInput()->withErrors($Validator);
                }

                $user_Modify_Data = User::find($request->id);

                if (isset($user_Modify_Data)) {

                    $user_Modify_Data->name = $request->username;
                    $user_Modify_Data->phone = $request->phone;
                    $user_Modify_Data->email = $request->email;
                    $user_Modify_Data->gender = $request->gender;
                    $user_Modify_Data->save();
                }

                if (isset($request->file)) {
                    $files = $request->file("file");
                    $files->storeAs("public/img", $files->getClientOriginalName());
                    $user_Modify_Data->image_path = $files->getClientOriginalName();
                    $user_Modify_Data->save();
                }

                Auth::login($user_Modify_Data);
                return redirect()->route('dashboard');
            }
            return view('User.user_profile');
        } else {
            return redirect()->route('login');
        }
    }

    // User Profiles Image Remove
    public function user_profiles_image_remove(Request $request)
    {
        if (Auth::check()) {
            $find_user_of_Auth = User::find(Auth::id());
            if (isset($find_user_of_Auth)) {

                $find_user_of_Auth->image_path = null;
                $find_user_of_Auth->save();

                Auth::login($find_user_of_Auth);
            }
            return redirect()->route('user_profiles');
        } else {
            return redirect()->route('main_error');
        }
    }

    public function Show_Contact_Info(Request $request)
    {
        if (Auth::check()) {
            $get_Select_User_Data = User::find($request->select_user_id);
            if (!empty($get_Select_User_Data)) {
                return view('User.Show_Contact_Info', ['select_user_data' => $get_Select_User_Data]);
            }
        } else {
            return response()->json(['not found data']);
        }
    }

    // Search user Friend 
    public function search_friend(Request $request)
    {
        if ($request->searchdata != '') {
            $user_Find_Data = User::where('name', 'like', "%" . $request->searchdata . "%")
                ->where('id', '!=', Auth::id())
                ->where('email', '!=', "admin12@yopmail.com")
                ->get();
            if (isset($user_Find_Data)) {

                return view('User.searchfriend', ["user_data" => $user_Find_Data]);
            } else {

                return response()->json(['error' => 'not found data']);
            }
        } else {
            $message_data_order = Message::select('send_id', 'receive_id')
                ->selectRaw('MAX(created_at) as last_message_time')
                ->where('send_id', Auth::user()->id)
                ->orWhere('receive_id', Auth::user()->id)
                ->where('send_id', '!=', 3)
                ->where('receive_id', '!=', 3)
                ->groupBy('send_id', 'receive_id')
                ->orderByDesc('last_message_time')
                ->get();

            $extra_collect = $message_data_order;

            for ($i = 0; $i < $message_data_order->count(); $i++) {
                $fresh_send_id = $message_data_order[$i]->send_id;
                $fresh_receive_id = $message_data_order[$i]->receive_id;
                $fresh_ct = $message_data_order[$i]->last_message_time;

                for ($j = 0; $j < $extra_collect->count(); $j++) {
                    if ($fresh_send_id == $extra_collect[$j]->receive_id && $fresh_receive_id == $extra_collect[$j]->send_id) {
                        if ($fresh_receive_id == Auth::id()) {
                            $message_data_order[$i]->send_id = $extra_collect[$j]->send_id;
                            $message_data_order[$i]->receive_id = $extra_collect[$j]->receive_id;
                            $message_data_order[$j]->last_message_time = $fresh_ct;
                        }
                    }
                }
            }

            $uniqueConversations = $message_data_order->unique(function ($item) {
                $participants = [$item->send_id, $item->receive_id];
                sort($participants);
                return implode('-', $participants);
            });

            $finalUserList = $uniqueConversations->values();

            $filtered = $finalUserList->filter(function ($value) {
                return $value->receive_id != 3;
            });

            if (isset($filtered)) {

                return view('User.searchfriend', ["last_message_send_data" => $filtered]);
            } else {
                return redirect()->route('main_error');
            }
        }
    }

    // User Select friend Data Show
    public function user_select_data(Request $request)
    {
        $select_user_id = $request->select_user_id;

        // Help User System use this Code
        if (Auth::id() == 3) {
            $user_Select_to_show = User::find($request->select_user_id);

            if ($user_Select_to_show) {
                $message_view_ok = Message::where('send_id', $request->select_user_id)->where('receive_id', Auth::id())->get();

                if (isset($message_view_ok)) {
                    foreach ($message_view_ok as $item) {
                        $item->status = 'view';
                        $item->save();
                    }
                }

                $data = array('send_id' => $request->select_user_id, 'receive_id' => Auth::id());
                event(new ViewToReceiver($data));

                if (isset($user_Select_to_show)) {
                    Session::put('chatboart_user_id', $user_Select_to_show->id);

                    return view('User.chatboard', ['user_send_user_data' => $user_Select_to_show]);
                } else {

                    return response()->json(['error' => 'not found data for user']);
                }
            } else {
                return response()->json(['error' => "Not found user data"]);
            }
        }

        $check_this_friend = Friendship::where(function ($query) use ($select_user_id) {
            $query->where('sender_user_id', Auth::id())
                ->where('receiver_user_id', $select_user_id);
        })->first();

        // This in User Receive message then Update status
        if (!isset($check_this_friend)) {
            if ($request->select_user_id != 3) {

                $check_this_friend_receiver = Friendship::where(function ($query) use ($select_user_id) {
                    $query->where('receiver_user_id', Auth::id())
                        ->where('sender_user_id', $select_user_id)
                        ->where('status', 1);
                })->first();

                if (isset($check_this_friend_receiver)) {

                    $user_Select_to_show = User::with(['starUserFind' => function ($query) {
                        $query->where('current_user_id', Auth::id());
                    }])->find($request->select_user_id);

                    if ($user_Select_to_show) {
                        $message_view_ok = Message::where('send_id', $request->select_user_id)->where('receive_id', Auth::id())->get();
                        if (isset($message_view_ok)) {
                            foreach ($message_view_ok as $item) {
                                $item->status = 'view';
                                $item->save();
                            }
                        }

                        $data = array('send_id' => $request->select_user_id, 'receive_id' => Auth::id());

                        event(new ViewToReceiver($data));

                        if (isset($user_Select_to_show)) {
                            Session::put('chatboart_user_id', $user_Select_to_show->id);

                            return view('User.chatboard', ['user_send_user_data' => $user_Select_to_show]);
                        } else {

                            return response()->json(['error' => 'not found data for user']);
                        }
                    } else {
                        return response()->json(['error' => "Not found user data"]);
                    }
                }
                $select_user_data = User::where('id', $request->select_user_id)->first();

                $check_select_user_give_request = Friendship::where(function ($query) use ($select_user_id) {
                    $query->where('receiver_user_id', Auth::id())
                        ->where('sender_user_id', $select_user_id);
                })->first();

                return view('User.send_accespt_request', ['users_data' => $select_user_data, 'user_can_request' => $check_select_user_give_request]);
            }
        } else {
            if ($check_this_friend->status == 0) {

                $select_user_data = User::where('id', $request->select_user_id)->first();
                return view('User.send_accespt_request', ['users_data' => $select_user_data, 'requested' => 'yes']);
            }

            // Message Show To ViewREceiver Code
            $user_Select_to_show = User::find($request->select_user_id);

            if ($user_Select_to_show) {
                $message_view_ok = Message::where('send_id', $request->select_user_id)->where('receive_id', Auth::id())->get();
                if (isset($message_view_ok)) {
                    foreach ($message_view_ok as $item) {
                        $item->status = 'view';
                        $item->save();
                    }
                }

                $data = array('send_id' => $request->select_user_id, 'receive_id' => Auth::id());
                event(new ViewToReceiver($data));
                if (isset($user_Select_to_show)) {
                    Session::put('chatboart_user_id', $user_Select_to_show->id);

                    return view('User.chatboard', ['user_send_user_data' => $user_Select_to_show]);
                } else {

                    return response()->json(['error' => 'not found data for user']);
                }
            } else {
                return response()->json(['error' => "Not found user data"]);
            }
        }
    }

    // Pusher Refresher
    public function message_show_send_receive_pusher(Request $request)
    {
        if (Auth::check()) {

            $message_view_ok = Message::where('send_id', $request->select_user_id)->where('receive_id', Auth::id())->get();
            if (isset($message_view_ok)) {
                foreach ($message_view_ok as $item) {
                    $item->status = 'view';
                    $item->save();
                }
            }

            $data = array('send_id' => $request->select_user_id, 'receive_id' => Auth::id());
            event(new ViewToReceiver($data));
            return response()->json(['data' => 'ok']);
        } else {
            return redirect()->route('main_error');
        }
    }

    // User Show Notification
    public function user_show_notification(Request $request)
    {
        $current_user_notification = Friendship::with('sendersData')
            ->where('receiver_user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        foreach ($current_user_notification as  $value) {
            $value->seen = "yes";
            $value->save();
        }

        if (isset($current_user_notification)) {
            return view('User.user_notification', ['friendlistrequest' => $current_user_notification]);
        } else {
            return redirect()->route('main_error');
        }
    }

    // Unfollow by id
    public function user_unfollow(Request $reqeust)
    {
        if (Auth::check()) {
            $unfollow_user = Friendship::find($reqeust->delete_id);
            if (isset($unfollow_user)) {
                $unfollow_user->delete();
                // event(new UserFollowORUnFollowEvent());
                return response()->json(['data' => 'yes']);
            }
        } else {
            return redirect()->route('main_error');
        }
    }

    public function temp(Request $request)
    {
        return view('temp');
    }
    public function store(Request $request)
    {
        if (isset($request->audio)) {
            $path = $request->file('audio')->store('audio', 'public');
        }
    }



    // Message send Specific User
    public function message_send_specific_user(Request $request)
    {
        if (Auth::check()) {

            // edit message then user 
            if (isset($request->edit_message_id)) {
                $message_data = Message::where('id', $request->edit_message_id)
                    ->first();

                $message_data->message = $request->message;
                $message_data->save();

                $get_with_message_user = Message::with('sender')->find($message_data->id);

                if (isset($get_with_message_user)) {
                    event(new SendMeesages($get_with_message_user->toArray()));
                }
            } else {

                // forword message then user
                if (isset($request->receive_data_id_array)) {

                    foreach ($request->receive_data_id_array as $data) {

                        $message_data = new Message();
                        $message_data->message = $request->message;
                        $message_data->send_id = Auth::user()->id;
                        $message_data->receive_id = $data;
                        $message_data->status = 'send';
                        $message_data->save();
                    }
                } else {

                    if ($files = $request->file('files')) {
                        foreach ($files as $file) {
                            $file->storeAs('public/img', $file->getClientOriginalName());
                            $message_data = new Message();
                            $message_data->message = $file->getClientOriginalName();
                            $message_data->send_id = Auth::user()->id;
                            $message_data->receive_id = $request->receive_data_id;
                            $message_data->status = 'send';
                            $message_data->save();

                            $get_with_message_user = Message::with('sender')->find($message_data->id);

                            if (isset($get_with_message_user)) {
                                event(new SendMeesages($get_with_message_user->toArray()));
                            }
                        }
                    } else {
                        try {
                            $message_data = new Message();
                            $message_data->message = $request->message;
                            $message_data->send_id = Auth::user()->id;
                            $message_data->receive_id = $request->receive_data_id;
                            $message_data->status = 'send';
                            $message_data->save();

                            $get_with_message_user = Message::with('sender')->find($message_data->id);

                            if (isset($get_with_message_user)) {
                                event(new SendMeesages($get_with_message_user->toArray()));
                            }
                        } catch (Exception $e) {
                            return response()->json([
                                'error' => 'String To Be Long'
                            ]);
                        }
                    }
                }
            }

            $message_data['name'] = $message_data->user_data_to_message->name;
            $userid = Auth::id();
            $selectuserid = $request->receive_data_id;

            $message_data_to_show = Message::where(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $userid)->whereNull('sender_deleted_at')
                    ->where('receive_id', $selectuserid);
            })->orWhere(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $selectuserid)
                    ->where('receive_id', $userid)->whereNull('receiver_deleted_at');
            })->orderBy('created_at', "asc")->get();

            if (isset($message_data_to_show)) {
                return view('User.show_message', ['message' => $message_data_to_show]);
            } else {
                return response()->json(['error' => 'message data not show']);
            }
        } else {
            return redirect()->route('login');
        }
    }

    // User Friend Panel
    public function message_show_send_receive(Request $request)
    {
        $userid = Auth::id();
        $selectuserid = $request->select_user_id;

        $message_data_to_show = Message::where(function ($query) use ($userid, $selectuserid) {
            $query->where('send_id', $userid)->whereNull('sender_deleted_at')
                ->where('receive_id', $selectuserid);
        })->orWhere(function ($query) use ($userid, $selectuserid) {
            $query->where('send_id', $selectuserid)
                ->where('receive_id', $userid)->whereNull('receiver_deleted_at');
        })->orderBy('created_at', "asc")->get();

        if (isset($message_data_to_show)) {
            return view('User.show_message', ['message' => $message_data_to_show]);
        } else {
            return response()->json(['error' => 'not found data for user messages']);
        }
    }

    // Message Clean of All
    public function message_clean(Request $request)
    {
        $message_data = Message::find($request->message_id);
        $sender_id = $message_data->receive_id;
        if (isset($message_data)) {
            $message_data->message = "This Message is Deleted";
            $message_data->status = 'send';
            $message_data->save();

            $userid = $message_data->send_id;
            $selectuserid = $message_data->receive_id;

            $get_with_message_user = Message::with('sender')->find($message_data->id);

            if (isset($get_with_message_user)) {
                event(new SendMeesages($get_with_message_user->toArray()));
            }

            $message_data_to_show = Message::where(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $userid)->whereNull('sender_deleted_at')
                    ->where('receive_id', $selectuserid);
            })->orWhere(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $selectuserid)
                    ->where('receive_id', $userid)->whereNull('receiver_deleted_at');
            })->orderBy('created_at', "asc")->get();

            if (isset($message_data_to_show)) {
                return view('User.show_message', ['message' => $message_data_to_show]);
            } else {
                return response()->json(['error' => 'message data not show']);
            }

            return response()->json(['message_user' => $sender_id]);
        } else {
            return response()->json(['data' => "not found data"]);
        }
    }

    // Message remove Specific To User
    public function message_remove_current(Request $request)
    {
        $message_Remove = Message::find($request->messageid);
        $message_users = 0;
        if (isset($message_Remove)) {
            if ($message_Remove->send_id == Auth::id()) {
                $message_users = $message_Remove->receive_id;
                $message_Remove->sender_deleted_at = now();
                $message_Remove->save();
            }
            if ($message_Remove->receive_id == Auth::id()) {
                $message_users = $message_Remove->send_id;
                $message_Remove->receiver_deleted_at = now();
                $message_Remove->save();
            }
        }
        return response()->json(['message_user' => $message_users]);
    }

    // Remove all Messages For Current open User
    public function message_remove_current_all(Request $request)
    {
        $userid = Auth::id();
        $selectuserid = $request->messageuserid;

        $message_data_to_show = Message::where(function ($query) use ($userid, $selectuserid) {
            $query->where('send_id', $userid)->whereNull('sender_deleted_at')
                ->where('receive_id', $selectuserid);
        })->orWhere(function ($query) use ($userid, $selectuserid) {
            $query->where('send_id', $selectuserid)
                ->where('receive_id', $userid)->whereNull('receiver_deleted_at');
        })->orderBy('created_at', "asc")->get();

        if (isset($message_data_to_show)) {

            foreach ($message_data_to_show as $item) {
                if ($item->send_id == Auth::id()) {
                    $item->sender_deleted_at = now();
                    $item->save();
                }
                if ($item->receive_id == Auth::id()) {
                    $item->receiver_deleted_at = now();
                    $item->save();
                }
            }
        }
        return response()->json(['allclean' => 'yes']);
    }

    // Get User Friend Panel List
    public function user_friend_list(Request $request)
    {
        $message_data_order = Message::select('send_id', 'receive_id')
            ->selectRaw('MAX(created_at) as last_message_time')
            ->where('send_id', Auth::user()->id)
            ->orWhere('receive_id', Auth::user()->id)
            ->where('send_id', '!=', 3)
            ->where('receive_id', '!=', 3)
            ->groupBy('send_id', 'receive_id')
            ->orderByDesc('last_message_time')
            ->get();

        $extra_collect = $message_data_order;

        for ($i = 0; $i < $message_data_order->count(); $i++) {
            $fresh_send_id = $message_data_order[$i]->send_id;
            $fresh_receive_id = $message_data_order[$i]->receive_id;
            $fresh_ct = $message_data_order[$i]->last_message_time;

            for ($j = 0; $j < $extra_collect->count(); $j++) {
                if ($fresh_send_id == $extra_collect[$j]->receive_id && $fresh_receive_id == $extra_collect[$j]->send_id) {
                    if ($fresh_receive_id == Auth::id()) {
                        $message_data_order[$i]->send_id = $extra_collect[$j]->send_id;
                        $message_data_order[$i]->receive_id = $extra_collect[$j]->receive_id;
                        $message_data_order[$j]->last_message_time = $fresh_ct;
                    }
                }
            }
        }

        $uniqueConversations = $message_data_order->unique(function ($item) {
            $participants = [$item->send_id, $item->receive_id];
            sort($participants);
            return implode('-', $participants);
        });

        $finalUserList = $uniqueConversations->values();

        $filtered = $finalUserList->filter(function ($value) {
            return $value->receive_id != 3;
        });

        foreach ($filtered as  $value) {
            $Message_Not_View_Count_Data = Message::where('receive_id', $value->send_id)
                ->where('send_id', $value->receive_id)
                ->where('status', 'send')
                ->get();
            $value['message_count'] = $Message_Not_View_Count_Data->count();
        }

        if (isset($message_data_order)) {

            return view('User.searchfriend', ["last_message_send_data" => $filtered]);
        } else {
            return response()->json(['data' => "data is not found"]);
        }
    }

    // Request Send in Other User
    public function user_send_request(Request $request)
    {
        if (Auth::check()) {
            $send_request_user_exist = User::find($request->select_id);
            if (isset($send_request_user_exist)) {

                $new_friend = new Friendship();
                $new_friend->sender_user_id = Auth::id();
                $new_friend->receiver_user_id  = $request->select_id;
                $new_friend->status  = 0;
                $new_friend->seen  = "no";
                $new_friend->save();
                $data_notification = array('receiver_id' => $new_friend->receiver_user_id, 'sender_name' => $new_friend->sendersData->name);
                event(new SendFollowNotification($data_notification));

                return response()->json(['Data' => "ok"]);
            } else {
                return response()->json(['Data' => 'User not Found']);
            }
        }
    }

    // User Remove Request
    public function user_request_remove(Request $request)
    {
        if (Auth::check()) {
            $remove_friend_request = Friendship::where('sender_user_id', Auth::id())->where('receiver_user_id', $request->select_user_id)->first();
            if (isset($remove_friend_request)) {

                $data_notification = array('receiver_id' => $remove_friend_request->receiver_user_id, 'sender_name' => $remove_friend_request->sendersData->name, 'unfollow' => 'yes');
                event(new SendFollowNotification($data_notification));

                $remove_friend_request->delete();
                return response()->json(['delete' => 'yes']);
            } else
                return response()->json(['delete' => 'not found user']); {
            }
        } else {
            return redirect()->route('main_error');
        }
    }

    // User accept Reqeust
    public function user_request_accept(Request $request)
    {
        if (Auth::check()) {
            $request_accept = Friendship::where('receiver_user_id', Auth::id())->where('sender_user_id', $request->select_user_id)->first();
            if (isset($request_accept)) {
                $request_accept->status = 1;
                $request_accept->save();

                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not found data']);
            }
        } else {
            return redirect()->route('main_error');
        }
    }

    // Show user FriendList
    public function user_friendlist_show(Request $request)
    {
        if (Auth::check()) {

            $friendList = Friendship::with('sendersData', 'receiverData')->where(function ($query) {
                $query->where('sender_user_id', Auth::id())
                    ->orWhere('receiver_user_id', Auth::id());
            })->where('status', 1)
                ->orderByDesc('created_at')->get();

            return view('User.friend_list_remove_show', ['friendList' => $friendList]);
        } else {
            return redirect()->route('main_error');
        }
    }

    // Current User Typing Or Not
    public function Current_User_Type_Pusher(Request $request)
    {
        if (Auth::check()) {
            $data = array('sender_id' => Auth::id(), 'receiver_id' => $request->select_id, 'message' => 'Typing...');
            event(new SenderTypingEvent($data));

            return response()->json(['Data' => 'yes']);
        } else {
            return response()->json(['Data' => 'not Authentication User']);
        }
    }

    // Get Message Emoji
    public function message_emoji_add(Request $request)
    {
        if (Auth::check()) {
            $messages = Message::find($request->message_id);
            if (isset($messages)) {
                $messages->response = $request->emoji_code;
                $messages->save();
                event(new EmojiResponseEvent($messages));
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not found data message']);
            }
        } else {
            return response()->json(['data' => 'not found data message']);
        }
    }

    // Last time Seen At Add
    public function user_last_seen_time(Request $request)
    {
        if (Auth::check()) {
            $User_find = User::find($request->leav_id);
            if (isset($User_find)) {
                $User_find->last_seen_at = now();
                $User_find->save();
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not found data user']);
            }
        } else {
            return response()->json(['data' => 'not found data message']);
        }
    }

    public function user_forword_message(Request $request)
    {
        $friendList = Friendship::with('sendersData', 'receiverData')->where(function ($query) {
            $query->where('sender_user_id', Auth::id())
                ->orWhere('receiver_user_id', Auth::id());
        })->where('status', 1)
            ->orderByDesc('created_at')->get();

        if (isset($friendList)) {

            return view('User.Forword_Message', ["friendList" => $friendList]);
        } else {
            return response()->json(['data' => "data is not found"]);
        }
    }

    // Pdf View
    public function pdf_view(Request $request, $filename)
    {
        $path = storage_path('app/public/img/' . $filename);

        if (FacadesFile::exists($path)) {

            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        } else {
            return response()->route('main_error');
        }
    }

    // Pdf Download
    public function pdf_download(Request $request, $filename)
    {
        $path = storage_path('app/public/img/' . $filename);

        if (FacadesFile::exists($path)) {

            return response()->download($path, $filename);
        } else {
            return response()->route('main_error');
        }
    }

    // Star User Add
    public function user_star_add(Request $request)
    {
        if (Auth::check()) {
            $Star_user_Data = new StarUser();
            $Star_user_Data->current_user_id = Auth::id();
            $Star_user_Data->star_user_id = $request->star_user_id;
            $Star_user_Data->save();

            if (isset($Star_user_Data)) {
                return response()->json(['data' => 'yes']);
            }
        } else {
            return response()->json(['data' => 'Not Found Auth']);
        }
    }

    // Star User remove
    public function user_star_remove(Request $request)
    {
        if (Auth::check()) {
            $Star_user_Data = StarUser::where('current_user_id', Auth::id())
                ->where('star_user_id', $request->star_user_id)
                ->first();

            if (isset($Star_user_Data)) {
                $Star_user_Data->delete();
                return response()->json(['data' => 'yes']);
            }
        } else {
            return response()->json(['data' => 'Not Found Auth']);
        }
    }

    // Star Show
    public function user_star_show(Request $request)
    {
        $message_data_order = Message::with(['StarUserWithMessage' => function ($query) {
            $query->where('current_user_id', Auth::id());
        }])
            ->select('send_id', 'receive_id')
            ->selectRaw('MAX(created_at) as last_message_time')
            ->where('send_id', Auth::user()->id)
            ->orWhere('receive_id', Auth::user()->id)
            ->groupBy('send_id', 'receive_id')
            ->orderByDesc('last_message_time')
            ->get();



        $extra_collect = $message_data_order;

        for ($i = 0; $i < $message_data_order->count(); $i++) {
            $fresh_send_id = $message_data_order[$i]->send_id;
            $fresh_receive_id = $message_data_order[$i]->receive_id;
            $fresh_ct = $message_data_order[$i]->last_message_time;

            for ($j = 0; $j < $extra_collect->count(); $j++) {
                if ($fresh_send_id == $extra_collect[$j]->receive_id && $fresh_receive_id == $extra_collect[$j]->send_id) {
                    if ($fresh_receive_id == Auth::id()) {
                        $message_data_order[$i]->send_id = $extra_collect[$j]->send_id;
                        $message_data_order[$i]->receive_id = $extra_collect[$j]->receive_id;
                        $message_data_order[$j]->last_message_time = $fresh_ct;
                    }
                }
            }
        }

        if (isset($message_data_order)) {
            return view('User.Star_User', ["last_message_send_data" => $message_data_order]);
        } else {
            return redirect()->route('main_error');
        }
    }

    public function Edit_Get_Message(Request $request)
    {
        if (isset($request->message_id)) {
            $group_message = Message::find($request->message_id);

            if (isset($group_message)) {
                return response()->json(['message' => $group_message->message]);
            }
        } else {
            return response()->json(['data' => 'not found']);
        }
        // dd($request->all());
    }

    public function Get_Message_Not_View_Count(Request $request)
    {
        if (Auth::check()) {
            // Count Message Not View
            $Message_Not_View_Count_Data = Message::where('receive_id', Auth::id())
                ->where('status', 'send')
                ->get();

            // Count Group All View
            $group_of_user_name = GroupUser::with('GroupData')->where('user_id', Auth::id())->get();

            $count_All = 0;
            foreach ($group_of_user_name as  $value) {
                $Find_Not_View_Message = GroupMessageDeleteAt::where("user_id", Auth::id())
                    ->where('group_id', $value->GroupData->id)
                    ->where('status', 'send')
                    ->get();
                if (!empty($Find_Not_View_Message)) {
                    $count_All += $Find_Not_View_Message->count();
                }
            }

            // Notification Count
            $current_user_notification = Friendship::where('receiver_user_id', Auth::id())
                ->where('seen', 'no')
                ->get();

            return response()->json([
                'count_message' => $Message_Not_View_Count_Data->count(),
                'group_count_message' => $count_All,
                'notification_count' => $current_user_notification->count(),
            ]);
        } else {
            return response()->route('main_error');
        }
    }
}
