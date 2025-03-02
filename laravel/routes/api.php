<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes for your RESTful API endpoints.
|
*/

// Optionally, wrap routes with authentication middleware (e.g., Sanctum)
// For now, we define the endpoints openly:
Route::post('/emails', [EmailController::class, 'store']);
Route::get('/emails/{id}', [EmailController::class, 'getById']);
Route::put('/emails/{id}', [EmailController::class, 'update']);
Route::get('/emails', [EmailController::class, 'getAll']);
Route::delete('/emails/{id}', [EmailController::class, 'deleteById']);
