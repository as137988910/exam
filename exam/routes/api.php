<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::Group(['prefix'=>'user'],function (){
    Route::get('logout','User\UserActionController@logoutAction');
    Route::post('login','User\UserActionController@loginAction');
    Route::post('register','User\UserActionController@registerAction');

    //studentInfo
    Route::get('getInfo','User\UserInfoController@getInfo');
    Route::post('saveInfo','User\UserInfoController@saveInfo');

    //paper
    Route::get('showGoingPaper','User\PaperController@getGoingPaper');
    Route::get('showOverPaper','User\PaperController@getOverPaper');
    Route::get('getApplyPaper','User\PaperController@getApplyPaper');
    Route::get('showPaperDetail','User\PaperController@showPaperDetail');

    //grade
    Route::post('applyPaper','User\GradeController@apply');
    Route::get('getApplyInfo','User\GradeController@getApplyInfo');
    Route::get('getGradeReport','User\GradeController@getGradeReport');
    Route::get('getJoinPaper','User\GradeController@getJoinPaper');

    //problem
    Route::post('saveAnswer','User\AnswerController@saveAnswer');
    Route::get('getProblem','User\PaperController@getProblems');
    Route::get('getPaperAnswer','User\PaperController@getAnswer');

    //notice
    Route::get('getNotice','User\UserActionController@getNotice');
});
Route::Group(['prefix'=>'teacher'],function (){
    //teacherInfo
    Route::post('login','Teacher\TeacherActionController@loginAction');

    //answer
    Route::get('getAnswer','Teacher\AnswerController@getAnswer');
    Route::get('getAnswerProNum','Teacher\AnswerController@getAnswerProNum');

    //problem
    Route::post('createProblem','Teacher\ProblemController@create');
    Route::post('updateProblem','Teacher\ProblemController@update');
    Route::get('showProblem','Teacher\ProblemController@show');
    Route::get('searchProblem','Teacher\ProblemController@showById');

    //paper
    Route::post('savePaper','Teacher\PaperController@savePaper');
    Route::get('showPaper','Teacher\PaperController@showPaper');
    Route::get('getPaper','Teacher\PaperController@getPaper');
    Route::post('publishPaper','Teacher\PaperController@publishPaper');
    Route::post('changeStatus','Teacher\PaperController@changePaperStatus');

    //grade
    Route::get('searchStudent','Teacher\GradeController@searchStudent');
    Route::post('addPaperForStu','Teacher\GradeController@addGradeList');
    Route::post('updateScore','Teacher\GradeController@correctPaper');
    Route::get('getGradeTable','Teacher\GradeController@getGradeTable');
    //template
    Route::get('showTemplate','Teacher\PaperController@showTemplate');
    Route::post('savePaperTime','Teacher\TemplateController@savePublishTime');
    Route::get('showPublishPaper','Teacher\TemplateController@showPublishPaper');
    Route::get('searchTemplate','Teacher\PaperController@searchTemplate');
    Route::post('publishTemplate','Teacher\TemplateController@publishTemplate');
    Route::get('showCorrectPaper','Teacher\TemplateController@getCorrectPaper');
    Route::get('showGradePaper','Teacher\TemplateController@getGradePaper');
    //teacherInfo
    Route::get('getInfo','Teacher\TeacherInfoController@showInfo');
    Route::post('saveInfo','Teacher\TeacherInfoController@saveInfo');
});
Route::Group(['prefix'=>'admin'],function (){

    //adminInfo
    Route::get('getAdminInfo','Admin\AdminInfoController@getAdminInfo');
    Route::post('saveAdminInfo','Admin\AdminInfoController@saveAdminInfo');

    //user
    Route::get('getUserList','Admin\UserInfoController@getUserList');
    Route::get('getUserByKey','Admin\UserInfoController@getUserByKey');
    Route::post('saveUser','Admin\UserInfoController@saveUser');
    Route::delete('deleteUser','Admin\UserInfoController@deleteUser');
    Route::post('updateUser','Admin\UserInfoController@updateUser');

    //teacher
    Route::get('getTeacherList','Admin\TeacherInfoController@getTeacherList');
    Route::get('getTeacherByKey','Admin\TeacherInfoController@getTeacherByKey');
    Route::post('saveTeacher','Admin\TeacherInfoController@saveTeacher');
    Route::delete('deleteTeacher','Admin\TeacherInfoController@deleteTeacher');
    Route::post('updateTeacher','Admin\TeacherInfoController@updateTeacher');

    //notice
    Route::get('getNoticeList','Admin\NoticeController@getNoticeList');
    Route::post('saveNotice','Admin\NoticeController@saveNotice');

    //exam
    Route::get('getTemplateList','Admin\TemplateController@getTemplateList');
    Route::post('updateTemplate','Admin\TemplateController@updateTemplate');
});
Route::get('logout','Extend\HelperController@logout');
Route::post('adminLogin','Admin\AdminActionController@loginAction');
Route::get('adminLogout','Admin\AdminActionController@logoutAction');
