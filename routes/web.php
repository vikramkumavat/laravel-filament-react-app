<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\PropertiesResource;

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\File::put(storage_path('logs/laravel.log'), '');
    return '✅ Cache cleared successfully!';
});

Route::get('/admin/properties/print', [PropertiesResource::class, 'print'])
    ->name('filament.admin.resources.properties.print');

// define all the route above this line.

Route::get('/{any}', function () {
    return view('app'); // Make sure this blade file exists and loads your React app
})->where('any', '.*');
