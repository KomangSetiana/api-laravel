<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    public function login(Request $request)
    {
        try {
            $credencials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (!Auth::attempt($credencials)) {
                return $this->sendError('Unauthorized', 'Authentication Failed', 500);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('Invalid Credencial');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'bearer',
                'user' => $user
            ];

            return $this->sendResponse($data, 'login sukses');
        } catch (Exception $e) {
            return $this->sendError([
                'message' => 'Ada Yang Erorr',
                'error' => $e,
            ], 'Login Gagal');
        }
    }
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([

                'name' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required'
            ]);

            $validateData['password'] = Hash::make($validateData['password']);

            User::create($validateData);
            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'bearer',
                'user' => $user
            ];

            return $this->sendResponse($data, 'register sukses');
        } catch (Exception $e) {

            return $this->sendError([
                'message' => 'Ada Yang Erorr',
                'error' => $e,
            ], 'Registrasi Gagal');
        }
    }

    public function logout()
    {

        $user = User::find(Auth::user()->id);

        $user->tokens()->delete();

        return response()->noContent();
    }

    public function show(User $user)
    {

        try {
            $user = Auth::User($user);
            return $this->sendResponse($user, 'show User success');
        } catch (Exception $e) {
            return $this->sendError([
                'message' => 'ada error',
                'error' => $e
            ], 'show user gagal');
        }
    }
}
