<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/public', function () {
    return response()->json(
        [
            'message'    => 'Hello from a public endpoint! You don\'t need to be authenticated to see this.',
            'authorized' => Auth::check(),
            'user'       => Auth::check()
                ? json_decode(
                    json_encode((array) Auth::user(), JSON_THROW_ON_ERROR),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
                : null,
        ],
        200,
        [],
        JSON_PRETTY_PRINT
    );
})->middleware(['auth0.authorize.optional']);

Route::get('/api/private-scoped', function () {
    return response()->json(
        [
            'message'    => 'Hello from a private endpoint! You need to be authenticated and have a scope of read:ideas to see this.',
            'authorized' => Auth::check(),
            'user'       => Auth::check()
                ? json_decode(
                    json_encode((array) Auth::user(), JSON_THROW_ON_ERROR),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
                : null,
        ],
        200,
        [],
        JSON_PRETTY_PRINT
    );
})->middleware(['auth0.authorize:read:ideas']);
