<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'status' => ['required'],
            'password' => ['required'],
            'user_type' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            
            DB::beginTransaction();
            $data = $request->except('password');
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            event(new Registered($user));
            DB::commit();
          
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'token_type' => 'Bearer',
                'status' => JsonResponse::HTTP_OK,
                'message' => 'User Added successfully.'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {   
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'Invalid User Credentials',
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'token_type' => 'Bearer',
                'status' => JsonResponse::HTTP_OK,
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function logout()
    {   
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => 'logout successfully',
                'status' => JsonResponse::HTTP_OK,
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
