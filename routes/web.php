<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\GenerateQrCodeController;

Route::get('employees/{employee}/pdf/generate', [GeneratePdfController::class, 'generateEmployeePdf'])
    ->name('generate.employee.pdf');

Route::get('devices/{device}/pdf/generate', [GeneratePdfController::class, 'generateDevicePdf'])
    ->name('generate.device.pdf');
