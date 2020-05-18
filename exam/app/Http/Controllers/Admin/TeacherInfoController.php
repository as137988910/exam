<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherInfoController extends Controller
{
    public function getTeacherList(){
        $teacher=new Teacher();
        $data=$teacher->paginate(10);
        return $data;
    }

    public function getTeacherByKey(Request $request){
        $key=$request->input('key');
        $teacher=new Teacher();
        $data=$teacher
            ->where('id',$key)
            ->orWhere('name',$key)
            ->orWhere('email','like','%'.$key.'%')
            ->paginate(10);
        return $data;
    }

    public function saveTeacher(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $age=$request->input('age');
        $school=$request->input('school');
        $teacher=new Teacher();
        $teacher->email=$email;
        $teacher->password=$password;
        $teacher->name=$name;
        $teacher->sex=$sex;
        $teacher->age=$age;
        return $teacher->save();
    }

    public function updateTeacher(Request $request){
        $id=$request->input('id');
        $email=$request->input('email');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $age=$request->input('age');
        $school=$request->input('school');
        $teacher=new teacher();
        $teacher=$teacher->find($id);
        $teacher->email=$email;
        $teacher->subject_id=1;
        $teacher->password=$password;
        $teacher->name=$name;
        $teacher->sex=$sex;
        $teacher->age=$age;
        $teacher->school=$school;
        return $teacher->save();
    }

    public function deleteTeacher(Request $request){
        $id=$request->input('id');
        $teacher=new Teacher();
        return $teacher->find($id)->delete();

    }
}
