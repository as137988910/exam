<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/paper.css">
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
                <div class="selected">试卷编辑</div>
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
</header>
<div class="container">
    <div class="main overflow-hidden">
        <div class="top-wrapper" id="wrapper-top">
            <button onclick="editPaper()" id="showEditBtn" class="top-wrapper-btn">︽︽︽</button>
            <div class="search-template-box">
                <input type="text" class="search-span" placeholder="搜索模板" id="template-key">
                <button onclick="searchTemplate()">搜索模板</button>
            </div>
            <div class="template-main">
                <div id="template-list">
                    {{--                    <a class="template-li">--}}
                    {{--                        <div class="flip">--}}
                    {{--                            <div class="flip-front flip-item">--}}
                    {{--                                <img src="/images/1.png" class="template-img">--}}
                    {{--                                <h3 class="title">"+data[i].title+"</h3>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="flip-back flip-item">--}}
                    {{--                                <div class="template-detail">--}}
                    {{--                                    <p class="description">fasfasgsadasaasda</p>--}}
                    {{--                                    <div class="date-box">--}}
                    {{--                                        <span class="date-span">发布日期：</span>--}}
                    {{--                                        <span class="date">2020-03-01 00:00:00</span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </a>--}}
                </div>
            </div>
            <div class="page" id="template-page-btn">
                <ul id="template-pageUl"></ul>
            </div>
        </div>
        <div class="add-box" id="addBox">
            <button class="add-btn-open" id="addBtn" onclick="addPaper()">+添加试卷</button>
            <button class="edit-btn-open" id="editBtn" onclick="editPaper()">✍查看模板</button>
        </div>
        <div class="wrapper">
            <div class="wrapper-open-left" id="left">
                <div class="search-box">
                    <input type="text" class="search-span" placeholder="请输入关键字" id="key">
                    <button onclick="showProblem()">搜索题库</button>
                    <button class="show-paper" onclick="showPaper();">查看试卷→</button>
                </div>
                <div class="problem-list" id="problem-list">
                    <table class="table" id="table" border="1">
                        <thead>
                        <tr>
                            <td>题目</td>
                            <td>题目类型</td>
                            <td>分值</td>
                            <td>修改日期</td>
                            <td>发布时间</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
                <div class="page" id="page-btn">
                    <ul id="pageUl"></ul>
                </div>
            </div>
            <div class="wrapper-close" id="right">
                <div class="paper-top">
                    <h1>试卷预览</h1>
                    <input type="text" placeholder="输入试卷名" id="paper-title">
                    <input type="text" placeholder="试卷说明" id="paper-instruction">
                    <select id="paper-public">
                        <option selected value=1>公开</option>
                        <option value=0>私有</option>
                    </select>
                </div>
                <div class="paper-example" id="paper-example"></div>
                <div class="sub-bar">
                    <button class="sub-btn" onclick="savePaper()">保存试卷</button>
                </div>
            </div>
        </div>
    </div>
    <div id="paper-pop">
        <div class="main padding-space">
            <div class="paper-box">
                <div class="headline"><h1 id="template-paper-title"></h1></div>
                <div id="paper-detail"></div>
                <div id="publish-time">
                    <div class="begin-time">开始时间：<input type="datetime-local" id="begin" name="begin"
                                                        placeholder="开始时间"></div>
                    <div class="end-time">截止时间：<input type="datetime-local" id="end" name="end" placeholder="截止时间">
                    </div>
                    <div class="save-time">
                        <button onclick="cancelFrame()">取消</button>
                        <button onclick="publish()" class="publish-btn">添加到我的试卷</button>
                    </div>
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
<script>
    var paperExample = $("#paper-example");
    var paperJson = [];
    var demoJson = [];
    var insideId = [];
    var score = 0;
    var templateList = document.getElementById('template-list');
    var controlId;
    var templateCurrentPage;
    var templateLastPage;

    function showTemplate(page) {
        page = page || 1;
        templateList.innerHTML = '';
        $.get({
            async: true,
            url: '/api/teacher/showTemplate?page=' + page,
            success: function (data) {
                data = JSON.parse(data)
                currentPage = data.current_page;
                lastPage = parseInt(data.last_page);
                var pageUl = document.getElementById('template-pageUl');
                pageUl.innerHTML = "";
                var preLi = document.createElement('li');
                preLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(1)\">&lt;&lt;</a>";
                var lastLi = document.createElement('li');
                lastLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(lastPage)\">&gt;&gt;</a>";
                pageUl.appendChild(preLi);
                for (let i = 1; i <= lastPage; i++) {
                    var newLi = document.createElement('li');
                    newLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(" + i + ")\">" + i + "</a>";
                    pageUl.appendChild(newLi);
                }
                pageUl.appendChild(lastLi);
                data = data.data;
                for (let i = 0; i < data.length; i++) {
                    var a = document.createElement('a');
                    a.className = 'template-li';
                    a.setAttribute('pid', data[i].id);
                    a.onclick = function () {
                        let pid = this.getAttribute('pid');
                        controlId = pid;
                        getPaper(pid, this);
                    }
                    a.innerHTML = "" +
                        "<div class=\"flip\">\n" +
                        "                            <div class=\"flip-front flip-item\">\n" +
                        "                                <img src=\"/images/1.png\" class=\"template-img\">\n" +
                        "                                <h3 class=\"title\">" + data[i].title + "</h3>\n" +
                        "                            </div>\n" +
                        "                            <div class=\"flip-back flip-item\">\n" +
                        "                                <div class=\"template-detail\">\n" +
                        "                                    <p class=\"description\">" + data[i].instruction + "</p>\n" +
                        "                                    <div class=\"date-box\">\n" +
                        "                                        <span class=\"date-span\">分数：</span>\n" +
                        "                                        <span class=\"score\">" + data[i].score + "</span>\n" +
                        "                                        <span class=\"date-span\">发布日期：</span>\n" +
                        "                                        <span class=\"date\">" + formatDate(data[i].updated_at) + "</span>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                            </div>\n" +
                        "                        </div>"
                    templateList.appendChild(a);
                }
                // console.log(data);
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    $(document).ready(function () {
        showTemplate();
    })

    function searchTemplate(page) {
        templateList.innerHTML = '';
        var key = document.getElementById('template-key').value;
        // console.log(key.length)
        // if (key.length==0){
        //     alert('请输入关键字!');
        //     return;
        // }
        page = page || 1;
        $.get({
            async: true,
            url: '/api/teacher/searchTemplate?key=' + key + '&page=' + page,
            success: function (data) {
                data = JSON.parse(data)
                currentPage = data.current_page;
                lastPage = parseInt(data.last_page);
                var pageUl = document.getElementById('template-pageUl');
                pageUl.innerHTML = "";
                var preLi = document.createElement('li');
                preLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(1)\">&lt;&lt;</a>";
                var lastLi = document.createElement('li');
                lastLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(lastPage)\">&gt;&gt;</a>";
                pageUl.appendChild(preLi);
                for (let i = 1; i <= lastPage; i++) {
                    var newLi = document.createElement('li');
                    newLi.innerHTML = "<a href=\"#\" onclick=\"showTemplate(" + i + ")\">" + i + "</a>";
                    pageUl.appendChild(newLi);
                }
                pageUl.appendChild(lastLi);
                data = data.data;
                for (let i = 0; i < data.length; i++) {
                    var a = document.createElement('a');
                    a.className = 'template-li';
                    a.innerHTML = "<div class=\"flip\">\n" +
                        "                            <div class=\"flip-front flip-item\">\n" +
                        "                                <img src=\"/images/1.png\" class=\"template-img\">\n" +
                        "                                <h3 class=\"title\">" + data[i].title + "</h3>\n" +
                        "                            </div>\n" +
                        "                            <div class=\"flip-back flip-item\">\n" +
                        "                                <div class=\"template-detail\">\n" +
                        "                                    <p class=\"description\">" + data[i].instruction + "</p>\n" +
                        "                                    <div class=\"date-box\">\n" +
                        "                                        <span class=\"date-span\">发布日期：</span>\n" +
                        "                                        <span class=\"date\">" + data[i].updated_at + "</span>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                            </div>\n" +
                        "                        </div>"
                    templateList.appendChild(a);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    function addProblem(th) {
        let questionType = '';
        let flag = 0;
        let juge = 0;
        let node;
        th.disabled = false;
        console.log(th);
        th.onclick = '#';
        th.className = 'btn-disabled';
        var questionId = th.parentNode.parentNode.getAttribute('qid');
        th = $(th).parent().parent().children();
        score += parseInt(th[2].innerText);
        switch (th[1].innerText) {
            case "单选题":
                questionType = 'radio';
                break;
            case "多选题":
                questionType = "checkbox";
                break;
            case "判断题":
                questionType = 'radio';
                juge = 1;
                break;
            case "简答题":
                flag = 1;
                break;
        }
        for (let index in paperJson) {
            if (paperJson[index].id == questionId) {
                let questionDetail = new Object();
                questionDetail = paperJson[index];
                demoJson.push(questionDetail);
                insideId.push(parseInt(questionId));
                if (flag == 0 && juge == 0) {
                    node = $("\n" +
                        "                        <fieldset pid=\"" + th.attr('pid') + "\">\n" +
                        "                            <p>" + th[0].innerText + "</p>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.a_selected + " name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>" + questionDetail.a + "</span>\n" +
                        "                            </div>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.b_selected + " name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>" + questionDetail.b + "</span>\n" +
                        "                            </div>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.c_selected + "  name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>" + questionDetail.c + "</span>\n" +
                        "                            </div>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.d_selected + "  name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>" + questionDetail.d + "</span>\n" +
                        "                            </div>\n" +
                        "                        </fieldset>");
                } else if (flag==1) {
                    node = $("\n" +
                        "                        <fieldset pid=\"" + th.attr('pid') + "\">\n" +
                        "                            <p>" + th[0].innerText + "</p>\n" +
                        "                            <div>\n" +
                        "                                <textarea disabled name=\"\" id=\"\" cols=\"30\" rows=\"10\"></textarea>\n" +
                        "                            </div>\n" +
                        "                        </fieldset>")
                }else if (juge = 1) {
                    node = $("\n" +
                        "                        <fieldset pid=\"" + th.attr('pid') + "\">\n" +
                        "                            <p>" + th[0].innerText + "</p>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.a_selected + " name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>对</span>\n" +
                        "                            </div>\n" +
                        "                            <div>\n" +
                        "                                <input disabled type=\"" + questionType + "\" " + questionDetail.b_selected + " name=\"" + questionDetail.id + "\">\n" +
                        "                                <span>错</span>\n" +
                        "                            </div>\n" +
                        "                        </fieldset>");
                }
            }
        }
        console.log(demoJson);
        paperExample.append(node);
    }

    var showFlag = 0;

    function showPaper() {
        if (showFlag == 0) {
            $(".wrapper-close").addClass('wrapper-open-right').removeClass('wrapper-close');
            showFlag = 1;
        } else {
            $(".wrapper-open-right").addClass('wrapper-close').removeClass('wrapper-open-right');
            showFlag = 0;
        }
    }

    var currentPage;
    var lastPage;

    function showProblem(page) {
        var key = document.getElementById('key').value;
        page = page || 1;
        // console.log(page)
        $.get({
            async: true,
            url: '/api/teacher/showProblem?page=' + page + '&key=' + key,
            success: function (data) {
                data = JSON.parse(data);
                console.log(data)
                currentPage = data.current_page;
                lastPage = parseInt(data.last_page);
                var pageUl = document.getElementById('pageUl');
                pageUl.innerHTML = "";
                var preLi = document.createElement('li');
                preLi.innerHTML = "<a href=\"#\" onclick=\"showProblem(1)\">&lt;&lt;</a>";
                var lastLi = document.createElement('li');
                lastLi.innerHTML = "<a href=\"#\" onclick=\"showProblem(lastPage)\">&gt;&gt;</a>";
                pageUl.appendChild(preLi);
                for (let i = 1; i <= lastPage; i++) {
                    var newLi = document.createElement('li');
                    newLi.innerHTML = "<a href=\"#\" onclick=\"showProblem(" + i + ")\">" + i + "</a>";
                    pageUl.appendChild(newLi);
                }
                pageUl.appendChild(lastLi);
                var msg = data.data;
                paperJson = msg;
                var tbody = document.getElementById('tbody');
                tbody.innerHTML = '';
                for (let i = 0; i < msg.length; i++) {
                    var tr = document.createElement('tr');
                    tr.setAttribute('qid', msg[i].id);
                    var specie = msg[i].species;
                    var specieStr;
                    switch (specie) {
                        case 1:
                            specieStr = '单选题';
                            break;
                        case 2:
                            specieStr = '多选题';
                            break;
                        case 3:
                            specieStr = '判断题';
                            break;
                        case 4:
                            specieStr = '简答题';
                            break;
                        default:
                            break;
                    }
                    var btn
                    if (insideId.includes(msg[i].id)) {
                        btn = "<button class='btn-disabled'>添加</button>"
                    } else {
                        btn = "<button onclick=\"addProblem(this);\">添加</button>"
                    }
                    tr.innerHTML = "<td class=\"problem-detail\">" + msg[i].description + "</td>\n" +
                        "                                    <td>" + specieStr + "</td>\n" +
                        "                                    <td>" + msg[i].score + "</td>\n" +
                        "                                    <td>" + msg[i].updated_at + "</td>\n" +
                        "                                    <td>" + msg[i].created_at + "</td>\n" +
                        "                                    <td>" + btn + "</td>";
                    tbody.appendChild(tr);
                }
                // console.log(msg);
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    addFlag = 0;

    function addPaper() {
        if (addFlag == 0) {
            document.getElementById('addBox').className = 'add-box-close';
            document.getElementById('addBtn').className = 'add-btn-close';
            document.getElementById('addBtn').innerText = '︾︾︾';
            console.log(document.getElementById('editBtn'));
            document.getElementById('editBtn').style.display = 'none';
            addFlag = 1;
        } else {
            document.getElementById('addBox').className = 'add-box-open';
            document.getElementById('addBtn').className = 'add-btn-open';
            document.getElementById('addBtn').innerText = '+添加问卷';
            document.getElementById('editBtn').style.display = 'block';
            addFlag = 0;
        }
    }

    editFlag = 0;

    function editPaper() {
        if (editFlag == 0) {
            document.getElementById('wrapper-top').className = 'top-wrapper-open'
            editFlag = 1;
        } else {
            document.getElementById('wrapper-top').className = 'top-wrapper-close'
            editFlag = 0;

        }
    }

    showProblem();

    function savePaper() {
        var paperTitle = document.getElementById('paper-title').value;
        var paperInstruction = document.getElementById('paper-instruction').value;
        var paperPublic = document.getElementById('paper-public').value;
        if (paperTitle == 0) {
            alert('你还未输入试卷名');
            return;
        }
        if (demoJson.length == 0) {
            alert('请至少添加一道题目');
            return;
        }
        var obj = {title: paperTitle, instruction: paperInstruction, score: score, public: paperPublic};
        demoJson.push(obj);
        console.log(demoJson);
        // return;
        $.post({
            async: false,
            url: '/api/teacher/savePaper',
            data: JSON.stringify(demoJson),
            success: function (data) {
                if (data) {
                    alert('已保存');
                } else {
                    alert('保存失败');
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status)
            }
        });
        demoJson.pop(obj);
        demoJson = [];
    }

    var templateObj = {}

    function getPaper(id, th) {
        document.getElementById('paper-pop').style.display = 'block';
        // var controlId=th.parentNode.parentNode.childNodes[1].innerText;
        var paperTitle = th.childNodes[0].childNodes[1].childNodes[3].innerText;
        var score = th.childNodes[0].childNodes[3].childNodes[1].childNodes[3].childNodes[3].innerText;
        var instruction = th.childNodes[0].childNodes[3].childNodes[1].childNodes[1].innerText;
        // var begin=formatDate(document.getElementById('begin').value);
        // var end=formatDate(document.getElementById('end').value);
        templateObj = {id: id, title: paperTitle, score: score, instruction: instruction}
        // console.log(instruction)
        // var begin=
        // console.log(begin=='')
        // document.getElementById('begin').value=begin==''?formatInputDate(new Date(th.parentNode.parentNode.childNodes[7].innerText)):begin;
        // document.getElementById('end').value=end==''?formatInputDate(new Date(th.parentNode.parentNode.childNodes[9].innerText)):end;
        // console.log(document.getElementById('end').value);
        document.getElementById('template-paper-title').innerText = paperTitle;
        // console.log(document.getElementById('template-paper-title'))
        $.get({
            async: false,
            url: '/api/teacher/getPaper?id=' + id,
            success: function (data) {
                data = JSON.parse(data);
                var questionType;
                var node;
                var paperDemo = document.getElementById('paper-detail');
                paperDemo.innerHTML = '';
                for (let i = 0; i < data.length; i++) {
                    switch (parseInt(data[i].species)) {
                        case 1:
                            questionType = 'radio';
                            node = $(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 2:
                            questionType = "checkbox";
                            node = $(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].a + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].b + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].c + "</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>" + data[i].d + "</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 3:
                            questionType = 'radio';
                            node = $(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>对</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>错</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 4:
                            node = $(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                // "                            <div>\n" +
                                // "                                <textarea name=\"\" id=\"\" cols=\"30\" rows=\"10\"></textarea>\n" +
                                // "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        default:
                            alert('出错');
                            break;
                    }
                    $(paperDemo).append(node);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    function cancelFrame() {
        document.getElementById('paper-pop').style.display = 'none';
    }

    function publish() {
        var begin = formatDate(document.getElementById('begin').value);
        var end = formatDate(document.getElementById('end').value);
        if (deadline(begin, end) || begin.indexOf('NaN') != -1 || end.indexOf('NaN') != -1) {
            alert('你还未设置时间');
            return;
        }
        templateObj.end = end;
        templateObj.begin = begin;
        // console.log(controlId);
        // console.log(templateObj);
        // console.log(new Date(document.getElementById('begin').value));
        // return;
        $.post({
            async: true,
            url: '/api/teacher/publishTemplate',
            data: templateObj,
            success: function (data) {
                // console.log(data)
                // if (data){
                alert('发布成功');
                cancelFrame();
                // } else {
                //     alert('出现问题啦');
                // }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    function saveTime() {
        var begin = formatDate(document.getElementById('begin').value);
        var end = formatDate(document.getElementById('end').value);
        if (deadline(begin, end) || begin.indexOf('NaN') != -1 || end.indexOf('NaN') != -1) {
            alert('请检查你输入的时间');
            return;
        }
        $.post({
            async: true,
            url: '/api/teacher/savePaperTime',
            data: {id: controlId, begin: begin, end: end},
            success: function (data) {
                if (data) {
                    alert('修改成功');
                    cancelFrame();
                    getPaperList();
                } else {
                    alert('修改失败');
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    function formatDate(date) {
        date = new Date(date);
        let year = date.getFullYear();
        let mongth = (date.getMonth() + 1) > 9 ? (date.getMonth() + 1) : parseInt('0' + (date.getMonth() + 1));
        let day = date.getDate();
        let hour = date.getHours();
        let minute = date.getMinutes();
        let second = date.getSeconds();
        mongth = mongth > 9 ? mongth : ('0' + mongth);
        day = day > 9 ? day : ('0' + day);
        hour = hour > 9 ? hour : ('0' + hour);
        minute = minute > 9 ? minute : ('0' + minute);
        second = second > 9 ? second : ('0' + second);
        return year + "-" + mongth + "-" + day + " " + hour + ":" + minute + ":" + second;
    }

    function deadline(time1, time2) {//判断已到期
        time1 = new Date(time1) || new Date();
        time2 = new Date(time2) || new Date();
        return time2.getTime() - time1.getTime() < 0 ? true : false;
    }
</script>

</html>
