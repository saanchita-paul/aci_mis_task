<?php

namespace App\Services;

use App\Jobs\ProcessEmployeeImport;
use Illuminate\Http\UploadedFile;
use App\Models\User;

class EmployeeImportService
{
    public function import(UploadedFile $file, User $user): void
    {
        $path = $file->store('imports');

        ProcessEmployeeImport::dispatch($path, $user);
    }
}
