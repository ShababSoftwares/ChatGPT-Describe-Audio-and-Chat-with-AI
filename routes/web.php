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
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return back();
});

Auth::routes();

Route::get('/', [\App\Http\Controllers\DescribeAudioContoller::class,'uploaded_files'])->name('uploaded_files')->middleware('auth');;
Route::get('/uploaded_files.html', [\App\Http\Controllers\DescribeAudioContoller::class,'uploaded_files'])->name('uploaded_files')->middleware('auth');;
Route::get('/upload_file.html', [\App\Http\Controllers\DescribeAudioContoller::class,'upload_file'])->name('upload_file')->middleware('auth');;
Route::post('/post_upload_file', [\App\Http\Controllers\DescribeAudioContoller::class,'post_upload_file'])->name('post_upload_file')->middleware('auth');;
Route::get('/ask_questions/{file_id}', [\App\Http\Controllers\DescribeAudioContoller::class,'ask_questions'])->name('ask_questions')->middleware('auth');;
Route::post('/post_ask_question', [\App\Http\Controllers\DescribeAudioContoller::class,'post_ask_question'])->name('post_ask_question')->middleware('auth');;
Route::post('/post_delete_questions', [\App\Http\Controllers\DescribeAudioContoller::class,'post_delete_questions'])->name('post_delete_questions')->middleware('auth');;
Route::post('/delete_file_chat', [\App\Http\Controllers\DescribeAudioContoller::class,'delete_file_chat'])->name('delete_file_chat')->middleware('auth');;

Route::get('/test-file.html', [\App\Http\Controllers\DescribeAudioContoller::class,'test_file'])->name('test-file')->middleware('auth');;