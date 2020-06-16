<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('{guard}/login', [AuthController::class, 'login']);
    Route::delete('{guard}/logout', [AuthController::class, 'logout']);
    Route::get('{guard}/refresh', [AuthController::class, 'refresh']);
//    Route::get('profile', [ProfileController::class, 'show']);
//    Route::put('profile', [ProfileController::class, 'update']);
});

Route::middleware('auth:admin,user')->group(function () {
    /*Admin Resource*/
//    Route::apiResource('admins', AdminController::class);
//    Route::apiResource('posts', PostController::class);
//    Route::apiResource('permissions', PermissionController::class);
//    Route::apiResource('roles', RoleController::class);
//    Route::apiResource('news', NewsController::class);
//    Route::apiResource('roles.permissions', PermissionRoleController::class)->only('index', 'store');
//    Route::apiResource('admins.roles', AdminRoleController::class)->only('store');
});
