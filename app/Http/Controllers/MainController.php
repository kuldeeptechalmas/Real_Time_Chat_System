<?php

namespace App\Http\Controllers;

use App\Jobs\Email_OTP_Ver_Job;
use App\Mail\Email_OTP_Verification;
use App\Models\Message;
use App\Models\User;
use App\Rules\check_password;
use App\Rules\check_username_email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MainController extends Controller
{
    // Login
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'user_name_email' => ['required', new check_username_email()],
                'password' => ['required'],
            ], [
                'user_name_email.required' => 'Enter User Name Or Email is Required',
                'password.required' => 'Enter Password is Required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $user_data = User::where('name', $request->user_name_email)->orWhere('email', $request->user_name_email)->first();

            if (isset($user_data)) {
                if (Hash::check($request->password, $user_data->password)) {

                    Auth::login($user_data);
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->back()->withInput()->withErrors(['password' => 'Enter Currect Password']);
                }
            }
        }
        Session::forget('register_user_data');
        Session::forget('emailotp');

        return view('login');
    }

    // Registration
    public function registration(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|alpha_dash|unique:users,name',
                'phone' => 'required|numeric|digits:10|unique:users,phone',
                'email' => ['required', 'unique:users,email', 'email:rfc,dns', 'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo|yopmail)\.com$/'],
                'password' => [
                    'required',
                    Password::min(8)->symbols()->mixedCase()->numbers()
                ],
                'cpassword' => 'required|same:password',
                'gender' => 'required',
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
                'password.required' => 'Enter Password is Required',
                'password.min' => 'Enter Password is Min 8 Letter Required',
                'password.mixed' => 'Enter Password is One Upper and Lower Cases Required',
                'password.symbols' => 'Enter Password is One Symbols Required',
                'password.numbers' => 'Enter Password is One Numbers Required',
                'cpassword.required' => 'Enter Conform Password is Required',
                'cpassword.same' => 'Enter Conform Password is Not Match Password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $register_user_data = array(
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password,
                'gender' => $request->gender,
            );

            Session::put('register_user_data', $register_user_data);
            if (Session::get('register_user_data')) {
                return redirect()->route('email_generate');
            } else {
                return redirect()->route('main_error');
            }
        }
        if (Session::get('register_user_data')) {
            Session::forget('register_user_data');
        }
        Session::forget('emailotp');
        return view('registration');
    }

    // Forgot Password
    public function forgotpassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'user_name_email' => ['required', new check_username_email()],
                'password' => [
                    'required',
                    Password::min(8)->symbols()->mixedCase()->numbers()
                ],
                'confpassword' => 'required|same:password',
            ], [
                'user_name_email.required' => 'Enter User Name Or Email is Required',
                'password.required' => 'Enter Password is Required',
                'password.min' => 'Enter Password is Min 8 Letter Required',
                'password.mixed' => 'Enter Password is One Upper and Lower Cases Required',
                'password.symbols' => 'Enter Password is One Symbols Required',
                'password.numbers' => 'Enter Password is One Numbers Required',
                'confpassword.required' => 'Enter Conform Password is Required',
                'confpassword.same' => 'Enter Conform Password is Not Match Password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $user_exist = User::where('name', $request->user_name_email)
                ->orWhere('email', $request->user_name_email)
                ->first();

            if (isset($user_exist)) {
                $user_exist->password = Hash::make($request->password);
                $user_exist->save();
            }

            return redirect('login');
        }
        return view('forgotpassword');
    }

    // Dashboard
    public function dashboard(Request $request)
    {
        $message_data_order = Message::select('send_id', 'receive_id')
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

        $uniqueConversations = $message_data_order->unique(function ($item) {
            $participants = [$item->send_id, $item->receive_id];
            sort($participants);
            return implode('-', $participants);
        });

        $finalUserList = $uniqueConversations->values();

        if ($finalUserList->isNotEmpty()) {
            return view(
                'User.dashbord',
                [
                    'last_message_send_data' => $finalUserList,
                    'last_send_message_user' => $finalUserList[0]->receive_id == Auth::id() ? $message_data_order[0]->send_id : $message_data_order[0]->receive_id,
                    'dashboardshow' => 'yes'
                ]
            );
        } elseif ($finalUserList->count() == 0) {
            return view('User.dashbord', ['dashboardshow' => 'yes']);
        } else {
            return view('mainerror');
        }
    }

    // Email Otp
    public function email_generate()
    {
        if (Session::get('register_user_data')) {

            $send_Email_id = Session::get('register_user_data')['email'];

            $otp = random_int(0, 999999);
            Session::put('emailotp', $otp);
            $data = array('otp' => $otp, 'email' => $send_Email_id);

            // Job for mail send
            dispatch(new Email_OTP_Ver_Job($data));

            return redirect()->route('email_verification');
        } else {
            return redirect()->route('main_error');
        }
    }

    public function email_verification(Request $request)
    {
        if ($request->isMethod('post')) {
            $otp_input = $request->input1 . $request->input2 . $request->input3 . $request->input4 . $request->input5 . $request->input6;

            if (Session::get('emailotp') && Session::get('register_user_data')) {

                if ((int)$otp_input == Session::get('emailotp')) {

                    $conform_user_data = Session::get('register_user_data');
                    $user_data = new User();
                    $user_data->name = $conform_user_data['username'];
                    $user_data->phone = $conform_user_data['phone'];
                    $user_data->email = $conform_user_data['email'];
                    $user_data->gender = $conform_user_data['gender'];
                    $user_data->password = Hash::make($conform_user_data['password']);
                    $user_data->save();

                    if (isset($user_data)) {
                        return redirect()->route('login');
                    } else {
                        return redirect()->route('main_error');
                    }
                } else {
                    return redirect()->back()->withErrors(['otperror' => 'Enter OTP is Wrong']);
                }
            } else {

                return redirect()->route('main_error');
            }
        }
        return view('User.email_opt_verification');
    }

    // Logout
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('login');
    }

    public function main_error()
    {
        return view('mainerror');
    }
}
