<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // ← Add this

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // 🔍 DEBUG: Log what's being attempted
        Log::info('Login attempt:', [
            'email' => $this->input('email'),
            'remember' => $this->boolean('remember')
        ]);

        // 🔍 DEBUG: Check if user exists
        $user = \App\Models\Auth\User::where('email', $this->input('email'))->first();
        if ($user) {
            Log::info('User found:', [
                'id' => $user->id,
                'email' => $user->email,
                'has_password' => !empty($user->password)
            ]);
        } else {
            Log::warning('User not found:', ['email' => $this->input('email')]);
        }

        // Attempt login
        $attempt = Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        );

        Log::info('Login attempt result:', ['success' => $attempt]);

        if (! $attempt) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return strtolower($this->input('email')).'|'.$this->ip();
    }
}
