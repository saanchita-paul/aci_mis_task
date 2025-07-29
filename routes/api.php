<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Employees\EmployeeController;
use App\Http\Controllers\API\V1\Employees\EmployeeImportController;
use App\Http\Controllers\API\V1\Organizations\OrganizationController;
use App\Http\Controllers\API\V1\Reports\ReportController;
use App\Http\Controllers\API\V1\Teams\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'role:user'])->prefix('v1')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('reports/stats', [ReportController::class, 'stats']);
    Route::post('/employees/import', [EmployeeImportController::class, 'import']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
