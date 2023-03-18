<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tzsk\Otp\Facades\Otp;

class AuthenticatedSessionController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            return $this->userService->login($request);
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        return $this->userService->logout($request);
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate(['aadhar_no' => 'required']);

            $user = User::whereAadharNo($request->aadhar_no)->first();
            if (!$user) {
                throw new \Exception('Invalid aadhar no!');
            }

            $otp = Otp::generate($user->email);

            Mail::to($user->email)->send(new SendOtpMail(otp: $otp));

            return response()->json(['status' => true, 'message' => 'otp sent!']);
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate(['aadhar_no' => 'required', 'otp' => 'required']);

            $user = User::whereAadharNo($request->aadhar_no)->first();
            if (!$user) {
                throw new \Exception('Invalid aadhar no!');
            }

            if (Otp::check($request->otp, $user->email)) {
                session(['user_id' => $user->id]);
                return response()->json(['status' => true, 'message' => 'otp verified!']);
            }

            return response()->json(['status' => false, 'message' => 'otp invalid!']);
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function test()
    {
        dd(Auth::user());
    }
}
