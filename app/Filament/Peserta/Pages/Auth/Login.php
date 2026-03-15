<?php

namespace App\Filament\Peserta\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $authGuard = Filament::auth();
        $authProvider = $authGuard->getProvider(); /** @phpstan-ignore-line */
        $credentials = $this->getCredentialsFromFormData($data);
        $user = $authProvider->retrieveByCredentials($credentials);

        if ((! $user) || (! $authProvider->validateCredentials($user, $credentials))) {
            event(app(Failed::class, [
                'guard' => property_exists($authGuard, 'name') ? $authGuard->name : '',
                'user' => $user,
                'credentials' => $credentials,
            ]));

            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::auth/pages/login.messages.failed'),
            ]);
        }

        if (
            $user instanceof Authenticatable &&
            $user->role === 'peserta' &&
            (! $user->pesertaMagang || ! in_array($user->pesertaMagang->status, ['diterima', 'aktif', 'selesai'], true))
        ) {
            throw ValidationException::withMessages([
                'data.email' => 'Akun Anda belum disetujui admin dan belum dapat digunakan untuk login.',
            ]);
        }

        if (! $authGuard->attemptWhen($credentials, function (Authenticatable $user): bool {
            if (! ($user instanceof FilamentUser)) {
                return true;
            }

            return $user->canAccessPanel(Filament::getCurrentOrDefaultPanel());
        }, $data['remember'] ?? false)) {
            event(app(Failed::class, [
                'guard' => property_exists($authGuard, 'name') ? $authGuard->name : '',
                'user' => $user,
                'credentials' => $credentials,
            ]));

            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::auth/pages/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
