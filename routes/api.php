<?php

use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('users', UserController::class);
Route::get('users/all/paginated', [UserController::class, 'getAllPaginated']);

Route::apiResource('head_of_families', HeadOfFamilyController::class);
Route::get('head_of_families/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);

Route::apiResource('family_members', FamilyMemberController::class);
Route::get('family_members/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);