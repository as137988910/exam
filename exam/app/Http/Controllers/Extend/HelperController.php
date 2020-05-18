<?php


namespace App\Http\Controllers\Extend;


use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Routing\Controller;

class HelperController extends Controller
{
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 120, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['code' => $phrase]);
        //生成图片
        return response()->stream(
            function () use ($builder) {
                echo $builder->output();
            },
            200, ['Content-Type' => 'image/jpeg']);
    }

    public function verifyCaptcha($codeStr)
    {
        $code = session()->get('code');
        if (strtolower($codeStr) == strtolower($code)) {
            return true;
        } else {
            return false;
        }
    }
    public function captchaAdmin()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 120, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['aCode' => $phrase]);
        //生成图片
        return response()->stream(
            function () use ($builder) {
                echo $builder->output();
            },
            200, ['Content-Type' => 'image/jpeg']);
    }

    public function verifyCaptchaAdmin($codeStr)
    {
        $code = session()->get('aCode');
        if (strtolower($codeStr) == strtolower($code)) {
            return true;
        } else {
            return false;
        }
    }

    public function logout(){
        session(['stu_id'=>'']);
        session(['verify'=>'']);
        session(['role'=>'']);
        session(['subject'=>'']);
    }

    public function logStatus(){
        if (!session('verify')){
            return false;
        }else{
            return true;
        }
    }
}
