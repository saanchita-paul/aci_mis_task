<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Employee;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Events\SalaryUpdated;
use App\Notifications\ImportCompleted;
use App\Notifications\ImportFailed;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessEmployeeImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;
    public $user;

    public function __construct($filePath, $user)
    {
        $this->filePath = $filePath;
        $this->user = $user;
    }

    public function handle()
    {
        try {
            $content = Storage::get($this->filePath);
            $employees = json_decode($content, true);

            foreach ($employees as $data) {
                $employee = Employee::updateOrCreate(
                    ['name' => $data['name']],
                    $data
                );

                if (isset($data['salary'])) {
                    event(new SalaryUpdated($employee));
                }
            }

            $this->user->notify(new ImportCompleted(count($employees)));
        } catch (\Throwable $e) {
            Log::error('Import Failed: ' . $e->getMessage());
            $this->user->notify(new ImportFailed($e->getMessage()));
        }
    }
}
