<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserStoreRequest $request)
    {
        User::create($request->all());
        return response()->noContent(204);
    }

    public function login(UserLoginRequest $request)
    {
        if ($user = User::where(['phone' => $request->phone])->first() and Hash::check($request->password, $user->password)) {
            return response([
                'data' => [
                    'token' => $user->generate_token()
                ]
            ], 200);
        }
        return response([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'phone' => ['phone or password incorrect']
                ]
            ]
        ], 401);
    }

    public function logout()
    {
        Auth::user()->logout();
        return response()->noContent(204);
    }

    public function view()
    {
        return response()->json([
            'data' => Auth::user()
        ], 200);
    }
}
