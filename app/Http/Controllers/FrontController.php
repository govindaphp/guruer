<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Mail;

class FrontController extends Controller
{
    public function index(){
        return view('front.layouts.index');
    }

    public function login(){
        if(auth()->user() ){
            return redirect('dashboard');
        }
       return view('front.layouts.login');
    }


    public function loginAction(Request $request)
{
    // Validate the input fields
    $request->validate([
        'email' => 'required|string',
        'password' => 'required|string|min:6'
    ]);

    // Get user credentials
    $usercredential = $request->only('email', 'password');

    // Attempt to log the user in
    if (Auth::attempt($usercredential)) {
        // Check if the user's status is active
        $user = Auth::user();
        if ($user->status == 1) {

            return redirect('dashboard');
        } else {

            Auth::guard('web')->logout();
            return back()->with('error', 'Your account is inactive. Please contact support team');
        }
    } else {

        return back()->with('error', 'Username & Password are incorrect');
    }
}


    public function register(){
        if(auth()->user() ){
            return redirect('dashboard');
        }
       return view('front.layouts.signup');
    }

    public function registerAction(Request $request){
     

        $validated = $request->validate([
            'email' => 'string|required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $user = new User;
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->save();

            return back()->with('success', 'Your registration has been successful.');
        } catch (\Exception $e) {
            // Log error
            \Log::error('User registration failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'There was a problem with your registration.');
        }
    }

    public function loadDashboard(){
        return view('front.layouts.dashboard');
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
     }

     public function loadforgetPassword(){
        return view('front.user.forgotpasswod');
     }

     public function forgetPassword(Request $request){


        try{

            $user = User::where('email',$request->email)->get();

            if(count($user) >0){
               $token = Str::random(40);
               $domain = URL::to('/');
               $url = $domain.'/reset-password?token='.$token;

               $data['url'] = $url;
               $data['email'] = $request->email;
               $data['title'] = 'Forget Password';
               $data['body'] =   'Please click on below link to reset your password';

               Mail::send('front.user.forgotPasswordMail',['data'=>$data],function($message) use ($data){
                  $message->to($data['email'])->subject($data['title']);
               });

               $datetime = Carbon::now()->format('Y-m-d H:i:s');

               PasswordReset::updateOrCreate(
                    [
                        'email'=>$request->email
                    ],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );
                return back()->with('success','please check your mail to reset your password');

            }else{
                return back()->with('error','Email is not valid');
            }

        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }

     }

      public function resetPasswordLoad(Request $request){
            //   print_r($request->all());die;

            $resetpassword = PasswordReset::where('token',$request->token)->get();

            if(count($resetpassword) >0 && isset($request->token)){

                $user = User::where('email',$resetpassword[0]['email'])->get();

                // echo "<pre>";print_r($user);die;
                return view('front.user.resetPassword',compact('user'));

            }else{
                return view('front.user.404');
            }
      }



    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->user_email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();

             PasswordReset::where('email',$request->user_email)->delete();
             return redirect('/login')->with('success', 'Your password has been reset successfully enter here new password.');
    }

    return redirect()->back()->with('error', 'User not found');

    }


}
