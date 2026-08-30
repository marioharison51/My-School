<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class Installation
{
    private const LOCK_FILE = 'installed.lock';

    public static function isInstalled(): bool
    {
        return File::exists(storage_path(self::LOCK_FILE));
    }

    public static function markInstalled(): void
    {
        File::put(storage_path(self::LOCK_FILE), now()->toDateTimeString());
    }
}
