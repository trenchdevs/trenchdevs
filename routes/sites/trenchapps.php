<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
   return response()->json([
       '@trenchapps' => true,
       'success' => true,
   ]);
});
