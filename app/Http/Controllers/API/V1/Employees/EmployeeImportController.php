<?php

namespace App\Http\Controllers\API\V1\Employees;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessEmployeeImport;
use Illuminate\Http\Request;

class EmployeeImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json',
        ]);

        $path = $request->file('file')->store('imports');

        ProcessEmployeeImport::dispatch($path, auth()->user());

        return response()->json(['message' => 'Employee import queued']);
    }


}
