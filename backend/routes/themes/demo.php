<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/../trenchdevs_dashboard.php';

Route::get('/', fn() => response()->json([
    'status' => 'success',
    'message' => '@demo'
]));
