<?php

namespace App\Services\Sms;

interface SmsGateway
{
    public function send(string $phoneNumber, string $message): bool;
}
