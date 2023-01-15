<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'username' => 'required',
                    'phone' => 'required|digits:11',
                    'email' => 'required|email|unique:users,email',
                    'data_of_birth' => 'required',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'data_of_birth' => $request->data_of_birth,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $value = request()->username;
            $field  = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            request()->merge([$field => $value]);
            if ($field == "email") {
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'username'  => 'required|email',
                        'password' => 'required'
                    ]
                );

                if ($validateUser->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }
            } else {
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'username'  => 'required|digits:11',
                        'password' => 'required'
                    ]
                );

                if ($validateUser->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }
            }

            if (!Auth::attempt($request->only([$field, 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone & Password does not match with our record.',
                ], 401);
            }
            $user = User::where($field, $value)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}