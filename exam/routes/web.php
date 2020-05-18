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

Route::get('user',function ()
{
    return view('user/home');
});
Route::get('/',function ()
{
    return redirect('user');
});
Route::group(['prefix'=>'user','middleware'=>['validate']],function ()
{
    Route::get('admission',function ()
    {
        return view('user/admission');
    });
    
    Route::get('contact',function ()
    {
        return view('user/contact');
    });
    
    Route::get('exam',function ()
    {
        return view('user/exam');
    });
    
    Route::get('examDetail',function ()
    {
        return view('user/examDetail');
    });
    
    Route::get('grade',function ()
    {
        return view('user/grade');
    });

    Route::get('person',function ()
    {
        return view('user/person');
    });

    Route::get('notice',function ()
    {
        return view('user/notice');
    });
});

Route::group(['prefix'=>'admin'],function ()
{
    Route::get('/',function ()
    {
        return redirect('admin/login');
    });

    Route::get('login',function(){
        return view('admin/login');
    });

    Route::get('home',function(){
        return view('admin/home');
    });

    Route::get('notice',function (){
       return view('admin/notice');
    });
    Route::get('teacher',function (){
        return view('admin/teacher');
    });
    Route::get('student',function (){
        return view('admin/student');
    });
    Route::get('exam',function (){
        return view('admin/exam');
    });
});

Route::get('teacher',function ()
{
    return redirect('teacher/login');
});

Route::get('teacher/login',function ()
{
    return view('teacher/login');
});
Route::group(['prefix'=>'teacher','middleware'=>['validate']],function ()
{
    Route::get('home',function (){
       return view('teacher/home');
    });
    Route::get('paper',function ()
    {
       return view('teacher/paper'); 
    });
    
    Route::get('person',function ()
    {
       return view('teacher/person');
    });
    
    Route::get('correct',function ()
    {
       return view('teacher/correct'); 
    });
    
    Route::get('grade',function ()
    {
       return view('teacher/grade'); 
    });
    
    Route::get('publish',function ()
    {
       return view('teacher/publish'); 
    });
    Route::get('problem',function ()
    {
        return view('teacher/problem');
    });
});

Route::get('code','Extend\HelperController@captcha');
Route::get('tcode','Extend\HelperController@verifyCaptcha');
Route::get('getAcode','Extend\HelperController@captchaAdmin');
Route::get('verifyAcode','Extend\HelperController@verifyCaptchaAdmin');
Route::get('logStatus','Extend\HelperController@logStatus');
