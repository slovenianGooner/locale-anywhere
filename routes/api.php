<?php

use Illuminate\Support\Facades\Route;
use Sloveniangooner\LocaleAnywhere\Http\Controllers\LanguagesController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get("/languages", LanguagesController::class."@languages");
Route::post("/cache-locale", LanguagesController::class."@cacheLocale");
Route::delete("/delete", LanguagesController::class."@delete");
