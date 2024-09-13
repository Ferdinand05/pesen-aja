<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

        return Inertia::render('Auth/ResetPassword');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => ['exists:users,email', 'required', 'email']
        ]);

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $request->email
        ], [
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now('Asia/Jakarta')
        ]);

        Mail::to($request->email)->send(new ResetPassword($token));

        return to_route('forgot.password')->with('message', 'Email Reset password Has been sent!');
    }

    public function resetPassword($token)
    {
        return Inertia::render('Auth/PasswordRecovery', ['token' => $token]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
            'token' => ['required', 'exists:password_reset_tokens,token']
        ]);

        $userToken = DB::table('password_reset_tokens')->whereToken($request->token)->first();
        if ($userToken) {
            $user = User::whereEmail($userToken->email)->first();
            $user->update([
                'password' => $request->password_confirmation
            ]);
            DB::table('password_reset_tokens')->where('email', $userToken->email)->delete();
            return redirect()->to(route('login'))->with('message', 'Your password has been Reset!');
        } else {
            return redirect()->to(route('login'))->with('message', 'Invalid Token!');
        }
    }
}
