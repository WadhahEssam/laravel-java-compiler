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
    return $request['code'];

    $rand = rand(0,99999999999);
    $javaFile = fopen($rand.".java", "w");
    fwrite($javaFile, $request->code);
    fclose($javaFile);
    unlink($rand.".java");
    $output = [];
    exec('pwd', $output);
    exec('javac Test.java');
    $output = [];
    exec('java Test', $output);
    return $output;
});