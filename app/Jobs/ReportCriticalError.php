<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReportCriticalError implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $message,
        public string $exceptionClass,
        public string $file,
        public int $line,
    ) {}

    public function handle(): void
    {
        Log::channel('critical')->error("{$this->exceptionClass}: {$this->message}", [
            'file' => $this->file,
            'line' => $this->line,
        ]);
    }
}
