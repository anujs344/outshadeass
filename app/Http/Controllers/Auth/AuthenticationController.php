<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;

class AuthenticationController extends Controller
{
    public function register(Request $req)
    {
      
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        
        try{
            $user = new user();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->save();
            return response()->json(["Result" => "Data Have Been Saved"], 200);
        }catch(exception $e)
        {
            return response()->json($e, 400);
        }
        

    }

    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            $data  = User::where('email',$req->email)->first();
            $token = $data->createToken('TutsForWeb')->accessToken;
            return response()->json(["Details" => $data,"Token" => $token], 200);
        }
        else{
            return response()->json(["result" => "login failed"], 200);
        }
    }
    public function logout() {
        if (Auth::check()) {
            Auth::user()->bearerToken()->delete();
        }
        return response()->json(null, 204);
    }
}
