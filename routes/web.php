<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ParticipantController;



//login
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/participants/download-all-qr', [ParticipantController::class, 'downloadAllQr'])->name('participants.downloadAllQr');

Route::middleware(['auth'])->group(function () {
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create/', [CertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::delete('/certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
    Route::resource('participants', ParticipantController::class);
    Route::post('/participants/import', [ParticipantController::class, 'import'])->name('participants.import');
    Route::get('/certificates/{certificateNumber}/download-qr', [CertificateController::class, 'downloadQrCode'])->name('certificates.downloadQr');
    Route::get('/participants/search', [ParticipantController::class, 'search'])->name('participants.search');
});
Route::get('/certificates/{certificateNumber}', [CertificateController::class, 'show'])->name('certificates.show');


