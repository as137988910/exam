<?php


namespace App\Http\Controllers\Teacher;


use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherActionController extends Controller
{
    public function loginAction(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        $teacher=new Teacher();
//        $data=$teacher->where('email',$email)
//            ->where('password',$password)->subject()->get();
        $data=$teacher->join('subjects','teachers.subject_id','=','subjects.id')
            ->where('email',$email)
            ->where('password',$password)
            ->get(['teachers.id','teachers.sex','teachers.name','subjects.subject_name']);
        if (count($data)>0){
            $status=1;
            $data=$data[0];
//            session(['verify'=> 'yes','tid'=>$data['id'],'role'=>'teacher','subject'=>$data['subject_name']]);
            session(['verify'=> 'yes','tid'=>$data['id'],'role'=>'teacher','subject'=>$data['subject_name'],'tname'=>$data['name']]);
            $message=json_encode(array(
                'role'=>'teacher',
                'tid'=>$data['id'],
                'name'=>$data['name'],
                'sex'=>$data['sex'],
                'subject'=>$data['subject_name']
            ));
        }else{
            $status=2;
            $message='请检查用户名或密码';
        }
        return json_encode(array('status'=>$status,'message'=>$message));
    }
}
