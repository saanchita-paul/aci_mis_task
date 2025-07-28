<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\OrganizationController;
use App\Http\Controllers\API\V1\TeamController;
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
    Route::post('/logout', [AuthController::class, 'logout']);
});
