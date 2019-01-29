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

Route::post('/compileJava', function (Request $request) {
    $rand = rand(0,99999999999);
    mkdir('compiledFiles');
    mkdir('compiledFiles/'.$rand);
    $javaFile = fopen('compiledFiles/'.$rand.'/Test.java', 'w');
    fwrite($javaFile, $request->code);
    fclose($javaFile);
    $output = [];
    exec('javac compiledFiles/'.$rand.'/Test.java');
    exec('cd compiledFiles && cd '.$rand.' && java Test', $output);
    deleteAll('compiledFiles');
    return $output;
});

// remove files and folders inside a  directory
function deleteAll($str) {
    if (is_file($str)) {
        return unlink($str);
    }
    elseif (is_dir($str)) {
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path) {
            deleteAll($path);
        }
        return @rmdir($str);
    }
}