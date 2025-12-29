<?php

namespace App\Http\Controllers;

use App\Events\SendMeesages;
use App\Events\ViewToReceiver;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // User Profiles
    public function user_profiles(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
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
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $user_modify_data = User::find($request->id);

            $user_modify_data->name = $request->username;
            $user_modify_data->phone = $request->phone;
            $user_modify_data->email = $request->email;
            $user_modify_data->gender = $request->gender;
            $user_modify_data->save();

            if (isset($request->file)) {
                $files = $request->file("file");
                $files->storeAs("public/img", $files->getClientOriginalName());
                $user_modify_data->image_path = $files->getClientOriginalName();
                $user_modify_data->save();
            }

            Auth::login($user_modify_data);
            return view('User.user_profile');
        }
        return view('User.user_profile');
    }

    // Search user Friend 
    public function search_friend(Request $request)
    {
        if ($request->searchdata != '') {
            $user_Find_Data = User::where('name', 'like', "%" . $request->searchdata . "%")->get();
            if (isset($user_Find_Data)) {

                return view('User.searchfriend', ["user_data" => $user_Find_Data]);
            } else {

                return response()->json(['error' => 'not found data']);
            }
        } else {
            $message_data_order = Message::select('receive_id')
                ->selectRaw('MAX(created_at) as last_message_time')
                ->where('send_id', Auth::user()->id)
                ->groupBy('receive_id')
                ->orderByDesc('last_message_time')
                ->get();

            return view('User.searchfriend', ["last_message_send_data" => $message_data_order]);
        }
    }

    // User Select friend Data Show
    public function user_select_data(Request $request)
    {
        $user_Select_to_show = User::find($request->select_user_id);

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

            return view('user.chatboard', ['user_send_user_data' => $user_Select_to_show]);
        } else {

            return response()->json(['error' => 'not found data for user']);
        }
    }

    // Message send Specific User
    public function message_send_specific_user(Request $request)
    {
        if (Auth::check()) {
            if ($files = $request->file('files')) {
                foreach ($files as $file) {
                    $file->storeAs('public/img', $file->getClientOriginalName());
                    $message_data = new Message();
                    $message_data->message = $file->getClientOriginalName();
                    $message_data->send_id = Auth::user()->id;
                    $message_data->receive_id = $request->receive_data_id;
                    $message_data->status = 'send';
                    $message_data->save();
                }
            } else {
                $message_data = new Message();
                $message_data->message = $request->message;
                $message_data->send_id = Auth::user()->id;
                $message_data->receive_id = $request->receive_data_id;
                $message_data->status = 'send';
                $message_data->save();
            }

            $message_data['name'] = $message_data->user_data_to_message->name;
            $userid = Auth::id();
            $selectuserid = $request->receive_data_id;

            $get_with_message_user = Message::with('sender')->find($message_data->id);

            event(new SendMeesages($get_with_message_user->toArray()));

            $message_data_to_show = Message::where(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $userid)->whereNull('sender_deleted_at')
                    ->where('receive_id', $selectuserid);
            })->orWhere(function ($query) use ($userid, $selectuserid) {
                $query->where('send_id', $selectuserid)
                    ->where('receive_id', $userid)->whereNull('receiver_deleted_at');
            })->orderBy('created_at', "asc")->get();

            return view('User.show_message', ['message' => $message_data_to_show]);
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
        return response()->json(['allclean' => 'yes']);
    }

    public function user_friend_list(Request $request)
    {
        $message_data_order = Message::select('receive_id')
            ->selectRaw('MAX(created_at) as last_message_time')
            ->where('send_id', Auth::user()->id)
            ->groupBy('receive_id')
            ->orderByDesc('last_message_time')
            ->get();

        return view('User.searchfriend', ["last_message_send_data" => $message_data_order]);
    }
}
