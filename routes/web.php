<?php

use App\Http\Controllers\API\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employee-report/download', [ReportController::class, 'downloadReport']);
