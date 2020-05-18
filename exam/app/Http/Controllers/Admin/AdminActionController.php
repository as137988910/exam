<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Extend\HelperController;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminActionController extends Controller
{
    public function loginAction(Request $request){
        $username=$request->input('username');
        $password=$request->input('password');
        $captcha=$request->input('captcha');
        $helper=new HelperController();
        if ($helper->verifyCaptchaAdmin($captcha)){
            $admin=new Admin();
            $data=$admin->where('username',$username)
                ->where('password',$password)
                ->get();
            if (count($data)>0){
                session(['aid'=>$data[0]['id']]);
                $msg=[
                    'status'=>1,
                    'data'=>$data[0]
                ];
            }else{
                $msg=[
                    'status'=>0,
                    'data'=>'用户名或密码错误'
                ];
            }
        }else{
            $msg=[
                'status'=>2,
                'data'=>'验证错误'
            ];
        }
        return $msg;
    }

    public function logoutAction(){
        session(['aid'=>'']);
        return redirect('/admin/login');
    }
}
