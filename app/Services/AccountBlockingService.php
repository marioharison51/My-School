<?php

namespace App\Services;

use App\Models\User;
use App\Services\Sms\SmsGateway;
use Illuminate\Support\Str;

class AccountBlockingService
{
    public function __construct(private SmsGateway $sms) {}

    /**
     * Bloque un compte de façon indéfinie (jusqu'à déblocage manuel).
     */
    public function block(User $user, string $reason): void
    {
        $user->update([
            'account_status' => 'blocked',
            'suspended_until' => null,
            'blocked_reason' => $reason,
        ]);
    }

    /**
     * Déblocage classique (admin) : réactive le compte + réinitialise le mot de passe.
     */
    public function unblockWithPasswordReset(User $user): string
    {
        $newPassword = Str::password(10);

        $user->update([
            'account_status' => 'active',
            'suspended_until' => null,
            'blocked_reason' => null,
            'requires_password_reset' => false,
            'password' => $newPassword,
        ]);

        $this->notifyNewPassword($user, $newPassword);

        return $newPassword;
    }

    /**
     * Déblocage temporaire (enseignant) : réactive le compte, mais l'utilisateur
     * doit repasser par l'admin/direction pour réinitialiser son mot de passe
     * et retrouver l'accès complet à toutes les fonctionnalités.
     */
    public function unblockTemporarily(User $user): void
    {
        $user->update([
            'account_status' => 'active',
            'blocked_reason' => null,
            'requires_password_reset' => true,
        ]);
    }

    private function notifyNewPassword(User $user, string $newPassword): void
    {
        $phone = $user->student?->parent_phone ?? $user->children()->first()?->parent_phone;

        if ($phone) {
            $this->sms->send($phone, "Votre compte a été débloqué. Nouveau mot de passe temporaire : {$newPassword}");
        }
    }
}
