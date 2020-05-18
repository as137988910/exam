<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function getUserList(){
        $student=new Student();
        $data=$student->paginate(10);
        return $data;
    }

    public function getUserByKey(Request $request){
        $key=$request->input('key');
        $student=new Student();
        $data=$student
            ->where('id',$key)
            ->orWhere('name',$key)
            ->orWhere('school','like','%'.$key.'%')
            ->orWhere('email','like','%'.key.'%')
            ->paginate(10);
        return $data;
    }

    public function saveUser(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $age=$request->input('age');
        $school=$request->input('school');
        $student=new Student();
        $student->email=$email;
        $student->password=$password;
        $student->name=$name;
        $student->sex=$sex;
        $student->age=$age;
        $student->school=$school;
        return $student->save();
    }

    public function updateUser(Request $request){
        $id=$request->input('id');
        $email=$request->input('email');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $age=$request->input('age');
        $school=$request->input('school');
        $student=new Student();
        $student=$student->find($id);
        $student->email=$email;
        $student->password=$password;
        $student->name=$name;
        $student->sex=$sex;
        $student->age=$age;
        $student->school=$school;
        return $student->save();
    }

    public function deleteUser(Request $request){
        $id=$request->input('id');
        $student=new Student();
        return $student->find($id)->delete();
    }
}
