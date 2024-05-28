<?php

namespace App\Helpers\Debug;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait Debug
{
    public function debugException(\Exception $e): void
    {
        $isDebugEnabled = (bool) env('APP_DEBUG', false);

        if (! $isDebugEnabled) {
            return;
        }

        Log::debug(
            sprintf(
                '%s happened in file %s line %d at %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
                Carbon::now()->format('Y-m-d H:i:s')
            )
        );
    }
}
