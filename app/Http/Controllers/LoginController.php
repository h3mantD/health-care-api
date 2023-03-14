<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();
        } catch (\Throwable $th) {
            return response()->json(['status' => false, $th->getMessage()]);
        }

        // return redirect()->intended(RouteServiceProvider::HOME);
        return response()->json(['status' => true]);
        // return response()->json(['status' => true]);
    }
}
