<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .dropbtn{
            padding: 13px;
        }
        .container{
            background-color: white;
        }


        .page{
            width: 100%;
        }
        .page>ul{
            width: fit-content;
            margin: 0 auto;
            padding: 0;
        }
        .page>ul>li{
            display: inline-block;
            width: 50px;
            height: 50px;
            list-style: none;
        }
        .page>ul>li>a{
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            float: left;
            text-decoration: none;
            color: #202225;
        }
        .exam-list{
            width: 85%;
        }
        button{
            color: white;
            background-color: rgb(13, 184, 150);
            padding: 0 5px;
            border-radius: 5px;
            border: white 1px solid;
            cursor: pointer;
        }
        #pop-box{
            display: none;
            background-color: rgba(5,5,5,0.4);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        td{
            background-color: white;
            width: auto!important;
        }
        .add-table{
            padding: 20px 30px;
            position: relative;
            top: 40%;
            height: auto;
        }
    </style>
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
            <div class="wait">
                <h1 class="headline">已报名的考试<span class="font-green">|</span></h1>
                <div class="exam-list">
                    <table border="0" class="table">
                        <thead>
                        <tr>
                            <td>名称</td>
                            <td>准考证号</td>
                            <td>发布者</td>
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
    </div>
    <footer>
        <div class="copyright">
            <p>Copyright 2020, HW</p>
        </div>
        <div class="footer-link">
            <ul class="link">
                <li><a href="/admin/login">管理员管理系统</a></li>
                <li><a href="/teacher">教师管理系统</a></li>
                <li><a href="" onclick="test()">联系我</a></li>
                <li><a href="https://github.com/as137988910/exam">github源码</a></li>
            </ul>
        </div>
    </footer>
</body>
<div id="pop-box" onclick='this.style.display="none"'>
</div>
<script src="/js/app.js"></script>
<script src="/js/user/public.js"></script>
<script src="/js/user/jspdf/examples/libs/jspdf.debug.js"></script>
<script src="/js/user/jspdf/dist/jspdf.plugin.autotable.min.js"></script>
<script src="/js/public/jspdf-normal.js"></script>
<script type="application/javascript">
    var currentPage;
    var lastPage;
    var paperList=document.getElementById('paper-list');
    getApplyPaper();
    function getApplyPaper(page) {
        paperList.innerHTML=""
        page=page||1;
        $.get({
            url:'/api/user/getJoinPaper?page='+page+'&id='+getCookie('id'),
            success:function (data) {
                console.log(data)
                generatePage(data,"getApplyPaper")
                data=data.data;
                for (let i=0;i<data.length;i++){
                    var tr=document.createElement('tr');
                    tr.innerHTML="<td>"+data[i].title+"</td>\n" +
                        "                            <td>"+data[i].addmission_id+"</td>\n" +
                        "                            <td>"+data[i].publisher_name+"</td>\n" +
                        "                            <td class=\"date\">"+formatDate(data[i].begin)+"</td>\n" +
                        "                            <td class=\"date\">"+formatDate(data[i].end)+"</td>\n" +
                        "                            <td><button onclick=\"getTable("+data[i].addmission_id+")\">打印</button></td>"
                    paperList.appendChild(tr);
                }
            }
        })
    }

    function getTable(addmissionid) {
        var tableSpace=document.getElementById('pop-box');
        $.get({
            async:true,
            url:'/api/user/getGradeReport?addmissionId='+addmissionid,
            success:function (data) {
                console.log(data)
                if (data.status!=2){
                    alert(data.data);
                } else {
                    data=data.data[0];
                    tableSpace.innerHTML="\n" +
                        "            <table border=\"1\" id='add-table' class='add-table' cellspacing=\"0\">\n" +
                        "                <thead>\n" +
                        "                    <tr>\n" +
                        "                        <td class=\"grade-title\" colspan=\"8\">准考证</td>\n" +
                        "                    </tr>\n" +
                        "                    <tr>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">姓名</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">年龄</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">性别</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">准考证号</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">试卷名</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">发布时间</td>\n" +
                        "                        <td colspan=\"1\" class=\"top-title\">截止时间</td>\n" +
                        "                    </tr>\n" +
                        "                </thead>\n" +
                        "                <tbody>\n" +
                        "                    <tr>\n" +
                        "                        <td colspan=\"1\" id=\"name\">"+data.name+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"age\">"+data.age+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"sex\">"+data.sex+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"admission\">"+data.addmission_id+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"\">"+data.title+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"\">"+data.begin+"</td>\n" +
                        "                        <td colspan=\"1\" id=\"\">"+data.end+"</td>\n" +
                        "                    </tr>\n" +
                        "                </tbody>\n" +
                        "            </table>"
                }
            }
        });
        tableSpace.style.display="block";
        setTimeout(function () {
            var doc=new jsPDF('p', 'pt');
            doc.setFont('jspdf');
            doc.autoTable({ html: '#add-table' });
            doc.save(addmissionid+'.pdf');
        },500)
    }
    function generatePage(info,funName) {
        currentPage = info.current_page;
        lastPage = info.last_page;
        var pageUl = document.getElementById('pageUl');
        pageUl.innerHTML = "";
        pageUl.className="pagination";
        var preLi = document.createElement('li');
        preLi.innerHTML = "<a href=\"#\" onclick=\""+funName+"(1)\">&lt;&lt;</a>";
        var lastLi = document.createElement('li');
        lastLi.innerHTML = "<a href=\"#\" onclick=\""+funName+"(lastPage)\">&gt;&gt;</a>";
        pageUl.appendChild(preLi);
        console.log(info)
        for (var i = 1; i <= lastPage; i++) {
            var newLi = document.createElement('li');
            newLi.innerHTML = "<a href=\"#\" onclick=\""+funName+"(" + i + ")\">" + i + "</a>";
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
    function formatDate(date) {
        date=new Date(date);
        var year=date.getFullYear();
        var mongth=(date.getMonth()+1)>9?(date.getMonth()+1):parseInt('0'+(date.getMonth()+1));
        var day=date.getDate();
        var hour=date.getHours();
        var minute=date.getMinutes();
        var second=date.getSeconds();
        mongth=mongth>9?mongth:('0'+mongth);
        day=day>9?day:('0'+day);
        hour=hour>9?hour:('0'+hour);
        minute=minute>9?minute:('0'+minute);
        second=second>9?second:('0'+second);
        return year+"-"+mongth+"-"+day+" "+hour+":"+minute+":"+second;
    }
    function formatInputDate(date) {
        date=new Date(date);
        var year=date.getFullYear();
        var mongth=(date.getMonth()+1)>9?(date.getMonth()+1):parseInt('0'+(date.getMonth()+1));
        var day=date.getDate();
        var hour=date.getHours();
        var minute=date.getMinutes();
        var second=date.getSeconds();
        mongth=mongth>9?mongth:('0'+mongth);
        day=day>9?day:('0'+day);
        hour=hour>9?hour:('0'+hour);
        minute=minute>9?minute:('0'+minute);
        second=second>9?second:('0'+second);
        return year+"-"+mongth+"-"+day+"T"+hour+":"+minute+":"+second+'.000';
    }
</script>
</html>
