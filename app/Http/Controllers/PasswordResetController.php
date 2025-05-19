<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function send_reset_password_email(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
        ]);
        $email = $request->email;

        // Check User's Email Exists or Not
       $user = User::where('email',$request->$email)->first();
       if(!$user){
            return response([
                'message'=> 'Email doesnt exist',
                'status' => 'failed'
            ],404);
       }

    //    Generate Token
       $token = Str::random(60);

       // Saving data to Password Reset Table
       PasswordReset::Create([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now()
       ]);
       
    //    dump("http://127.0.0.1:3000/api/user/reset/". $token);

    //    Sending email with password reset view
       Mail::send('reset',['token'=>$token],function(Message $message)use($email)
       {
        $message->subject('Reset your password');
        $message->to($email);
       });
       return response([
        'token' => $token,
        'message'=> 'Password Reset Success',
            'status' => 'Success'
    ],200);
    }

    public function reset(Request $request, $token)
    {
        // Delete Token older than 2 minute
        $formatted = Carbon::now()->subMinutes(2)->toDateTimeString();
        PasswordReset::where('created_at','<=',$formatted)->delete();

            $request->validate([
            'password' => 'required|confirmed',
        ]);

        $passwordreset = PasswordReset::where('token',$token)->first();
        
        if(!$passwordreset){
            return response([
                'message'=> 'Token is invalid or Expired',
                'status' => 'failed'
            ],404);
        }
        $user = User::where('email',$passwordreset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token after resetting password
        PasswordReset::where('email',$user->email)->delete();
        return response([
            'token' => $token,
            'message'=> 'Password Reset Success',
                'status' => 'Success'
        ],200);
    }

}
