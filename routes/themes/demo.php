<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
   return response()->json([
       '@demo' => true,
       'success' => true,
   ]);
});
