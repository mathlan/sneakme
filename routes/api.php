<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/addNewItem', \App\Http\Controllers\Api\ChatOrderItemController::class)->middleware('auth.optional:api');
/*Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});*/

Route::group([
    'middleware' => 'auth.optional:api'
], function () {
    Route::post('/chat', \App\Http\Controllers\Api\ChatController::class);
    Route::post('/addNewItem', [ChatController::class, 'addNewItem']);
    Route::post('/deleteItem', [ChatController::class, 'deleteItem']);
    Route::post('/displayCart', [ChatController::class, 'displayCart']);
    Route::post('/connectUser', [ChatController::class, 'connectUser']);
    // Route::middleware('auth:sanctum')->post('/addNewItem', [ChatController::class, 'addNewItem']);
});

/*Route::post('/chat', \App\Http\Controllers\Api\ChatController::class);*/

