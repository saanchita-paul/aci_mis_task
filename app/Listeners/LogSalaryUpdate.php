<?php

namespace App\Listeners;

use App\Events\SalaryUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogSalaryUpdate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SalaryUpdated $event): void
    {
        Log::info("Salary updated for employee: {$event->employee->name}, salary: {$event->employee->salary}");
    }

}
