<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // request validasi
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // cek redensial login
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            };

            // jika hash tidak sesuai
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            };

            // jika berhasil maka login
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Error $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8',
                'confirmation_password' => 'required|min:8|string'
            ]);

            // cek kondisi password dan confirm password
            if ($request->password != $request->confirmation_password) {
                return ResponseFormatter::error([
                    'message' => 'password not match'
                ], 'Authentication Failed', 500);
            }

            // jika berhasil maka buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // get data user
            $user = User::where('email', $request->email)->first();

            // create token user
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Register Succes');
        } catch (Error $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        // menghapus token pada saat log out
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();

        // use illuminate facedes Validator
        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|min:8|string',
            'confirmation_password' => 'required|min:8|string'

        ]);

        // jika validator gagal maka beri error
        if ($validator->fails()) {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update Password Failed', 401);
        }

        $user = Auth::user();

        // jika hash /password tidak sesuai maka beri error
        if (Hash::check($data['current_password'], $user->password)) {
            return ResponseFormatter::error([
                'message' => 'Current Password is Not Match!'
            ], 'Update Password Failed', 401);
        }

        // jika password dan confirmation password tidak sesuai maka beri error
        if ($data['password'] != $data['confirmation_password']) {
            return ResponseFormatter::error([
                'message' => 'Password is Not Match!'
            ], 'Update Password Failed', 401);
        }

        // jika berhasil maka update password
        $user->password = Hash::make($data['password']);
        $user->save();

        return ResponseFormatter::success([
            'message' => $user
        ], 'Update Password Success');
    }
}
