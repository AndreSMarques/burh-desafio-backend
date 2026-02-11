<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\UserController;

Route::apiResource('companies', CompanyController::class);
Route::apiResource('jobs', JobController::class);
Route::apiResource('applications', ApplicationController::class);
Route::post('/users', [UserController::class, 'store']);

Route::get('/users/search', [UserController::class, 'search']);