<?php

namespace App\Http\Controllers;

use App\Events\EmojiResponseEvent;
use App\Events\GroupMessageEvent;
use App\Events\ViewToReceiver;
use App\Models\Friendship;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupMessageDeleteAt;
use App\Models\GroupUser;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $create_Group->creater_id  = Auth::id();
            $create_Group->save();

            // created user 
            $user_group_create = new GroupUser();
            $user_group_create->group_id = $create_Group->id;
            $user_group_create->user_id = Auth::id();
            $user_group_create->creater_id = Auth::id();
            $user_group_create->save();

            if (isset($request->group_user)) {

                foreach ($request->group_user as $key => $value) {
                    $user_group_create = new GroupUser();
                    $user_group_create->group_id = $create_Group->id;
                    $user_group_create->user_id = $value;
                    $user_group_create->creater_id = Auth::id();
                    $user_group_create->save();
                }
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
        // dd($request->all());
        if (Auth::check()) {
            $files = $request->file('files');
            if (isset($files)) {
                foreach ($files as $file) {
                    $file->storeAs('public/img', $file->getClientOriginalName());
                    $group_message = new GroupMessage();
                    $group_message->user_id = Auth::id();
                    $group_message->group_id = $request->group_id;
                    $group_message->message = $file->getClientOriginalName();
                    $group_message->save();

                    $get_group_message_user = GroupUser::where('group_id', $group_message->group_id)->get();

                    foreach ($get_group_message_user as $item) {

                        $message_add_delete_at = new GroupMessageDeleteAt();
                        $message_add_delete_at->message_id = $group_message->id;
                        $message_add_delete_at->user_id = $item->user_id;
                        $message_add_delete_at->group_id  = $group_message->group_id;
                        $message_add_delete_at->save();
                    }
                }
            } else {
                $group_message = new GroupMessage();
                $group_message->user_id = Auth::id();
                $group_message->group_id = $request->group_id;
                $group_message->message = $request->message;
                $group_message->save();

                $get_group_message_user = GroupUser::where('group_id', $group_message->group_id)->get();

                foreach ($get_group_message_user as $item) {

                    $message_add_delete_at = new GroupMessageDeleteAt();
                    $message_add_delete_at->message_id = $group_message->id;
                    $message_add_delete_at->user_id = $item->user_id;
                    $message_add_delete_at->group_id  = $group_message->group_id;
                    $message_add_delete_at->save();
                }
            }


            event(new GroupMessageEvent($request->group_id, Auth::user()));

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

        $message_data_to_show = GroupMessage::with(['UserData', 'GroupMessageDeleteAtData' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->where('group_id', $group_id)
            ->orderBy('created_at', "asc")
            ->get();

        // dd($message_data_to_show->toArray());
        if (isset($message_data_to_show)) {
            return view('User.Group.Group_Message_Show', ['message' => $message_data_to_show]);
        } else {
            return response()->json(['error' => 'not found data for user messages']);
        }
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
                $group_in_total_user = Group::with('GroupUserTotal')->find($request->group_id);

                if ($group_in_total_user->GroupUserTotal->count() == 0) {
                    $group_in_total_user->delete();
                }
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not user exist']);
            }
        } else {
            return response()->json(['data' => 'not user exist']);
        }
        dd($request->all());
    }

    public function Group_Message_Emoji(Request $request)
    {
        if (Auth::check()) {
            $messages = GroupMessage::find($request->message_id);
            if (isset($messages)) {
                $messages->response = $request->emoji_code;
                $messages->save();
                // dd($messages->toArray());
                event(new EmojiResponseEvent($messages));
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not found data message']);
            }
        } else {
            return response()->json(['data' => 'not found data message']);
        }
    }
    public function Group_Message_Remove(Request $request)
    {
        if (Auth::check()) {
            $group_message_delete_at = GroupMessageDeleteAt::where('group_id', $request->groupid)
                ->where('message_id', $request->messageid)
                ->where('user_id', Auth::id())
                ->first();

            if (isset($group_message_delete_at)) {
                $group_message_delete_at->delete();
                return response()->json(['data' => 'yes']);
            } else {
                return response()->json(['data' => 'not found data message']);
            }
        } else {
            return response()->json(['data' => 'not found data message']);
        }
    }

    public function Group_Message_Remove_All(Request $request)
    {

        $userid = Auth::id();
        $group_id = $request->messageGroupid;

        $message_data_to_show = GroupMessage::where('group_id', $group_id)
            ->orderBy('created_at', "asc")
            ->get();

        foreach ($message_data_to_show as $item) {
            $delete_group_message = GroupMessageDeleteAt::where('group_id', $group_id)
                ->where('user_id', Auth::id())
                ->where('message_id', $item->id)
                ->first();
            if (isset($delete_group_message)) {
                $delete_group_message->delete();
            }
        }
        if (isset($message_data_to_show)) {
            return response()->json(['allclean' => 'yes']);
        } else {
            return response()->json(['allclean' => 'not delete all']);
        }
    }

    public function Group_Forword_Message(Request $request)
    {
        $friendList = Friendship::with('sendersData', 'receiverData')->where(function ($query) {
            $query->where('sender_user_id', Auth::id())
                ->orWhere('receiver_user_id', Auth::id());
        })->where('status', 1)
            ->orderByDesc('created_at')->get();

        if (isset($friendList)) {

            return view('User.Group.Group_Forword_Message', ["friendList" => $friendList]);
        } else {
            return response()->json(['data' => "data is not found"]);
        }
    }

    public function Group_Friend_add_Page(Request $request)
    {
        $friendlist = Friendship::with('sendersData', 'receiverData')->where(function ($query) {
            $query->where('sender_user_id', Auth::id())
                ->orWhere('receiver_user_id', Auth::id());
        })->where('status', 1)
            ->orderByDesc('created_at')->get();

        $group_data = Group::find($request->group_id);

        if (isset($friendlist)) {

            return view('User.Group.Group_Add_Friend', ["friendList" => $friendlist, 'group_data' => $group_data]);
        } else {
            return response()->json(['data' => "data is not found"]);
        }
    }

    public function Group_In_Add_Friend(Request $request)
    {
        if (Auth::check()) {
            $group_data = Group::find($request->group_id);

            foreach ($request->group_user as $key => $value) {
                $ExistUserGroup = GroupUser::where('group_id', $group_data->id)
                    ->where('user_id', $value)
                    ->first();
                if (!isset($ExistUserGroup)) {
                    $user_group_create = new GroupUser();
                    $user_group_create->group_id = $group_data->id;
                    $user_group_create->user_id = $value;
                    $user_group_create->creater_id = Auth::id();
                    $user_group_create->save();
                }
            }

            if (isset($create_Group)) {
                return response()->json(['data' => 'yes']);
            }
        } else {
            return response()->json(['data' => 'not Found user']);
        }
    }

    public function Group_Friend_Remove(Request $request)
    {
        $group_user_exist = GroupUser::find($request->groupuserid);
        if (isset($group_user_exist)) {
            $group_id = $group_user_exist->group_id;
            $group_user_exist->delete();

            return response()->json(['data' => 'yes', "group_id" => $group_id]);
        } else {
            return response()->json(['data' => 'not found']);
        }
    }

    public function Group_Image_Store(Request $request)
    {
        $group_Find = Group::find($request->group_id);

        $files = $request->file;
        if (isset($group_Find)) {
            $files->storeAs('public/img', $files->getClientOriginalName());
            $group_Find->image_path = $files->getClientOriginalName();
            $group_Find->save();
            return response()->json(['data' => 'done save image']);
        } else {
            return response()->json(['data' => 'not save image']);
        }
    }
    public function Group_Image_Remove(Request $request)
    {
        $group_Find = Group::find($request->group_id);

        if (isset($group_Find)) {
            $group_Find->image_path = Null;
            $group_Find->save();
            return response()->json(['data' => 'done remove image']);
        } else {
            return response()->json(['data' => 'not remove image']);
        }
    }
    public function Group_Message_Clean(Request $request)
    {
        $group_message_data = GroupMessage::find($request->message_id);

        if (isset($group_message_data)) {
            $group_message_data->message = 'This Message is Deleted';
            $group_message_data->save();

            event(new GroupMessageEvent($request->group_id));

            return response()->json(['data' => 'message Clean']);
        } else {
            return response()->json(['data' => 'message is not found']);
        }
    }

    public function Group_Search(Request $request)
    {
        $search_text = $request->search_text;
        $Group_Data = GroupUser::with(['UserData', 'GroupData' => function ($query) use ($search_text) {
            $query->where('name', 'like', "%" . $search_text . "%");
        }])->where('user_id', Auth::id())->get();

        // dd($Group_Data->toArray());
        // $Group_Data = Group::where('name', 'like', "%" . $request->search_text . "%")->get();
        if (isset($Group_Data)) {
            // dd($request->all()); 
            return view('User.Group.Group_Search', ['group' => $Group_Data]);
        }
    }
}
