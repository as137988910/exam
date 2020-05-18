<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/user/home.css">
    <style>
        #notice-box{
            display: none;
            background-color: rgba(5,5,5,0.4);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            z-index: 100;
            left: 0;
        }
        .message-box{
            width: 350px;
            height: 200px;
            background-color: white;
            position: relative;
            top: 30%;
            margin: 0 auto;
        }
        #notice-title{
            width: 100%;
            margin-top: 10px;
            text-align: center;
        }
        #notice-content{
            width: 100%;
            margin-top: 10px;
            text-indent: 30px;
        }
        #notice-time{
            text-align: center;
            font-weight: 300;
            font-size: 14px;
            position: absolute;
            bottom: 0;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-top">
            <div class="header-span">
                <a href="#" onclick="logout();" id="logout-btn">退出登录</a>
            </div>
            <div class="header-button">
                <div class="header-button-block">
                    <a href="#" onclick="showLogin();">登录</a>
                    <p>/</p>
                    <a href="#" onclick="showRegister();">注册</a>
                </div>
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
            <div class="tip-box" onclick="showNoticeFrame()">
                <a style="cursor: pointer"><span class="tip-ico">通知</span>
                    <span id="tip-title">通知！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！</span>
                </a>
            </div>
            <div class="top-list">
                <div class="top-list-left">
                    <div class="list-headline">
                        <div class="gray-line">
                            <a href="" class="more-link block-inline">进行中的考试>>></a>
                        </div>
                    </div>
                    <div class="ing-exam">
                        <ul id="going-ul"></ul>
                    </div>
                </div>
                <div class="top-list-right">
                    <div class="head-bg">
                        <div class="head-box">
                            <img src="/images/head.jpg" alt="" id="headImg">
                            <h2 id="username">尚未登录</h2>
                        </div>
                    </div>
                    <div class="signature">
                        <p id="signature">这个人脑子一片空白~~</p>
                        <a href="/user/person">编辑个人信息</a>
                    </div>
                </div>
            </div>
            <div class="buttom-list">
                <div class="list-headline">
                    <div class="gray-line">
                        <a href="" class="more-link block-inline">已结束的考试>>></a>
                    </div>
                </div>
                <div class="flex">
                    <div class="finish-exam">
                        <ul id="over-ul"></ul>
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
    <div id="register-bg">
        <div class="form-box">
            <img src="/images/x.png" class="op-form" onClick="closeRegister();">
            <form action="#" method="post" class="sub-form" id="register-form" onsubmit="return false">
                <h2 class="font-green">考生注册</h2>
                <label class="form-label" for="email">邮箱：</label>
                <input type="text" id="Remail" name="email" placeholder="请输入你的邮箱" autocomplete="off" required>
                <label class="form-label" for="password">密码：</label>
                <input type="password" id="Rpassword" name="password" placeholder="请输入你的密码" autocomplete="off" required>
                <input type="password" id="Repassword" name="Repassword" placeholder="请再次输入你的密码" autocomplete="off" required>
                <label class="form-label" for="name">姓名：</label>
                <input type="text" id="name" name="name" placeholder="请输入你的姓名" autocomplete="off" required>
                <label class="form-label" for="sex">性别：</label>
                <select type="text" id="sex" name="sex">
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
                <div class="code-box">
                    <label class="form-label" for="code">验证码：</label>
                    <input type="text" id="Rcode" name="code" autocomplete="off" required>
                    <img src="/code" class="codeImg" id="register-code" onclick="this.src='/code?'+Math.random()">
                </div>
                <button type="submit" class="sub-btn" onclick="register()">注册</button>
            </form>
        </div>
    </div>
    <div id="login-bg">
        <div class="form-box">
            <img src="/images/x.png" class="op-form" onClick="closeLogin();">
            <form action="#" method="post" class="sub-form" id="login-form" onsubmit="return false">
                <h2 class="font-green">考生登录</h2>
                <label class="form-label" for="email">邮箱：</label>
                <input type="text" id="Lemail" name="email" placeholder="请输入你的邮箱" autocomplete="off" required>
                <label class="form-label" for="password">密码：</label>
                <input class="form-label" type="password" id="Lpassword" name="password" placeholder="请输入你的密码" required>
                <div class="code-box">
                    <label class="form-label" for="code">验证码：</label>
                    <input type="text" id="Lcode" name="code" autocomplete="off" required>
                    <img src="/code" class="codeImg" id="login-code" onclick="this.src='/code?'+Math.random()">
                </div>
                <button type="submit" class="sub-btn" onclick="login()">登录</button>
            </form>
        </div>
    </div>
    <div id="joinTest-pop">
        <div class="wrapper">
            <div class="table">
                <img src="/images/x.png" class="close-btn" onClick="cancelApply()">
                <h1 id="join-title">语文</h1>
                <div class="instruction-box"><span>说明:</span><p id="join-instruction">阿发sina搜到浓氨水佛in山东奥德</p></div>
                <div class="time-box">
                    <span>开始时间</span>
                    <span id="begin-time">2020-02-01 03:30:33</span>
                </div>
                <div class="time-box">
                    <span>截止时间</span>
                    <span id="end-time">2020-02-01 03:30:33</span>
                </div>
                <div class="apply-btn" id="btn-box"></div>
            </div>
        </div>
    </div>
<div id="notice-box" onclick="cancelFrame()">
    <div class="message-box">
        <h2 id="notice-title">sdsa</h2>
        <p id="notice-content">asfasdasd</p>
        <span id="notice-time">发布时间：</span>
    </div>
</div>
</body>
<script src="/js/app.js"></script>
<script src="/js/user/public.js"></script>
<script type="application/javascript">
    function closeRegister() {
        document.getElementById('register-bg').style.display = "none";
    }
    function cancelFrame() {
        document.getElementById('notice-box').style.display="none";
    }
    function showNoticeFrame() {
        document.getElementById('notice-box').style.display="block";
    }
    function closeLogin() {
        document.getElementById('login-bg').style.display = "none";
    }

    function showRegister() {
        document.getElementById('register-code').src='/code?'+Math.random();
        document.getElementById('register-bg').style.display = "block";
    }

    function showLogin() {
        document.getElementById('login-code').src='/code?'+Math.random();
        document.getElementById('login-bg').style.display = "block";
    }
    function login(){
        document.getElementById('login-code').src='/code?'+Math.random();
        $.post({
            async:true,
            url:'http://localhost/api/user/login',
            data:$("#login-form").serialize(),
            success:function (data) {
                data=JSON.parse(data);
                if (data.status==1){
                    var messsage=JSON.parse(data.message);
                    setCookie('role',messsage.role,1);
                    setCookie('name',messsage.name,1);
                    if(messsage.headImg==null){
                        setCookie('headImg','/images/head.jpg',1)
                    }else {
                        setCookie('headImg',messsage.headImg,1)
                    }
                    if (messsage.signature==null){
                        setCookie('signature','这个人脑子一片空白~~',1);
                    } else {
                        setCookie('signature',messsage.signature,1);
                    }
                    setCookie('id',messsage.id);
                    location.href="/user";
                } else {
                    alert(data.message);
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
    }

    function register(){
        document.getElementById('register-code').src='/code?'+Math.random();
        if($("#Rpassword").val()!=$("#Repassword").val()){
            alert('两次密码不一致');
            return;
        }
        $.post({
            async:true,
            url:'http://localhost/api/user/register',
            data:$("#register-form ").serialize(),
            success:function (data) {
                alert(data);
                if (data=='注册成功'){
                    location.href="/user";
                    showLogin();
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
    }
    window.onload=function() {
        if (getCookie('role')=='student'){
            document.getElementById('username').innerText=getCookie('name');
            document.getElementById('headImg').src=getCookie('headImg');
            document.getElementById('signature').innerText=getCookie('signature');
        }
    };
    var joinPaperArr=[];
    $(function(){
        var goingList=document.getElementById('going-ul');
        var overList=document.getElementById('over-ul');
        $.get({
            url:'/api/user/showGoingPaper',
            success:function (data) {
                data=JSON.parse(data);
                for (let i=0;i<data.length;i++){
                    let li=document.createElement('li');
                    li.innerHTML="<a class=\"ing-item\" onclick='apply(this)' pid="+data[i].id+">\n" +
                        "                                    <img src=\"/images/4.jpg\" alt=\"\">\n" +
                        "                                    <div>\n" +
                        "                                        <h3>"+data[i].title+"</h3>\n" +
                        "                                        <p>"+data[i].instruction+"</p>\n" +
                        "                                    </div>\n" +
                        "                                    <span hidden>"+data[i].begin+"</span>"+
                        "                                    <span hidden>"+data[i].end+"</span>"+
                        "                                </a>";
                    goingList.appendChild(li);
                }
                console.log(data)
            }
        });
        $.get({
            url:'/api/user/showOverPaper',
            success:function (data) {
                data=JSON.parse(data);
                for(let i=0;i<data.length;i++){
                    let li=document.createElement('li');
                    li.innerHTML="<a href=\"\">\n" +
                        "                                    <h3>"+data[i].title+"</h3>\n" +
                        "                                    <img src=\"/images/test.jpg\" alt=\"\">\n" +
                        "                                        <p>"+data[i].instruction+"</p>\n" +
                        "                                </a>";
                    overList.appendChild(li);
                }
                console.log(data)
            }
        });
        $.get({
            url:'/api/user/getApplyInfo?id='+getCookie('id'),
            success:function (data) {
                for (let i=0;i<data.length;i++){
                    joinPaperArr.push(data[i].template_id);
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
        $.get({
            url:'/logStatus',
            success:function (data) {
                if (!data){
                    setCookie('role','student',-1);
                    setCookie('headImg',0,-1);
                    setCookie('signature',0,-1);
                    setCookie('id',0,-1);
                }
            }
        })
    });
    var controlId;
    function apply(th) {
        controlId=th.getAttribute('pid');
        // console.log(joinPaperArr);
        // return
        if (joinPaperArr.includes(parseInt(controlId))){
            document.getElementById('btn-box').innerHTML="<button class='applied'\">已报名</button>";
        }else {
            document.getElementById('btn-box').innerHTML="<button onclick=\"sendApply()\">报名</button>";
        }
        var child=th.childNodes;
        var title=document.getElementById('join-title').innerText=child[3].childNodes[1].innerText;
        var instruction=document.getElementById('join-instruction').innerText=child[3].childNodes[3].innerText;
        var begin=document.getElementById('begin-time').innerText=child[5].innerText;
        var end=document.getElementById('end-time').innerText=child[7].innerText;
        cancelApply();
    }
    function sendApply() {
        if(getCookie('id').length==0){
            alert("你还未登录");
            cancelApply();
            showLogin();
            return;
        }
        joinPaperArr.push(controlId);
        $.post({
            url:'/api/user/applyPaper',
            data:{id:controlId,sid:getCookie('id')},
            success:function (data) {
                if (data){
                    document.getElementById('btn-box').innerHTML="<button class='applied'\">已报名</button>";
                }else {
                    alert('出错了')
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        console.log(controlId);
    }
    var applyFrameFlag=0;
    function cancelApply() {
        if (applyFrameFlag==0){
            document.getElementById('joinTest-pop').style.display='block';
            applyFrameFlag=1;
        }else {
            document.getElementById('joinTest-pop').style.display='none';
            applyFrameFlag=0;
        }
    }
    getNotice();
    function getNotice() {
        $.get({
            url:'/api/user/getNotice',
            success:function (data) {
                data=data[0];
                document.getElementById('notice-title').innerText=data.title;
                document.getElementById('tip-title').innerText=data.title;
                document.getElementById('notice-content').innerText=data.content;
                document.getElementById('notice-time').innerText="发布时间："+formatDate(data.created_at)
                console.log(data)
            }
        })
        // document.getElementById('tip-title').innerText
    }
    function formatDate(date) {
        date=new Date(date);
        let year=date.getFullYear();
        let mongth=(date.getMonth()+1)>9?(date.getMonth()+1):parseInt('0'+(date.getMonth()+1));
        let day=date.getDate();
        let hour=date.getHours();
        let minute=date.getMinutes();
        let second=date.getSeconds();
        mongth=mongth>9?mongth:('0'+mongth);
        day=day>9?day:('0'+day);
        hour=hour>9?hour:('0'+hour);
        minute=minute>9?minute:('0'+minute);
        second=second>9?second:('0'+second);
        return year+"-"+mongth+"-"+day+" "+hour+":"+minute+":"+second;
    }
</script>
</html>
