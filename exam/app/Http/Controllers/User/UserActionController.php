<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Extend\HelperController;
use App\Models\Notice;
use App\Models\Student;
use Illuminate\Http\Request;

class UserActionController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('validate');
//    }

    public function loginAction(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $helper = new HelperController();
        if ($helper->verifyCaptcha($_POST['code'])) {
            $data=Student::where('email', $email)
                    ->where('password', $password)->get();
            if(count($data)>0){
                session(['verify'=> 'yes']);
                session(['role'=>'student']);
//                session(['stu_id'=>$data[0]['id']]);
                $headImg=$data[0]['headImg'];
                $signature=$data[0]['signature'];
                $id=$data[0]['id'];
                $name=$data[0]['name'];
//                redirect('user/grade');
                $status=1;
                $message= json_encode(array(
                    'name'=>$name,
                    'role'=>session('role'),
                    'id'=>$id,
                    'headImg'=>$headImg,
                    'signature'=>$signature
                ));
            }else{
                $status=2;
                $message= '账号或密码错误';
            }
        } else {
            $status=3;
            $message= '验证码错误';
        }
        return json_encode(array(
           'status'=>$status,
           'message'=>$message
        ));
    }

    public function registerAction(Request $request)
    {
        $email=$request->input('email');
        $password=$request->input('password');
        $name=$request->input('name');
        $sex=$request->input('sex');
        $code=$request->input('code');
        $helper = new HelperController();
//        return $request->session()->get('code');
        if ($helper->verifyCaptcha($code)) {
            if (Student::where('email',$email)->count()<1){
                $student=new Student();
                $student->email=$email;
                $student->password=$password;
                $student->name=$name;
                $student->sex=$sex;
                $student->save();
                return '注册成功';
            }else{
                return '用户名已占用';
            }
        }else{
            return '验证码错误';
        }
    }
    public function index()
    {

    }
    public function getNotice(){
        $notice=new Notice();
        $data=$notice->take(1)->get();
        return $data;
    }
}
