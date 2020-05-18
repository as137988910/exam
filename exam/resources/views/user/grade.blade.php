<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/user/grade.css">
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
            <div class="search-row move-mid" id="search-box">
                <input type="text" placeholder="请输入你的准考证号" id="addmissionId">
                <button onclick="getGrade()">查询</button>
            </div>
            <div id="tablespace"></div>
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
<script type="application/javascript">
    function getGrade() {
        var addmissionId=document.getElementById('addmissionId').value;
        var tableSpace=document.getElementById('tablespace');
        tableSpace.innerHTML='';
        if (addmissionId==''){
            document.getElementById('search-box').className="search-row move-mid";
            return;
        }
        document.getElementById('search-box').className="search-row move-top";
        setTimeout(function () {
            $.get({
                async:true,
                url:'/api/user/getGradeReport?addmissionId='+addmissionId,
                success:function (data) {
                    console.log(data)
                    if (data.status!=2){
                        alert(data.data);
                    } else {
                        data=data.data[0];
                        tableSpace.innerHTML="\n" +
                            "            <table border=\"1\" cellspacing=\"0\">\n" +
                            "                <thead>\n" +
                            "                    <tr>\n" +
                            "                        <td class=\"grade-title\" colspan=\"6\">成绩单</td>\n" +
                            "                    </tr>\n" +
                            "                </thead>\n" +
                            "                <tbody>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">姓名</td>\n" +
                            "                        <td colspan=\"1\" id=\"name\">"+data.name+"</td>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">年龄</td>\n" +
                            "                        <td colspan=\"1\" id=\"age\">"+data.age+"</td>\n" +
                            "                        <td rowspan=\"2\" colspan=\"1\" class=\"head\"><img src=\"/images/head.jpg\" alt=\"\"></td>\n" +
                            "                    </tr>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">性别</td>\n" +
                            "                        <td colspan=\"1\" id=\"sex\">"+data.sex+"</td>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">准考证号</td>\n" +
                            "                        <td colspan=\"1\" id=\"admission\">"+data.addmission_id+"</td>\n" +
                            // "                        <td colspan=\"2\" id=\"admission\"></td>\n" +
                            "                    </tr>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">总分</td>\n" +
                            "                        <td colspan=\"1\" id=\"\">"+data.total+"</td>\n" +
                            "                        <td colspan=\"1\" class=\"top-title\">试卷名</td>\n" +
                            "                        <td colspan=\"2\" id=\"\">"+data.title+"</td>\n" +
                            "                    </tr>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"3\" class=\"top-title\">得分</td>\n" +
                            "                        <td colspan=\"3\" id=\"\">"+data.score+"</td>\n" +
                            "                    </tr>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"3\" class=\"top-title\">发布时间</td>\n" +
                            "                        <td colspan=\"3\" id=\"\">"+data.begin+"</td>\n" +
                            "                    </tr>\n" +
                            "                    <tr>\n" +
                            "                        <td colspan=\"3\" class=\"top-title\">截止时间</td>\n" +
                            "                        <td colspan=\"3\" id=\"\">"+data.end+"</td>\n" +
                            "                    </tr>\n" +
                            "                </tbody>\n" +
                            "            </table>"
                    }
                }
            })
        },1000)
    }
</script>
</html>
