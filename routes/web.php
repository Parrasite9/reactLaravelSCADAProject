<?php

use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/relay', function() {
    $myAss = Device::all();
    return Inertia::render('Devices', [
        'devices' => $myAss,
    ]);
});

Route::get('/create-device', function(){
    $allDevices = Device::all();
    return Inertia::render('CreateDevice', [
        'IP' => $allDevices,
    ]);
});

Route::post('/create-device', [DeviceController::class, "createDevice"]);


// Route::get('/relay/{ip}/{value}/details', function ($ip, $value) {
Route::get('/relay/{id}/details', [DeviceController::class, "viewDetails"]);

Route::post('/relay/{id}/details', [DeviceController::class, "updateIP"]);

// THIS IS FOR A CONTROLLER
Route::get('/relay/{id}', [DeviceController::class, "togglePower"]);

Route::get('/history', function () {
    $ActivityLog = ActivityLog::all();

    return $ActivityLog;
});

