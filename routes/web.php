<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;


Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
Route::get('/certificates/{certificateNumber}', [CertificateController::class, 'show'])->name('certificates.show');
Route::get('/certificates/{certificateNumber}/download-qr', [CertificateController::class, 'downloadQrCode'])->name('certificates.downloadQr');
