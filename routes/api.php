<?php

use App\Http\Controllers\MotionSensorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToggleController;
use App\Http\Controllers\NodeMCUController;
use App\Http\Controllers\NotificationHandler;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function(){
    return response()->json(['message' => 'Hello World!'], 200);
});

Route::post('/post-data', [NodeMCUController::class, 'receiveData']);
Route::post('/device-toggle', [ToggleController::class, 'deviceToggle'])->name('toggle.DeviceState');
Route::put('/motion-sensor-toggle', [MotionSensorController::class,'toggleMotionSensor'])->name('toggle.MotionSensor');
Route::put('/toggle-mode', [ToggleController::class, 'toggleMode'])->name('toggle.ModeState');
// Route::get('/user/notification', [NotificationHandler::class, 'getNotifications'])->name('user.notification');