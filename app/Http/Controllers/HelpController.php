<?php

namespace App\Http\Controllers;

use App\Events\ViewToReceiver;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HelpController extends Controller
{
    public function Help_Page(Request $request)
    {
        $find_Help_User_Admin = User::where('email', 'admin12@yopmail.com')->first();
        // dd($find_Help_User_Admin->toArray());

        if (isset($find_Help_User_Admin)) {
            return view('User.Help.Help_Page', ['help_user' => $find_Help_User_Admin]);
        } else {
            return redirect()->route('main_error');
        }
    }

    public function Help_user_select(Request $request)
    {
        // dd($request->all());

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
        }
    }
}
