<?php


namespace App\Http\Controllers\Teacher;


use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherInfoController
{
    public function saveInfo(Request $request){
        $id=session('tid');
        $teacher=new Teacher();
        $teacher=$teacher->find($id);
        $teacher->name=$request->input('name');
        $teacher->age=$request->input('age');
        $teacher->sex=$request->input('sex');
        $teacher->password=$request->input('password');
        $teacher->school=$request->input('school');
        return $teacher->save();
    }

    public function showInfo(){
        $id=session('tid');
        $teacher=new Teacher();
        $teacher=$teacher->join('subjects','teachers.subject_id','=','subjects.id')->find($id);
//        return json_encode(session('tid'));
        return json_encode($teacher);
    }
}
