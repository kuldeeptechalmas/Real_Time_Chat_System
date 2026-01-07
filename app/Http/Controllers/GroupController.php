<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageEvent;
use App\Events\ViewToReceiver;
use App\Models\Friendship;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupUser;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    // Group Add Page Show
    public function create_group(Request $request)
    {
        $friendlist = Friendship::with('sendersData', 'receiverData')->where(function ($query) {
            $query->where('sender_user_id', Auth::id())
                ->orWhere('receiver_user_id', Auth::id());
        })->where('status', 1)
            ->orderByDesc('created_at')->get();

        if (isset($friendlist)) {

            return view('User.Group_Create', ["friendList" => $friendlist]);
        } else {
            return response()->json(['data' => "data is not found"]);
        }
    }

    public function create_group_final(Request $request)
    {
        if (Auth::check()) {
            // create group
            $create_Group = new Group();
            $create_Group->name = $request->group_name;
            $create_Group->save();

            // created user 
            $user_group_create = new GroupUser();
            $user_group_create->group_id = $create_Group->id;
            $user_group_create->user_id = Auth::id();
            $user_group_create->creater_id = Auth::id();
            $user_group_create->save();

            foreach ($request->group_user as $key => $value) {
                $user_group_create = new GroupUser();
                $user_group_create->group_id = $create_Group->id;
                $user_group_create->user_id = $value;
                $user_group_create->save();
            }
            if (isset($create_Group)) {
                return response()->json(['data' => 'yes']);
            }
        } else {
            return response()->json(['data' => 'not Found user']);
        }
    }

    public function Group_Show(Request $request)
    {
        $group_of_user_name = GroupUser::with('UserData', 'GroupData')->where('user_id', Auth::id())->get();

        if (isset($group_of_user_name)) {
            return view('User.Group.Group_Show', ['group' => $group_of_user_name]);
        } else {
            return redirect()->route('main_error');
        }
    }

    public function Group_Chatbort(Request $request)
    {
        $group_select_data = Group::find($request->group_id);
        if (isset($group_select_data)) {
            return view('User.Group.Group_Chatboart', ['chatboart_group' => $group_select_data]);
        } else {
            return response()->json(['data' => 'not found']);
        }
    }

    public function Group_Send_Message(Request $request)
    {
        if (Auth::check()) {
            if ($files = $request->file('files')) {
                foreach ($files as $file) {
                    $file->storeAs('public/img', $file->getClientOriginalName());
                    $group_message = new GroupMessage();
                    $group_message->user_id = Auth::id();
                    $group_message->group_id = $request->group_id;
                    $group_message->message = $file->getClientOriginalName();
                    $group_message->save();
                }
            } else {
                $group_message = new GroupMessage();
                $group_message->user_id = Auth::id();
                $group_message->group_id = $request->group_id;
                $group_message->message = $request->message;
                $group_message->save();
            }

            event(new GroupMessageEvent($request->group_id));

            $message_data_to_show = GroupMessage::with('UserData')->where('group_id', $request->group_id)->orderBy('created_at', "asc")->get();

            if (isset($message_data_to_show)) {
                return view('User.Group.Group_Message_Show', ['message' => $message_data_to_show]);
            }
        } else {
            return response()->json(['data' => 'not found']);
        }
    }

    public function Group_Message_Show(Request $request)
    {
        $userid = Auth::id();
        $group_id = $request->group_id;

        $message_data_to_show = GroupMessage::with('UserData')->where('group_id', $group_id)->orderBy('created_at', "asc")->get();

        if (isset($message_data_to_show)) {
            return view('User.Group.Group_Message_Show', ['message' => $message_data_to_show]);
        } else {
            return response()->json(['error' => 'not found data for user messages']);
        }
        // dd($request->group_id);
    }

    public function Group_user_Show_All(Request $request)
    {
        $group_in_all_user = GroupUser::with('UserData')->where('group_id', $request->group_id)->get();
        if (isset($group_in_all_user)) {
            return view('User.Group.Group_In_User_Show', ['UserAllGroup' => $group_in_all_user]);
        } else {
            return response()->json(['data' => 'not found']);
        }
    }

    public function Group_Exit(Request $request)
    {
        if (Auth::check()) {
            $group_user = GroupUser::where('group_id', $request->group_id)
                ->where('user_id', Auth::id())
                ->first();
            if (isset($group_user)) {
                $group_user->delete();
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not user exist']);
            }
        } else {
            return response()->json(['data' => 'not user exist']);
        }
        dd($request->all());
    }
}
