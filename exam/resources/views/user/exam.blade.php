<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/user/exam.css">
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
        <div class="wait">
            <h1 class="headline">我的考试<span class="font-green">|</span></h1>
            <div class="exam-list">
                <table border="0">
                    <thead>
                    <tr>
                        <td>名称</td>
                        <td>准考证号</td>
                        <td>发布者</td>
                        <td>状态</td>
                        <td class="date">起始时间</td>
                        <td class="date">截止时间</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody id="paper-list"></tbody>
                </table>
            </div>
        </div>
        <div class="page" id="page-btn">
            <ul id="pageUl"></ul>
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
        <form action="#" method="post" class="sub-form">
            <h2 class="font-green">考生注册</h2>
            <label class="form-label" for="email">邮箱：</label>
            <input type="text" id="Remail" name="email" placeholder="请输入你的邮箱" autocomplete="off" required>
            <label class="form-label" for="password">密码：</label>
            <input type="text" id="Rpassword" name="password" placeholder="请输入你的密码" autocomplete="off" required>
            <input type="text" id="Repassword" name="Repassword" placeholder="请再次输入你的密码" autocomplete="off" required>
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
                <img src="/images/code/code.jpg" class="codeImg">
            </div>
            <button type="submit" class="sub-btn">注册</button>
        </form>
    </div>
</div>
<div id="login-bg">
    <div class="form-box">
        <img src="/images/x.png" class="op-form" onClick="closeLogin();">
        <form action="#" method="post" class="sub-form">
            <h2 class="font-green">考生登录</h2>
            <label class="form-label" for="email">邮箱：</label>
            <input type="text" id="Lemail" name="email" placeholder="请输入你的邮箱" autocomplete="off" required>
            <label class="form-label" for="password">密码：</label>
            <input class="form-label" type="password" id="Lpassword" name="password" placeholder="请输入你的密码" required>
            <div class="code-box">
                <label class="form-label" for="code">验证码：</label>
                <input type="text" id="Lcode" name="code" autocomplete="off" required>
                <img src="/images/code/code.jpg" class="codeImg">
            </div>
            <button type="submit" class="sub-btn">登录</button>
        </form>
    </div>
</div>
<div id="paper-detail-box">
    <div id="paper-detail-main">
        <a onclick="closeProblemView()"><img src="/images/x.png" class="op-form"></a>
        <div id="paper-detail-wrapper">
            <div class="paper-main">
                <h1 id="title"></h1>
                <p id="instruction"></p>
                <ul id="problem-list"></ul>
            </div>
        </div>
        <button onclick="postAnswer()">提交答案</button>
    </div>
</div>
<div id="paper-example-box">
    <div id="paper-example-main">
        <a onclick="closeExampleView()"><img src="/images/x.png" class="op-form"></a>
        <div id="paper-example-wrapper">
            <div class="paper-main">
                <h1 id="example-title"></h1>
                <p id="example-instruction"></p>
                <ul id="problem-example-list"></ul>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/js/app.js"></script>
<script src="/js/user/public.js"></script>
<script type="application/javascript">
    function closeRegister() {
        document.getElementById('register-bg').style.display = "none";
    }

    function closeLogin() {
        document.getElementById('login-bg').style.display = "none";
    }

    function closeProblemView() {
        document.getElementById('paper-detail-box').style.display = "none";
    }

    function closeExampleView() {
        document.getElementById('paper-example-box').style.display = "none";
    }

    function showRegister() {
        document.getElementById('register-bg').style.display = "block";
    }

    function showLogin() {
        document.getElementById('login-bg').style.display = "block";
    }

    var paperList = document.getElementById('paper-list');
    $(
        getApplyPaper(1)
    );

    function getApplyPaper(page) {
        page = page || 1;
        $.get({
            url: '/api/user/getApplyPaper?id=' + getCookie('id') + '&page=' + page,
            success: function (data) {
                console.log(data)
                paperList.innerHTML = '';
                generatePage(data);
                data = data.data;
                for (let i = 0; i < data.length; i++) {
                    let btn, status;
                    joinFlag = parseInt(data[i].joinflag);//joinFlag是否参与了考试
                    if (joinFlag == 0) {
                        switch (parseInt(data[i].status)) {
                            case 1:
                                btn = "<button class='correct-ing'>无法查看</button>";
                                status = '未开始';
                                break;
                            case 2:
                                btn = "<button class=\"ing\" onclick=\"joinExam(" + data[i].paper_id + ","+data[i].template_id+")\">参加</button>";
                                status = '进行中';
                                break;
                            case 3:
                                status = '已过期'
                                btn = "<button onclick=\"showPaperAnswer(" + data[i].paper_id + ")\">查看</button>";
                                break;
                        }
                    } else {
                        if (data[i].joinstatus == 1) {//joinstatus是否含有简答题项
                            btn = "<button class='correct-ing'>无法查看</button>";
                            status = '批改中';
                        } else if (parseInt(data[i].joinstatus) == 2&&parseInt(data[i].status)==2) {//status是否结束
                            btn = "<button class='correct-ing'>等待考试结束</button>";
                            status = '已完成';
                        } else if (parseInt(data[i].joinstatus) == 2&&parseInt(data[i].status)==3) {
                            btn = "<button class='ing' onclick=\"showAnswerDetail(" + data[i].paper_id + ","+data[i].template_id+")\">查看详情</button>";
                            status="已结束";
                        }
                    }
                    // let pivot = data[i].pivot;
                    let publisher = data[i].public == 1 ? '公共考试' : data[i].publisher_name;
                    let tr = document.createElement('tr');
                    tr.innerHTML = "<td>" + data[i].title + "</td>\n" +
                        "         <td>" + data[i].addmission_id + "</td>\n" +
                        "         <td>" + publisher + "</td>\n" +
                        "         <td>" + status + "</td>\n" +
                        "         <td class=\"date\">" + data[i].begin + "</td>\n" +
                        "         <td class=\"date\">" + data[i].end + "</td>\n" +
                        "         <td>" + btn + "</td>"
                    paperList.appendChild(tr);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    var problemList = document.getElementById('problem-list');
    var controlPaperId;
    var controlTemplateId;
    function joinExam(id,templateId) {
        controlPaperId = id;
        controlTemplateId=templateId;
        problemList.innerHTML = '';
        document.getElementById('paper-detail-box').style.display = "block";
        // setCookie('paperId', id, 1);
        // setCookie('testStatus', 0, 1);
        $.get({
            async: false,
            url: '/api/user/getProblem?id=' + id,
            success: function (data) {
                // console.log(data);
                data.sort(compare("species"));
                // console.log(data)
                for (let i = 0; i < data.length; i++) {
                    var li = document.createElement('li');
                    // var obj=new Object();
                    switch (parseInt(data[i].species)) {
                        case 1:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input type=radio name=" + data[i].id + " value=a>\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=radio name=" + data[i].id + " value=b>\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=radio name=" + data[i].id + " value=c>\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=radio name=" + data[i].id + " value=d>\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 2:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input type=checkbox name=" + data[i].id + " value=a>\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=checkbox name=" + data[i].id + " value=b>\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=checkbox name=" + data[i].id + " value=c>\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=checkbox name=" + data[i].id + " value=d>\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 3:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input type=\"radio\" name=" + data[i].id + " value=a>\n" +
                                "                                <span>" + "对" + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=\"radio\" name=" + data[i].id + " value=b>\n" +
                                "                                <span>" + "错" + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 4:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                        <textarea name=" + data[i].id + " class=\"answer-textarea\"></textarea>" +
                                "                        </div>";
                            break;
                    }
                    li.setAttribute('pid', data[i].id);
                    li.setAttribute('species', data[i].species);
                    problemList.appendChild(li);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status)
            }
        });
    }

    var problemExample = document.getElementById('problem-example-list');

    function showPaperAnswer(id) {
        problemExample.innerHTML = "";
        document.getElementById('paper-example-box').style.display = "block";
        $.get({
            async: false,
            url: '/api/user/getPaperAnswer?id=' + id,
            success: function (data) {
                console.log(data)
                for (let i = 0; i < data.length; i++) {
                    let li = document.createElement('li');
                    switch (parseInt(data[i].species)) {
                        case 1:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=radio name=" + data[i].id + " " + data[i].a_selected + ">\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=radio name=" + data[i].id + " " + data[i].b_selected + ">\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=radio name=" + data[i].id + " " + data[i].c_selected + ">\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=radio name=" + data[i].id + " " + data[i].d_selected + ">\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 2:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=checkbox name=" + data[i].id + " " + data[i].a_selected + ">\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=checkbox name=" + data[i].id + " " + data[i].b_selected + ">\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=checkbox name=" + data[i].id + " " + data[i].c_selected + ">\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=checkbox name=" + data[i].id + " " + data[i].d_selected + ">\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 3:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"selection-list\">\n" +
                                "                            <div>\n" +
                                "                                <input type=\"radio\" name=" + data[i].id + " " + data[i].a_selected + ">\n" +
                                "                                <span>" + "对" + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input type=\"radio\" name=" + data[i].id + " " + data[i].b_selected + ">\n" +
                                "                                <span>" + "错" + "</span>\n" +
                                "                            </div>\n" +
                                "                        </div>";
                            break;
                        case 4:
                            li.innerHTML = "<div class=\"paper-detail\">\n" +
                                "                            <span class=\"numberProblem\">（" + (i + 1) + "）</span>\n" +
                                "                            <p class=\"description\">" + data[i].description + "</p>\n" +
                                "                        </div>\n" +
                                "                        <hr>" +
                                // "                        <div class=\"selection-list\">\n" +
                                // "                        <textarea name="+data[i].id+" class=\"answer-textarea\"></textarea>"+
                                "                        </div>";
                            break;
                    }
                    problemExample.appendChild(li);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status)
            }
        })
    }

    var answerJson = [];

    function postAnswer() {
        var x = 0, y = 0, z = 0;
        answerJson = [];
        stuId = getCookie('id');
        $("#problem-list").children().children("div.selection-list").each(function (i, node) {
            species = node.parentNode.getAttribute('species');
            // return
            x++;
            var obj = new Object();
            obj = {
                a: 0,
                b: 0,
                c: 0,
                d: 0,
                content: null,
                paper_id: parseInt(controlPaperId),
                template_id:parseInt(controlTemplateId),
                stu_id: parseInt(stuId),
                species: parseInt(species)
            };
            // console.log($(node).children(":checked"));
            $(node).children().children("input:checked").each(function (j, child) {
                obj[child.value] = 1;
                obj.problem_id = parseInt(child.name);
                if (z == 0) {
                    y++;
                    z++;
                } else {

                }
            });
            $(node).children("textarea").each(function (i, child) {
                // console.log(child.value);
                obj.problem_id = parseInt(child.name);
                obj.content = child.value;
                y++;
            });
            // console.log(node);
            answerJson.push(obj);
            z = 0;
        });
        console.log(x + ":" + y);
        if (x != y) {
            alert('你的问题还没填写完成！');
            return;
        }
        $.post({
            url: '/api/user/saveAnswer',
            data: JSON.stringify(answerJson),
            success: function (data) {
                if (data == 1) {
                    alert('提交成功');
                    location.reload();
                }
                console.log(data)
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        console.log(answerJson);
    }

    function generatePage(info) {
        currentPage = info.current_page;
        lastPage = info.last_page;
        var pageUl = document.getElementById('pageUl');
        pageUl.innerHTML = "";
        var preLi = document.createElement('li');
        preLi.innerHTML = "<a href=\"#\" onclick=\"getApplyPaper(1)\">&lt;&lt;</a>";
        var lastLi = document.createElement('li');
        lastLi.innerHTML = "<a href=\"#\" onclick=\"getApplyPaper(lastPage)\">&gt;&gt;</a>";
        pageUl.appendChild(preLi);
        for (let i = 1; i <= lastPage; i++) {
            var newLi = document.createElement('li');
            newLi.innerHTML = "<a href=\"#\" onclick=\"getApplyPaper(" + i + ")\">" + i + "</a>";
            pageUl.appendChild(newLi);
        }
        pageUl.appendChild(lastLi);
    }

    function compare(property) {
        return function (a, b) {
            var val1 = a[property];
            var val2 = b[property];
            return val1 - val2;
        }
    }
</script>

</html>
