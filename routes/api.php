<?php

use App\Http\Controllers\Api\LeadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/projects', [ProjectController::class, 'index']);

Route::get('/project/{slug}', [ProjectController::class, 'getProject']);

Route::post('/send-email', [LeadController::class, 'store']);
