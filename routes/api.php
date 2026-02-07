<?php

use App\Http\Controllers\DevelopmentApplicantController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\SocialAssistanceRecipientController;
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

Route::apiResource('social_assistances', SocialAssistanceController::class);
Route::get('social_assistances/all/paginated', [SocialAssistanceController::class, 'getAllPaginated']);

Route::apiResource('social_assistance_recipients', SocialAssistanceRecipientController::class);
Route::get('social_assistance_recipients/all/paginated', [SocialAssistanceRecipientController::class, 'getAllPaginated']);

Route::apiResource('events', EventController::class);
Route::get('events/all/paginated', [EventController::class, 'getAllPaginated']);

Route::apiResource('event_participants', EventParticipantController::class);
Route::get('event_participants/all/paginated', [EventParticipantController::class, 'getAllPaginated']);

Route::apiResource('developments', DevelopmentController::class);
Route::get('developments/all/paginated', [DevelopmentController::class, 'getAllPaginated']);

Route::apiResource('development_applicants', DevelopmentApplicantController::class);
Route::get('development_applicants/all/paginated', [DevelopmentApplicantController::class, 'getAllPaginated']);

Route::get('profile', [ProfileController::class, 'index']);
Route::post('profile', [ProfileController::class, 'store']);
Route::put('profile', [ProfileController::class, 'update']);
