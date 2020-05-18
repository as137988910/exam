<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <style>
        footer{
            position: absolute;
            bottom: 0;
        }
        .container{
            position: fixed;
            height: 100%;
            background: rgba(255,255,255,0.2);
        }
        .nav{
            margin-top: 15%;
        }
        div.menu-btn{
            color: #202225;
            background-color: rgba(1,1,1,0);
        }
        div.menu-btn:hover{
            color: white;
            background-color: #9798ac;
        }
        .title{
            text-indent: 20px;
            color: #202225;
            display: inline-block;
            position: relative;
            margin: 20px 0;
        }
        .logout{
            display: inline-block;
            position: absolute;
            width: fit-content;
            right: 30px;
            margin: 20px 0;
        }
        .logout a{
            color: #202225;
        }
    </style>
</head>

<body>
<div class="container">
    <div>
        <h3 class="title">教师管理系统</h3>
        <div class="logout">
            <a href="#" onclick="logout();" id="logout-btn">退出登录</a>
        </div>
    </div>
        <nav class="nav">
            <a href="/teacher/problem" class="nav-btn">
                <div class="menu-btn">试题编辑</div>
            </a>
            <a href="/teacher/paper" class="nav-btn">
                <div class="menu-btn">试卷编辑</div>
            </a>
            <a href="/teacher/publish" class="nav-btn">
                <div class="menu-btn">我的试卷</div>
            </a>
            <a href="/teacher/correct" class="nav-btn">
                <div class="menu-btn">批改试卷</div>
            </a>
            <a href="/teacher/grade" class="nav-btn">
                <div class="menu-btn">成绩总览</div>
            </a>
            <a href="/teacher/person" class="nav-btn">
                <div class="menu-btn">个人信息</div>
            </a>
        </nav>
</div>
<footer>
    <div class="copyright">
        <p>Copyright 2020, HW</p>
    </div>
    <div class="footer-link">
        <nav class="footer">
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

</html>
