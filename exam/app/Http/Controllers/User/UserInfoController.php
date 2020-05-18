<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{

    public function __construct()
    {
        $this->middleware('validate');
    }

    function getInfo(){
        $id=$_GET['id'];
        $student=new Student();
        $data=$student::where('id',$id)->get();
        return json_encode($data);
    }

    function saveInfo(Request $request){
        $id=$request->input('id');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $school=$request->input('school');
        $age=$request->input('age');
        $signature=$request->input('signature');
        $student=Student::find($id);
        $student->password=$password;
        $student->name=$name;
        $student->sex=$sex;
        $student->school=$school;
        $student->age=$age;
        $student->signature=$signature;
        if ($student->save()){
            return '修改成功';
        }else{
            return '修改失败';
        }
    }
}
