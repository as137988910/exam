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
        .cancel-btn{
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .cancel-btn>img{
            width: 30px;
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
                        <li class="nav-item"><a href="/admin/home"><i class="mdi mdi-account-edit"></i>我的信息</a></li>
                        <li class="nav-item nav-item-has-subnav active open">
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
                            <div class="card-toolbar clearfix">
                                <div class="toolbar-btn-action">
                                    <a class="btn btn-primary m-r-5" href="#!" onclick="showSubFrame()"><i class="mdi mdi-plus"></i> 新增</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>编号</th>
                                            <th>标题</th>
                                            <th>内容</th>
                                            <th>发布时间</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody"></tbody>
                                    </table>
                                </div>
                                <ul class="pagination" id="pageUl"></ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </main>
        <!--End 页面主要内容-->
    </div>
</div>
<div id="pop-box">
    <div class="layui-layer-shade" id="layui-layer-shade1"
         style="position:absolute;display: none;top: 0;left:0;width:100%;height:100%;z-index: 19891014; background-color: rgba(0, 0, 0,0.4);">
        <div class="layui-layer layui-layer-iframe" id="layui-layer1" type="iframe" times="1" showtime="0" contype="string"
             style="position:absolute;z-index: 19891015; width: 400px;padding: 20px 30px; height: 400px; top: 141px; left: 40%;background-color: white;">
            <form onsubmit="return false" id="notice-form" class="center-block">
                <div class="form-group">
                    <a class="cancel-btn" onclick="closeSubFrame()"><img src="/images/x.png"></a>
                </div>
                <div class="form-group">
                    <label for="title">标题：</label>
                    <div class="col-xs-12">
                        <input type="text" id="title" name="title" required="" autocomplete="off" class="form-control col-xs-3" placeholder="标题">
                    </div>
                </div>
                <div class="form-group-lg">
                    <label for="content">通知信息：</label>
                    <div class="col-xs-12">
                        <textarea type="text" id="content" name="content" required="" autocomplete="off" class="form-control" placeholder="通知信息" rows="6"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary center-block" onclick="saveNotice()">保存</button>
                </div>
            </form>
        </div>
    </div>
    <div>
    <span class="layui-layer-setwin"><a class="layui-layer-min" href="javascript:;"><cite></cite></a><a
            class="layui-layer-ico layui-layer-max" href="javascript:;"></a><a
            class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a></span><span
            class="layui-layer-resize"></span></div>
</div>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/admin/public.js"></script>
<script type="text/javascript">
    var tbody = document.getElementById('tbody');
    var currentPage;
    var lastPage;
    $(function () {
        $('.search-bar .dropdown-menu a').click(function () {
            var field = $(this).data('field') || '';
            $('#search-field').val(field);
            $('#search-btn').html($(this).text() + ' <span class="caret"></span>');
        });
    });
    function closeSubFrame() {
        document.getElementById('layui-layer-shade1').style.display="none";
    }
    function showSubFrame() {
        document.getElementById('layui-layer-shade1').style.display="block";
    }

    getNotice();
    function getNotice(page) {
        var page = page || 1;
        tbody.innerHTML = "";
        $.get({
            url: '/api/admin/getNoticeList',
            success: function (data) {
                generatePage(data, "getNotice");
                data = data.data;
                for (let i = 0; i < data.length; i++) {
                    var tr = document.createElement('tr');
                    tr.innerHTML = "\n" +
                        "                                        <tr>\n" +
                        "                                            <td>"+data[i].id+"</td>\n" +
                        "                                            <td>"+data[i].title+"</td>\n" +
                        "                                            <td>"+data[i].content+"</td>\n" +
                        "                                            <td>"+formatDate(data[i].created_at)+"</td>\n" +
                        "                                        </tr>";
                    tbody.appendChild(tr);
                }
            }
        })
    }

    function saveNotice() {
        $.post({
            url:'/api/admin/saveNotice',
            data:$("#notice-form").serialize(),
            success:function (data) {
                console.log(data)
            },
            error:function (jqXHR) {
                console.log(jqXHR);
            }
        })
    }
</script>
</body>
</html>
