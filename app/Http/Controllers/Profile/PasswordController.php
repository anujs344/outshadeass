<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
class PasswordController extends Controller
{
    public function ChangePassword(Request $req)
    {
        $req->validate([
            'newpassword' => 'required'
        ]);
        try{
            User::where('id',Auth::user('id'))->update([
                'password' => Hash::make($req->newpassword)
            ]);
        }catch(exception $e)
        {
            return response()->json($e, 400);
        }

        return response()->json([
            "result" => "Password Updated"
        ], 200);
    }

    public function ResetPassword()
    {
        $data = [
            "step 1" => "Login With The User Id",
            "step 2" => "pass newpassword as parameter",
            "step 3" => "your Password will be updated",
            "step 4" => "login with your new password"
        ];

        return response()->json($data, 200);
    }
}
