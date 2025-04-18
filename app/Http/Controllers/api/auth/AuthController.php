<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Requests\userRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    use apiResponse;

    public function register(userRequest $request)
    {
        $fields = $request->validated();
        $user = $fields;
        $user['password'] = bcrypt($user['password']);
        $user = User::create($user);
        if (!$user) {
            return $this->sendError('Register Failed');
        }
        return $this->apiResponse($user, 'Register Successfully');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            return $this->sendError('Unauthorized', ['error' => 'Unauthorized']);
    }

        $success = $this->respondWithToken($token);
        return $this->apiResponse($success->original, 'Login Successfully');
    }

    public function logout()
    {
        Auth::logout();
        return $this->apiResponse(null, 'Logout Successfully');
    }

    public function me()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('User Not Found');
        }
        return $this->apiResponse($user, 'Profile');
    }

    public function refresh()
    {
        $token = $this->respondWithToken(Auth::refresh());
        return $this->apiResponse($token->original, 'Refresh Successfully');
    }
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }


}
