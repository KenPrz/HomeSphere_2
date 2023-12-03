<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppliancesController;
use App\Http\Controllers\CancelRequest;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ImageHandlerController;
use App\Http\Controllers\HomeCreationController;
use App\Http\Controllers\HomeDataController;
use App\Http\Controllers\HomeMemberController;
use App\Http\Controllers\ModesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/test-event',function(){
//     event(new \App\Events\TestEvent());
// return null;
// });

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('welcome');
    }
});

Route::get('/welcome', fn() => Inertia::render('Welcome'))->name('welcome');

Route::get('/dashboard', function () {
    return redirect()->route('verify');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/home',[HomeCreationController::class, 'verify'])->name('verify');

    Route::get('/create_home',[HomeCreationController::class, 'create_home'])->name('create_home');
    Route::post('/create_home',[HomeCreationController::class, 'new_home'])->name('new_home');
    Route::post('/join_home',[HomeCreationController::class, 'join_home'])->name('join_home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ImageHandlerController::class, 'imageUpload'])->name('image.upload');
    Route::delete('/profile', [ImageHandlerController::class, 'deleteImage'])->name('image.delete');

    Route::delete('/cancel',[CancelRequest::class, 'cancel'])->name('cancel.request');
});

Route::middleware(['auth','checkHasHome'])->group(function () {
    Route::get('/appliances', [AppliancesController::class, 'index'])->name('appliances.index');

    Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
    Route::post('/rooms',[RoomsController::class, 'addRoom'])->name('rooms.addRoom');
    Route::post('/roomedit', [RoomsController::class,'editRoom'])->name('rooms.edit');
    Route::delete('/deleteroom', [RoomsController::class,'deleteRoom'])->name('rooms.delete');

    Route::post('/device-update',[DeviceController::class, 'deviceUpdate'])->name('device.new-name');
    Route::delete('/device-delete',[DeviceController::class, 'deviceDelete'])->name('device.delete');

    Route::get('/modes',[ModesController::class, 'index'])->name('modes.index');
    Route::post('/modes',[ModesController::class, 'createMode'])->name('modes.create');
    Route::patch('/modes',[ModesController::class, 'editMode'])->name('modes.edit');
    Route::delete('/modes',[ModesController::class, 'deleteMode'])->name('modes.delete');
    Route::post('/modes/add-device',[ModesController::class,'addDevice'])->name('modes.addDevice');
    Route::post('/modes/schedule',[ModesController::class, 'scheduleMode'])->name('modes.schedule');
    Route::post('/modes/environment',[ModesController::class, 'environmentMode'])->name('modes.environment');
    Route::put('/modes/update-list',[ModesController::class, 'updateDeviceList'])->name('mode.updateDeviceList');

    Route::get('/settings',[SettingsController::class, 'index'])->name('settings.index');
    Route::delete('/leave', [SettingsController::class,'leaveHome'])->name('settings.leave');

    Route::post('/approve',[HomeMemberController::class,'approveUser'])->name('member.approve');
    Route::put('/promote',[HomeMemberController::class,'promoteUser'])->name('member.promote');
    Route::put('/demote',[HomeMemberController::class,'demoteUser'])->name('member.demote');
    Route::delete('/reject',[HomeMemberController::class, 'rejectUser'])->name('member.reject');
    Route::delete('/kick',[HomeMemberController::class,'kickUser'])->name('member.kick');

    Route::post('/regenerate',[SettingsController::class, 'generateNewApiKey'])->name('generate.newApiKey');
    Route::post('/generate-invite-code',[SettingsController::class,'generateNewInviteKey'])->name('generate.newInviteKey');

    Route::delete('/deletehome',[SettingsController::class,'deleteHome'])->name('home.delete');
});
require __DIR__.'/auth.php';