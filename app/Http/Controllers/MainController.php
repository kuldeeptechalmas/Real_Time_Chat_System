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
                'email' => 'required|unique:users,email|email:rfc,dns',
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
        return view('registration');
    }

    // Dashboard
    public function dashboard(Request $request)
    {
        $message_data_order = Message::select('send_id', 'receive_id')
            ->selectRaw('MAX(created_at) as last_message_time')
            ->where('send_id', Auth::user()->id)
            ->orWhere('receive_id', Auth::user()->id)
            ->groupBy('receive_id', 'send_id')
            ->orderByDesc('last_message_time')
            ->get();

        // dd($message_data_order->toArray());

        if ($message_data_order->isNotEmpty()) {
            return view('User.dashbord', ['last_message_send_data' => $message_data_order, 'last_send_message_user' => $message_data_order[0]->receive_id]);
        } elseif ($message_data_order->count() == 0) {
            return view('User.dashbord');
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
