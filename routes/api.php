<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function (Request $request) {
    $rand = rand(0,99999999999);
    $javaFile = fopen($rand.".java", "w");
    fwrite($javaFile, $request->code);
    fclose($javaFile);
    $output = [];
    exec('javac '.$rand.'.java');
    $output = [];
    exec('java Test', $output);
    unlink($rand.".java");
    unlink("Test.class");
    return $output;
});