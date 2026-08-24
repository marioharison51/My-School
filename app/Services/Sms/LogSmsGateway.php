<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsGateway implements SmsGateway
{
    public function send(string $phoneNumber, string $message): bool
    {
        Log::info("[SMS simulé] à {$phoneNumber} : {$message}");
        return true;
    }
}
