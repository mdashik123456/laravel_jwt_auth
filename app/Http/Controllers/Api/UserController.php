<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'reg']]);
    }

    public function reg(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json(['status' => true, 'message' => 'Registrarion Successful'], 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 422);
        }

        if (!$token = auth()->attempt($validator->validate())) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 0);
        }
        return $this->createNewToken($token);
    }

    public  function createNewToken($token)
    {
        return response()->json(
            [
                "access_token" => $token,
                "token_type" => "Bearer"
            ],
            200
        );
    }

    public function showCurrentLoggedInUser()
    {
        $user = auth()->user();
        return response()->json(['status' => true, 'data' => $user], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['status'=> true,'message'=> 'Logout Successfully'], 200);
    }
}
