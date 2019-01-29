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
    //It it's a file.
    if (is_file($str)) {
        //Attempt to delete it.
        return unlink($str);
    }
    //If it's a directory.
    elseif (is_dir($str)) {
        //Get a list of the files in this directory.
        $scan = glob(rtrim($str,'/').'/*');
        //Loop through the list of files.
        foreach($scan as $index=>$path) {
            //Call our recursive function.
            deleteAll($path);
        }
        //Remove the directory itself.
        // return @rmdir($str);
        return;
    }
}