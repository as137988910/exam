<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/login.css">
</head>

<body>
    <header>
        <h1>教师管理系统</h1>
    </header>
    <div class="container">
        <div class="form">
            <form onsubmit="return false" id="tLogin-form">
                <div class="row">
                    <span>E-mail：</span>
                    <input type="text" name="email" autocomplete="off">
                </div>
                <div class="row">
                    <span>密码：</span>
                    <input type="password" name="password">
                </div>
                <div class="row">
                    <button onclick="login();">登录</button>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <div class="copyright">
            <p>Copyright 2020, HW</p>
        </div>
        <div class="footer-link">
            <nav>
                <a href="/admin/login">管理员管理系统</a>
                <a href="/user">考生考试系统</a>
                <a href="">联系我</a>
                <a href="https://github.com/as137988910/exam">github源码</a>
                </ul>
            </nav>
        </div>
    </footer>
</body>
<script src="/js/app.js"></script>
<script src="/js/teacher/public.js"></script>
<script>
    function login() {
        $.post({
           async:true,
           url:'/api/teacher/login',
           data:$("#tLogin-form").serialize(),
           success:function (data) {
               data=JSON.parse(data);
               if (data.status==1){
                   let messsage=JSON.parse(data.message);
                   setCookie('role',messsage.role,1);
                   setCookie('tid',messsage.tid,1);
                   setCookie('name',messsage.name,1);
                   setCookie('sex',messsage.sex,1);
                   setCookie('subject',messsage.subject,1);
                   location.href="/teacher/home";
               } else {
                   alert(data.message);
               }
           },
           error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
    }
</script>
</html>
