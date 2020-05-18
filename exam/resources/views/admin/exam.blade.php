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
                        <li class="nav-item"><a href="/admin/home"><i class="mdi mdi-account-edit"></i>我的信息</a></li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/notice"><i class="mdi mdi-comment-processing"></i>通知信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/student"><i class="mdi mdi-account"></i>考生信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav">
                            <a href="/admin/teacher"><i class="mdi mdi-account-location"></i>教师信息</a>
                        </li>
                        <li class="nav-item nav-item-has-subnav active open">
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
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>编号</th>
                                            <th>试卷编号</th>
                                            <th>试卷名</th>
                                            <th>出题人</th>
                                            <th>总分</th>
                                            <th>开始时间</th>
                                            <th>截止时间</th>
                                            <th>操作</th>
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
        <div class="layui-layer layui-layer-iframe" id="layui-layer1" type="iframe" times="1" showtime="0"
             contype="string"
             style="position:absolute;z-index: 19891015; width: 400px;padding: 20px 30px; height: 400px; top: 141px; left: 40%;background-color: white;">
            <form onsubmit="return false" class="center-block" id="exam-form">
                <div class="form-group">
                    <a class="cancel-btn" onclick="closeSubFrame()"><img src="/images/x.png"></a>
                </div>
                <input type="text" hidden name="id" id="tempid">
                <div class="form-group">
                    <label for="begin">起始时间：</label>
                    <div class="col-xs-12">
                        <input type="datetime-local" id="begin" name="begin" required="" autocomplete="off"
                               class="form-control col-xs-3">
                    </div>
                </div>
                <div class="form-group">
                    <label for="end">截止时间：</label>
                    <div class="col-xs-12">
                        <input type="datetime-local" id="end" name="end" required="" autocomplete="off"
                               class="form-control col-xs-3" placeholder="标题">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary center-block" onclick="saveTemplate()" style="position: relative; top: 80px;">保存
                    </button>
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
    $(function () {
        $('.search-bar .dropdown-menu a').click(function () {
            var field = $(this).data('field') || '';
            $('#search-field').val(field);
            $('#search-btn').html($(this).text() + ' <span class="caret"></span>');
        });
    });
    var tbody = document.getElementById('tbody');
    getTemplate();

    function getTemplate(page) {
        page = page || 1;
        tbody.innerHTML = "";
        $.get({
            url: '/api/admin/getTemplateList?page=' + page,
            success: function (data) {
                generatePage(data, "getTemplate");
                data = data.data;
                for (let i = 0; i < data.length; i++) {
                    var tr = document.createElement('tr');
                    tr.innerHTML = "\n" +
                        "                                        <tr>\n" +
                        "                                            <td>" + data[i].id + "</td>\n" +
                        "                                            <td>" + data[i].paper_id + "</td>\n" +
                        "                                            <td>" + data[i].title + "</td>\n" +
                        "                                            <td>" + data[i].name + "</td>\n" +
                        "                                            <td>" + data[i].score + "</td>\n" +
                        "                                            <td>" + formatDate(data[i].begin) + "</td>\n" +
                        "                                            <td>" + formatDate(data[i].end) + "</td>\n" +
                        "                                            <td>\n" +
                        "                                                <div class=\"btn-group\">\n" +
                        "                                                    <a class=\"btn btn-xs btn-default\" href=\"#!\" title=\"编辑\" data-toggle=\"tooltip\" onclick='updateTemplate(" + data[i].id + ")'><i class=\"mdi mdi-pencil\"></i></a>\n" +
                        "                                                </div>\n" +
                        "                                            </td>"
                    "                                        </tr>";
                    tbody.appendChild(tr);
                }
            }
        })
    }

    function closeSubFrame() {
        document.getElementById('layui-layer-shade1').style.display = "none";
    }

    function showSubFrame() {
        document.getElementById('layui-layer-shade1').style.display = "block";
    }

    function updateTemplate(id) {
        document.getElementById('tempid').value=id;
        showSubFrame();
    }
    function saveTemplate() {
        $.post({
            data:$("#exam-form").serialize(),
            url:'/api/admin/updateTemplate',
            success:function (data) {
                console.log(data)
            }
        })
    }
</script>
</body>
</html>
