<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>在线考试管理员管理系统</title>
    <link href="/css/admin/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin/materialdesignicons.min.css" rel="stylesheet">
    <link href="/css/admin/style.min.css" rel="stylesheet">
    <style>
        h3 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
<div class="lyear-layout-web">
    <div class="lyear-layout-container">
        <!--左侧导航-->
        <aside class="lyear-layout-sidebar">

            <!-- logo -->
            <div id="logo" class="sidebar-header">
                <h3>管理员管理系统</h3>
            </div>
            <div class="lyear-layout-sidebar-scroll">

                <nav class="sidebar-main">
                    <ul class="nav nav-drawer">
                        <li class="nav-item nav-item-has-subnav active open"><a href="/admin/home"><i
                                    class="mdi-account-edit"></i>我的信息</a></li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/notice"><i class="mdi mdi-comment-processing"></i>通知信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/student"><i class="mdi mdi-account"></i>考生信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/teacher"><i class="mdi mdi-account-location"></i>教师信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/exam"><i class="mdi mdi-note-multiple-outline"></i>考试信息</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>
        <!--End 左侧导航-->

        <!--头部信息-->
        <header class="lyear-layout-header">

            <nav class="navbar navbar-default">
                <div class="topbar">
                    <ul class="topbar-right">
                        <li class="dropdown dropdown-profile">
                            <a href="javascript:void(0)" data-toggle="dropdown">
                                <span id="name">李四<span class="caret"></span></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li> <a href="/user"><i class="mdi mdi-alarm-check"></i> 考生考试系统</a> </li>
                                <li> <a href="/teacher"><i class="mdi mdi-lock-outline"></i> 教师管理系统</a></li>
                                <li class="divider"></li>
                                <li><a href="/api/adminLogout"><i class="mdi mdi-logout-variant"></i> 退出登录</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        </header>
        <!--End 头部信息-->

        <!--页面主要内容-->
        <main class="lyear-layout-content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="edit-avatar">
                                    <img src="/images/head.jpg" alt="..." class="img-avatar">
                                    <div class="avatar-divider"></div>
                                    <div class="edit-avatar-content">
                                        <button class="btn btn-default">修改头像</button>
                                        <p class="m-0">更改你的头像。</p>
                                    </div>
                                </div>
                                <hr>
                                <form onsubmit="return false" id="info-form">
                                    <div class="form-group">
                                        <label for="username">用户名</label>
                                        <input type="text" class="form-control" name="username" id="username"
                                               disabled="disabled"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">姓名</label>
                                        <input type="text" class="form-control" name="name" id="Aname"
                                               placeholder="输入您的姓名" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">邮箱</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                               aria-describedby="emailHelp" placeholder="请输入正确的邮箱地址" autocomplete="off">
                                        <small id="emailHelp" class="form-text text-muted">请保证您填写的邮箱地址是正确的。</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">密码</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="输入密码">
                                        <input type="password" class="form-control" name="rePassword" id="rePassword"
                                               placeholder="重复你的密码">
                                    </div>
                                    <div class="form-group">
                                        <label for="age">年龄</label>
                                        <input type="age" class="form-control" name="age" id="age" placeholder="输入年龄"
                                               maxlength="3">
                                    </div>
                                    <div class="form-group">
                                        <label for="sex">性别</label>
                                        <input type="text" class="form-control" name="sex" id="sex" placeholder="男/女" autocomplete="off">
                                    </div>
                                    <button type="submit" class="btn btn-primary" onclick="saveInfo()">保存</button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </main>
        <!--End 页面主要内容-->
    </div>
</div>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/admin/public.js"></script>
<script type="text/javascript">
    $(function () {
        $('.search-bar .dropdown-menu a').click(function () {
            var field = $(this).data('field') || '';
            $('#search-field').val(field);
            $('#search-btn').html($(this).text() + ' <span class="caret"></span>');
        });
        $.get({
            url:'/api/admin/getAdminInfo',
            success:function (data) {
                data=data[0];
                document.getElementById('username').value=data.username;
                document.getElementById('name').innerText=data.name+"▼";
                document.getElementById('Aname').value=data.name;
                document.getElementById('email').value=data.email;
                document.getElementById('password').value=data.password;
                document.getElementById('age').value=data.age;
                document.getElementById('sex').value=data.sex;
            }
        })
    });
    
    function saveInfo() {
        $("input").each(function (i,value) {
           if (value.value ==''){
               alert("信息不能为空");
               return;
           }
        });
        if (document.getElementById('password').value!=document.getElementById('rePassword').value){
            alert('两次密码不一致')
            return;
        }
        $.post({
            url:'/api/admin/saveAdminInfo',
            data:$("#info-form").serialize(),
            success:function (data) {
                alert(data);
            }
        })
    }
</script>
</body>
</html>
