<?php

namespace App\Http\Controllers;

use App\Events\SendMeesages;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Search user Friend 
    public function search_friend(Request $request)
    {
        $user_Find_Data = User::where('name', 'like', "%" . $request->searchdata . "%")
            ->where('id', '!=', Auth::user()->id)->get();

        if (isset($user_Find_Data)) {

            return view('user.searchfriend', ["user_data" => $user_Find_Data]);
        } else {

            return response()->json(['error' => 'not found data']);
        }
    }

    // User Select friend Data Show
    public function user_select_data(Request $request)
    {
        $user_Select_to_show = User::find($request->select_user_id);
        if (isset($user_Select_to_show)) {
            Session::put('chatboart_user_id', $user_Select_to_show->id);

            return view('user.chatboard', ['user_send_user_data' => $user_Select_to_show]);
        } else {

            return response()->json(['error' => 'not found data for user']);
        }
    }

    public function message_send_specific_user(Request $request)
    {
        if (Auth::check()) {

            $message_data = new Message();
            $message_data->message = $request->message;
            $message_data->send_id = Auth::user()->id;
            $message_data->receive_id = $request->receive_data_id;
            $message_data->save();

            $userid = Auth::id();
            $selectuserid = $request->receive_data_id;

            event(new SendMeesages($message_data->toArray()));

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
        dd($request->all());
    }
}
