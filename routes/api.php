<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class);

Route::get('departments/{id}/subdepartments', [DepartmentController::class, 'getSubdepartments']);
Route::get('departments-hierarchy', [DepartmentController::class, 'getHierarchy']);