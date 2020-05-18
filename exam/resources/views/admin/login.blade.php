<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>在线考试管理员管理系统</title>
    <link href="/css/admin/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin/materialdesignicons.min.css" rel="stylesheet">
    <link href="/css/admin/style.min.css" rel="stylesheet">
    <style>
        .lyear-wrapper {
            position: relative;
        }
        .lyear-login {
            display: flex !important;
            min-height: 100vh;
            align-items: center !important;
            justify-content: center !important;
        }
        .login-center {
            background: #fff;
            min-width: 38.25rem;
            padding: 2.14286em 3.57143em;
            border-radius: 5px;
            margin: 2.85714em 0;
        }
        .login-header {
            margin-bottom: 1.5rem !important;
        }
        .login-center .has-feedback.feedback-left .form-control {
            padding-left: 38px;
            padding-right: 12px;
        }
        .login-center .has-feedback.feedback-left .form-control-feedback {
            left: 0;
            right: auto;
            width: 38px;
            height: 38px;
            line-height: 38px;
            z-index: 4;
            color: #dcdcdc;
        }
        .login-center .has-feedback.feedback-left.row .form-control-feedback {
            left: 15px;
        }
        body{
            background-image: url("/images/admin-bg.png");
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
<div class="row lyear-wrapper">
    <div class="lyear-login">
        <div class="login-center">
            <div class="login-header text-center">
                <h3>管理员管理系统</h3>
            </div>
            <form onsubmit="return false" id="login-form">
                <div class="form-group has-feedback feedback-left">
                    <input type="text" placeholder="请输入您的用户名" class="form-control" name="username" id="username" autocomplete="off"/>
                    <span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left">
                    <input type="password" placeholder="请输入密码" class="form-control" id="password" name="password" />
                    <span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left row">
                    <div class="col-xs-7">
                        <input type="text" name="captcha" class="form-control" placeholder="验证码" autocomplete="off">
                        <span class="mdi mdi-check-all form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-5">
                        <img src="/getAcode" class="pull-right" id="captcha" style="cursor: pointer;" onclick="this.src=this.src+'?d='+Math.random();" title="点击刷新" alt="captcha">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="button" onclick="login()">立即登录</button>
                </div>
            </form>
            <hr>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/user/public.js"></script>
{{--<script type="text/javascript" src="/js/admin/jquery.min.js"></script>--}}
{{--<script type="text/javascript" src="/js/bootstrap.min.js"></script>--}}
<script type="text/javascript">
    function login(){
        // console.log($("#login-form").serialize())
        // return
        $.post({
            data:$("#login-form").serialize(),
            url:'/api/adminLogin',
            success:function (data) {
                if (parseInt(data.status)==1){
                    alert('登录成功');
                    setCookie('aname',data.data.name,1);
                    setCookie('aid',data.data.id,1);
                    location.href="/admin/home"
                }else {
                    alert(data.data);
                    document.getElementById('captcha').src="/getAcode?"+Math.random();
                }
            },error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
</script>
</body>
</html>
