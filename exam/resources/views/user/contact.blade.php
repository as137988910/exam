<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
</head>

<body>
    <header>
        <div class="header-top">
            <div class="header-span">
                <a href="#" onclick="logout();" id="logout-btn">退出登录</a>
            </div>
            <div class="dropdown">
                <button class="dropbtn">菜单∨</button>
                <div class="dropdown-content">
                    <a href="/user">首页</a>
                    <a href="/user/grade">成绩单</a>
                    <a href="/user/exam">我的考试</a>
                    <a href="/user/admission">电子准考证</a>
                    <a href="/user/person">个人信息</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="main">

        </div>
    </div>
    <footer>
        <div class="copyright">
            <p>Copyright 2020, HW</p>
        </div>
        <div class="footer-link">
            <ul class="link">
                <li><a href="/admin/login">管理员管理系统</a></li>
                <li><a href="/teacher">教师管理系统</a></li>
                <li><a href="">联系我</a></li>
                <li><a href="https://github.com/as137988910/exam">github源码</a></li>
            </ul>
        </div>
    </footer>
</body>
<script src="/js/app.js"></script>
<script src="/js/user/public.js"></script>

</html>
