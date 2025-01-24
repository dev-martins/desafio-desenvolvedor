<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\OTPRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login e envio de OTP.
     */
    public function login(AuthRequest $request)
    {
        $response = $this->authService->login($request->validated());

        return response()->json($response['data'], $response['status']);
    }

    /**
     * Verificação de OTP.
     */
    public function verifyOTP(OTPRequest $request)
    {
        $response = $this->authService->verifyOTP($request->validated());

        return response()->json($response['data'], $response['status']);
    }
}
