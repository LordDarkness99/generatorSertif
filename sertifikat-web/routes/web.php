<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CertificateController::class, 'create'])->name('certificates.create');
Route::post('/certificates/generate', [CertificateController::class, 'generate'])
    ->name('certificates.generate');
