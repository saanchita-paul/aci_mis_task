<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('reports/stats', [ReportController::class, 'stats']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
