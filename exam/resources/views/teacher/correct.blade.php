<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/correct.css">
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
                    <div class="selected">批改试卷</div>
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
        <div class="main">
            <div class="paper-list">
                <table border="0" class="table">
                    <thead>
                    <tr>
                        <td>id</td>
                        <td>名称</td>
                        <td class="date">开始时间</td>
                        <td class="date">截止时间</td>
                        <td class="date">创建时间</td>
                        <td class="date">修改时间</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody id="paper-list">
                    </tbody>
                </table>
            </div>
            <div class="page" id="page-btn">
                <ul id="pageUl"></ul>
            </div>
        </div>
    </div>
    <div id="paper-pop">
        <div class="correct-paper-main">
            <div class="flex">
                <div class="left-btn" onclick="f(1)">
                    <<
                </div>
                <div class="paper-box">
                    <div class="paper-box-main">
                        <div class="headline"><h1 id="paper-title"></h1></div>
                        <div class="list-box">
                            <div id="paper-detail"></div>
                        </div>
                    </div>
                </div>
                <div class="right-btn" onclick="f(-1)">
                    >>
                </div>
            </div>
            <div class="control-box">
                <div class="save-time">
                    <button onclick="cancelFrame()" class="cancel-btn">取消</button>
                    <button onclick="subScore()" class="save-btn">保存</button>
{{--                    <button onclick="saveTime()" class="save-btn">保存</button>--}}
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
<script type="text/javascript">
    function subScore() {
        var scoreJson=[];
        var tempStuId=0;
        var o;
        $("input[type=number]").each(function (i,node) {
            var stuId=parseInt(node.getAttribute('stuId'));
            var stuSCore=parseInt(node.value);
            if (node.value==''){
                alert(node.getAttribute('stuName')+"的分数有遗漏");
                return false;
            }
            if (stuId!=tempStuId){
                tempStuId=stuId;
                o=new Object();
                o.stu_id=stuId;
                o.score=stuSCore;
                o.template_id=currentTempId;
                scoreJson.push(o);
            }else {
                o.score+=stuSCore;
            }
        })
        console.log(scoreJson);
        $.post({
            url:'/api/teacher/updateScore',
            data:JSON.stringify(scoreJson),
            success:function (data) {
                console.log(data)
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
    getPaperList();
    function getPaperList(page) {
        page=page||1;
        var statusArr=[];
        var paperList=document.getElementById('paper-list');
        paperList.innerHTML='';
        $.get({
            async:false,
            url:'/api/teacher/showCorrectPaper?page='+page,
            success:function (data) {
                generatePage(data);
                data=data.data.sort(compare('id'));
                console.log(data);
                for (let i=0;i<data.length;i++){
                    let begin=data[i].pivot.begin==null?'':formatDate(data[i].pivot.begin);
                    let end=data[i].pivot.end==null?'':formatDate(data[i].pivot.end);
                    let createTime=formatDate(data[i].created_at);
                    let updateTime=formatDate(data[i].updated_at);
                    let statusMsg;
                    let tr=document.createElement('tr');
                    tr.innerHTML="\n" +
                        "                            <td>"+data[i].id+"</td>\n" +
                        "                            <td>"+data[i].title+"</td>\n" +
                        "                            <td class=\"date\">"+begin+"</td>\n" +
                        "                            <td class=\"date\">"+end+"</td>\n" +
                        "                            <td class=\"date\">"+createTime+"</td>\n" +
                        "                            <td class=\"date\">"+updateTime+"</td>\n" +
                        "                            <td>\n" +
                        "                                <button onclick=\"correctPaper("+data[i].pivot.id+",this)\"'>批改试卷</button>\n" +
                        "                            </td>\n"+
                        "                            <td hidden class=\"date\">"+data[i].pivot.id+"</td>\n";
                    paperList.appendChild(tr);
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    };
    var correctedStu=[];
    var stuNum;
    var currentStuPage=0;
    var total=0;
    // var paperData=[];
    var currentTempId;
    var paperDemo=document.getElementById('paper-detail');
    function correctPaper(id) {
        document.getElementById('paper-pop').style.display='block';
        // console.log(id+":"+th);
        currentTempId=id;
        $.get({
            async: false,
            url: '/api/teacher/getAnswerProNum?templateId=' + id,
            success: function (data) {
                stuNum=parseInt(data);
            }
        });

        $.get({
            async:false,
            url:'/api/teacher/getAnswer?templateId='+id,
            success:function (data) {
                console.log(data);
                // paperData=[]
                total=data.length;
                data.sort(compare('stu_id'));
                var questionType;
                var node;
                paperDemo.innerHTML='';
                // var n=total/stuNum;
                // var keyFlag=data[0].stu_id;
                // for (let i=stuNum*currentStuPage;i<stuNum*(currentStuPage+1);i++){
                for (let i=0;i<total;i++){
                    // if (data[i].stu_id!=keyFlag){
                    //
                    // }
                    if (i==0||i%stuNum==0){
                        var page=$("<div class=\"stu-answer-box\"></div>");
                        page.append($("<h3>"+data[i].name+"</h3>"))
                        // console.log(i)
                    }
                    // stuName.innerText=data[i].name;
                    node =$(
                            "<fieldset>\n" +
                            "<p>" + data[i].description +"(分值："+data[i].score+")"+ "</p>\n" +
                            "<div>\n" +
                            "<textarea name=\"\" disabled id=\"\" cols=\"30\" rows=\"10\">"+data[i].answer+"</textarea>\n" +
                            "</div>\n" +
                            "<input type=\"number\" placeholder=\"分数\" max="+data[i].score+" oninput=\"if (this.value<0) this.value=0; else this.value=this.value>"+data[i].score+"?"+data[i].score+":this.value\" stuId="+data[i].stu_id+" stuName="+data[i].name+">" +
                            "</fieldset>\n"
                            );
                    $(page).append(node);
                    $(paperDemo).append(page);

                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
    function generatePage(info) {
        currentPage=info.current_page;
        lastPage=info.last_page;
        var pageUl=document.getElementById('pageUl');
        pageUl.innerHTML="";
        var preLi=document.createElement('li');
        preLi.innerHTML="<a href=\"#\" onclick=\"getPaperList(1)\">&lt;&lt;</a>";
        var lastLi=document.createElement('li');
        lastLi.innerHTML="<a href=\"#\" onclick=\"getPaperList(lastPage)\">&gt;&gt;</a>";
        pageUl.appendChild(preLi);
        for (let i=1;i<=lastPage;i++){
            var newLi=document.createElement('li');
            newLi.innerHTML="<a href=\"#\" onclick=\"getPaperList("+i+")\">"+i+"</a>";
            pageUl.appendChild(newLi);
        }
        pageUl.appendChild(lastLi);
    }
    function deadline(time1,time2) {//判断已到期
        time1=new Date(time1)||new Date();
        time2=new Date(time2)||new Date();
        return time2.getTime()-time1.getTime()<0?true:false;
    }
    function compare(property) {
        return function (a, b) {
            var val1 = a[property];
            var val2 = b[property];
            return val1 - val2;
        }
    }
    function f(f) {
        if (f>0){
            prePage();
        } else {
            nextPage();
        }
        refreshTime();
    }
    function prePage() {
        if (clickFlag) {
            clickFlag=false;
            if (currentStuPage==0){
                console.log(currentStuPage)
                return;
            } else {
                currentStuPage-=1;
                moveFun=setInterval("move(1)",1);
            }
            refreshTime();
        }
    }
    function nextPage() {
        if (clickFlag) {
            clickFlag = false;
            if ((currentStuPage+1)*stuNum==total) {
                console.log(currentStuPage+":"+stuNum+":"+total)
                return;
            }else {
                currentStuPage+=1;
                moveFun=setInterval("move(-1)",1);
            }
            refreshTime();
        }
    }
    function refreshTime() {
        setTimeout(function () {
            clickFlag=true;
        },600);
    }
    var x=0;
    var moveFun;
    var clickFlag=true;
    // var y=0;
    function move(direction) {
        // console.log(x);
        if (direction>0){
            x+=5;
        } else {
            x-=5
            // paperDemo
        }
        paperDemo.style.left=x+'px';
        if (x%530==0){
            clearInterval(moveFun)
        }
        return false;
    }
    function formatInputDate(date) {
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
        return year+"-"+mongth+"-"+day+"T"+hour+":"+minute+":"+second+'.000';
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
    function getStatus(begin,end) {
        var status;
        let passFlag=deadline(begin,new Date());
        let overFlag=deadline(new Date(),end);
        // console.log(overFlag);
        if (overFlag){
            status=3;
        } else if (passFlag){
            status=1;
        }else {
            status=2;
        }
        // changeStatus(status);
        return status;
    }

    function cancelFrame() {
        document.getElementById('paper-pop').style.display='none';
    }
</script>

</html>
