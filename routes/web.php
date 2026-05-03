<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'permission:panel.access'])->group(function (): void {
    Route::get('/reports/federations', [ReportController::class, 'index'])
        ->name('reports.federations.index');
});
