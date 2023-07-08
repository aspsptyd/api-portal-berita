<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            $error[] = [
                "code" => 404,
                "msg" => "Data user tidak ditemukan di database!, Silahkan cek kembali email & password Anda.",
            ];

            return response()->json(["response" => $error], 404);
        } else {
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $success[] = [
                "code" => 200,
                "token_login" => $user->createToken('token_login')->plainTextToken,
                "data_user" => [
                    "id_user" => $user->id,
                    "email" => $user->email,
                    "username" => $user->username,
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "join_at" => $user->created_at === null ? null : date_format($user->created_at, "Y/m/d H:i:s"),
                ]
            ];
            return response()->json(["response" => $success]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $logout[] = [
            "code" => 200,
            "msg" => "Anda berhasil logout!",
        ];
        return response()->json(["response" => $logout]);
    }
}
