<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class EnvWriter
{
    public static function set(string $key, string $value): void
    {
        $path = base_path('.env');

        if (! File::exists($path)) {
            return;
        }

        $escaped = str_contains($value, ' ') ? '"'.str_replace('"', '\\"', $value).'"' : $value;
        $content = File::get($path);

        $pattern = '/^'.preg_quote($key, '/').'=.*/m';

        if (preg_match($pattern, $content)) {
            $content = preg_replace_callback($pattern, fn () => "{$key}={$escaped}", $content);
        } else {
            $content .= "\n{$key}={$escaped}\n";
        }

        File::put($path, $content);
    }
}
