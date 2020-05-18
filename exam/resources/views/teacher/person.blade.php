<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/person.css">
</head>

<body>
<header>
    <div class="logout">
        <a href="#" onclick="logout();" id="logout-btn">退出登录</a>
    </div>
    <div>
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
                <div class="selected">个人信息</div>
            </a>
        </nav>
    </div>
</header>
<div class="container">
    <div class="main">
        <h1 class="headline">个人信息</h1>
        <div class="info-detail">
            <div class="info-left">
                <form id="info-form" onsubmit="return false">
                    <input type="hidden" name="id" readonly id="id">
                    <div><span>E-mail：</span><input type="email" name="email" readonly id="email"></div>
                    <div><span>科目：</span><input type="text" name="subject" readonly id="subject"></div>
                    <div><span>密码：</span><input type="password" name="password" id="password" required></div>
                    <div><span>重复密码：</span><input type="password" id="rePassword" required></div>
                    <div><span>姓名：</span><input autocomplete="off" name="name" type="text" id="name" required></div>
                    <div><span>性别：</span>
                        <select id="sex" name="sex">
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </div>
                    <div><span>学校：</span><input autocomplete="off" type="text" id="school" name="school" required></div>
                    <div><span>年龄：</span><input autocomplete="off" type="text" id="age" name="age" required maxlength="2"></div>
                </form>
                <button onclick="saveInfo();" class="sub-btn">保存信息</button>
            </div>
            <div class="info-right">
                <div class="head-box">
                    <img src="/images/head.jpg" alt="">
                    <input type="file" accept=".jpe,.jpeg,.png">
                    <span>更换头像</span>
                </div>
            </div>
        </div>
    </div>
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
<script type="text/javascript">
    $(function () {
        $.get({
            async:true,
            url:"/api/teacher/getInfo",
            success:function (data) {
                console.log(data);
                data=JSON.parse(data);
                $("#id").val(data.id);
                $("#email").val(data.email);
                $("#subject").val(data.subject_name);
                $("#password").val(data.password);
                $("#name").val(data.name);
                if (data.sex=='男') {
                    document.getElementsByTagName('option')[0].selected='selected';
                }else {
                    document.getElementsByTagName('option')[1].selected='selected';
                }
                $("#school").val(data.school);
                $("#age").val(data.age);
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    })

    function saveInfo() {
        if ($("#password").val()!=$("#rePassword").val()){
            alert('两次密码不一致');
            return;
        }
        $.post({
            async:true,
            url:"/api/teacher/saveInfo",
            data:$("#info-form").serialize(),
            success:function (data) {
                if (data){
                    alert('修改成功');
                } else {
                    alert('修改失败');
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        // $("#info-form")
    }
</script>

</html>

