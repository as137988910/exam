<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/grade.css">
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
                    <div class="selected">成绩总览</div>
                </a>
                <a href="/teacher/person" class="nav-btn">
                    <div class="menu-btn">个人信息</div>
                </a>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="main">
            <div class="wait">
                <h1 class="headline">我的考试<span class="font-green">|</span></h1>
                <div class="exam-list">
                    <table border="0" class="no-scroll">
                        <thead>
                        <tr>
                            <td>试卷名</td>
                            <td>介绍</td>
                            <td>总分</td>
                            <td class="date">起始时间</td>
                            <td class="date">截止时间</td>
                            <td class="date">截止时间</td>
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
    <div id="paper-pop" onclick="closeFrame(this)">
        <table border="1" cellspacing="0" class="table">
            <thead>
            <tr>
                <td class="grade-title" colspan="6" class="gray-bg">成绩报告</td>
            </tr>
            <tr>
                <td colspan="1" class="gray-bg">试卷名称</td>
                <td colspan="2" id="paper-title">231</td>
                <td colspan="1" class="gray-bg">总分值</td>
                <td colspan="2" id="paper-total">113</td>
            </tr>
            <tr>
                <td colspan="1" class="gray-bg">简介</td>
                <td colspan="5" id="paper-instruction">hgbnkvujcgcgfujbh</td>
            </tr>
            <tr>
                <td colspan="2" class="gray-bg">准考证号</td>
                <td colspan="1" class="gray-bg">姓名</td>
                <td colspan="2" class="gray-bg">邮箱</td>
                <td colspan="1" class="gray-bg">得分</td>
            </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
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
    $(document).ready(function () {
        showGradePaper();
    })
    function closeFrame(th) {
        // var n=document.getElementById('paper-pop')
        th.style.display="none";
    }
    function showGradePaper(page) {
        page=page||1;
        var paperList = document.getElementById('paper-list');
        paperList.innerHTML = '';
        $.get({
            url:'/api/teacher/showGradePaper?page='+page,
            success:function (data) {
                generatePage(data);
                data = data.data;
                console.log(data)
                for (let i = 0; i < data.length; i++) {
                    // let pivot = data[i].pivot;
                    let publisher = data[i].public == 1 ? '公共考试' : data[i].publisher_name;
                    let tr = document.createElement('tr');
                    tr.innerHTML = "<td>" + data[i].title + "</td>\n" +
                        "         <td>" + data[i].instruction + "</td>\n" +
                        "         <td>" + data[i].total + "</td>\n" +
                        "         <td class=\"date\">" + data[i].begin + "</td>\n" +
                        "         <td class=\"date\">" + data[i].end + "</td>\n" +
                        "         <td class=\"date\">" + formatDate(data[i].created_at) + "</td>\n" +
                        "         <td class=\"date\">" + formatDate(data[i].updated_at) + "</td>\n" +
                        "         <td><button onclick=\"showGradeTable(" + data[i].id + ")\">查看成绩</button></td>"
                    paperList.appendChild(tr);
                }
            }
        })
    }
    function showGradeTable(id) {
        var paperBox=document.getElementById('paper-pop');
        var tbody=document.getElementById('tbody');
        tbody.innerHTML="";
        paperBox.style.display="block";
        $.get({
            url:'/api/teacher/getGradeTable?id='+id,
            success:function (data) {
                for (let i=0;i<data.length;i++){
                    var tr=document.createElement('tr');
                    tr.innerHTML="<td colspan=\"2\">"+data[i].addmission_id+"</td>\n" +
                        "                <td colspan=\"1\">"+data[i].name+"</td>\n" +
                        "                <td colspan=\"2\">"+data[i].email+"</td>\n" +
                        "                <td colspan=\"1\">"+data[i].score+"</td>";
                    tbody.appendChild(tr);
                }
            }
        })
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
