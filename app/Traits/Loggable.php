<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Loggable
{
    /**
     * Write error log
     *
     * @param \Exception $e
     * @return void
     */
    protected function logError(\Exception $e)
    {
        $className = static::class;
        $methodName = debug_backtrace()[1]['function'];
        $errorMessage = $e->getMessage();
        
        $logMessage = "Error occurred in $className::$methodName: $errorMessage";
        Log::error($logMessage);
    }
}