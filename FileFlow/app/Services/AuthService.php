<?php

namespace App\Services;

use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{

    public function __construct(protected CacheService $cacheService) {}

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            return [
                'data' => ['error' => 'Credenciais inválidas'],
                'status' => 401,
            ];
        }

        $user = Auth::user();

        // Gere o OTP e envie
        $otp = $this->generateOTP($user);
        $this->sendOTP($user, $otp);

        // Gere o otp_token e armazene no cache
        $otpToken = Str::uuid();
        $this->cacheService->put('otp_token_' . $otpToken, ['otp' => $otp, 'user_id' => $user->id], env('CACHE_TIME_DEFAULT'));

        return [
            'data' => [
                'message' => 'OTP enviado para seu e-mail/SMS',
                'otp_token' => $otpToken,
            ],
            'status' => 200,
        ];
    }

    /**
     * Verifica o OTP e autentica o usuário.
     */
    public function verifyOTP(array $data): array
    {
        $cacheData = $this->cacheService->get('otp_token_' . $data['otp_token']);

        if (!$cacheData || $cacheData['otp'] != $data['otp']) {
            return [
                'data' => ['error' => 'OTP inválido ou expirado'],
                'status' => 401,
            ];
        }

        $user = User::find($cacheData['user_id']);

        if (!$user) {
            return [
                'data' => ['error' => 'Usuário não encontrado'],
                'status' => 404,
            ];
        }

        $token = $user->createToken('Auth Token')->accessToken;

        return [
            'data' => [
                'message' => 'Autenticado com sucesso',
                'token' => $token,
            ],
            'status' => 200,
        ];
    }

    /**
     * Gera um OTP e salva no banco.
     */
    private function generateOTP(User $user): int
    {
        $otp = random_int(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        return $otp;
    }

    /**
     * Envia o OTP por e-mail.
     */
    private function sendOTP(User $user, int $otp): void
    {
        // Envio do OTP por e-mail (exemplo)
        Mail::to($user->email)->send(new OTPMail($otp));
    }
}
