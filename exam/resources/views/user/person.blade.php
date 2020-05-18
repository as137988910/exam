<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/user/person.css">
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
            <h1 class="headline">个人信息<span class="font-green">|</span></h1>
            <div class="info-detail">
                <div class="info-left">
                    <form id="info-form" onsubmit="return false">
                       <input type="hidden" name="id" readonly id="id">
                        <div><span>E-mail：</span><input type="email" name="email" readonly id="email"></div>
                        <div><span>姓名：</span><input autocomplete="off" name="name" type="text" id="name" required></div>
                        <div><span>密码：</span><input type="password" name="password" id="password" required></div>
                        <div><span>重复密码：</span><input type="password" id="rePassword" required></div>
                        <div><span>性别：</span>
                            <select id="sex" name="sex">
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </div>
                        <div><span>学校：</span><input autocomplete="off" type="text" id="school" name="school" required></div>
                        <div><span>年龄：</span><input autocomplete="off" type="text" id="age" name="age" required maxlength="2"></div>
                        <div><span>个性签名：</span><textarea autocomplete="off" name="signature" id="signature" required ></textarea></div>
                    </form>
                    <button onclick="saveInfo();">保存信息</button>
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
<script>
    $(function () {
        $.get({
            async:true,
            url:"/api/user/getInfo?id="+getCookie('id'),
            success:function (data) {
                data=JSON.parse(data)[0];
                $("#id").val(data.id);
                $("#email").val(data.email);
                $("#password").val(data.password);
                $("#name").val(data.name);
                if (data.sex=='男') {
                    document.getElementsByTagName('option')[0].selected='selected';
                }else {
                    document.getElementsByTagName('option')[1].selected='selected';
                }
                $("#school").val(data.school);
                $("#age").val(data.age);
                setCookie('name',data.name,1);
                setCookie('signature',data.signature,1);
                $("#signature").attr('placeholder',data.signature);
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        // document.getElementById('signature').setAttribute('placeholder',getCookie('signature'));
    })

    function saveInfo() {
        if ($("#password").val()!=$("#rePassword").val()){
            alert('两次密码不一致');
            return;
        }
        $.post({
            async:true,
            url:"/api/user/saveInfo",
            data:$("#info-form").serialize(),
            success:function (data) {
                alert(data)
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        $("#info-form")
    }
</script>
</html>
