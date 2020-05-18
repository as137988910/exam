<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/publish.css">
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
                    <div class="selected">我的试卷</div>
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
        <div class="main">
            <div class="paper-list">
                <table border="0" class="table">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>名称</td>
                            <td>状态</td>
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
        <div id="paper-pop">
            <div class="main">
                <div class="paper-box">
                    <div class="headline"><h1 id="paper-title"></h1></div>
                    <div class="list-box">
                        <div id="paper-detail"></div>
                        <div class="student-list-box">
                            <h4 class="select-student-title">选择考生</h4>
                            <div class="search-box">
                                <input id="searchKey" placeholder="输入关键字">
                                <button class="search-btn" onclick="searchStudent()">搜索</button>
                            </div>
                            <div class="student-li">
                                <div class="td bold">考生ID</div>
                                <div class="td bold">姓名</div>
                                <div class="td bold">操作</div>
                            </div>
                            <div id="student-list"></div>
                            <div class="student-page" id="student-page-btn">
                                <ul id="student-pageUl"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-box">
                    <div id="publish-time">
                        <div class="begin-time">开始时间：<input type="datetime-local" id="begin" name="begin" placeholder="开始时间"></div>
                        <div class="end-time">截止时间：<input type="datetime-local" id="end" name="end" placeholder="截止时间"></div>
                    </div>
                    <div class="save-time">
                        <button onclick="cancelFrame()">取消</button>
                        <button onclick="saveTime()">确定</button>
                        <div class="publish-btn">
                            <select id="public">
                                <option value=1 selected>公开发布</option>
                                <option value=0>仅选择特定考生</option>
                            </select>
                        </div>
                        <button onclick="publish()" class="publish-btn">发布考试</button>
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
<script type="text/javascript">

    var currentPage;
    var lastPage;
    var currentStuPage;
    var lastStuPage;
    getPaperList();
    searchStudent('');
    function searchStudent(page,key) {
        page=page||1;
        key=document.getElementById('searchKey').value;
        var studentList=document.getElementById('student-list');
        studentList.innerHTML="";
        $.get({
            url:'/api/teacher/searchStudent?page='+page+'&key='+key,
            success:function (data) {
                generateStuPage(data)
                data=data.data;
                for (let i=0;i<data.length;i++){
                    var li=document.createElement('div');
                    li.className="student-li";
                    li.innerHTML="<div class=\"td\">"+data[i].id+"</div>\n" +
                        "         <div class=\"td\">"+data[i].name+"</div>\n" +
                        "         <div class=\"td\"><button onclick=\"addStuToPaper(this)\">添加</button></div>"
                    studentList.appendChild(li);
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
    function getPaperList(page) {
        page=page||1;
        var statusArr=[];
        var paperList=document.getElementById('paper-list');
        paperList.innerHTML='';
        $.get({
            async:false,
            url:'/api/teacher/showPublishPaper?page='+page,
            success:function (data) {
                generatePage(data);
                data=data.data.sort(compare('id'));
                console.log(data)
                for (let i=0;i<data.length;i++){
                    let begin=data[i].pivot.begin==null?'':formatDate(data[i].pivot.begin);
                    let end=data[i].pivot.end==null?'':formatDate(data[i].pivot.end);
                    let createTime=formatDate(data[i].created_at);
                    let updateTime=formatDate(data[i].updated_at);
                    let statusMsg;
                    let status=getStatus(begin,end);
                    if (data[i].pivot.publish==0){
                        statusMsg='已保存';
                    } else {
                        let obj={id:data[i].pivot.id,status:status};
                        statusArr.push(obj);
                        switch (status) {
                            case 1:
                                statusMsg='已发布';
                                break;
                            case 2:
                                statusMsg='进行中';
                                break;
                            case 3:
                                statusMsg='已结束';
                                break;
                            default:
                                statusMsg='未知';
                                break;
                        }
                    }
                    let tr=document.createElement('tr');
                    tr.innerHTML="\n" +
                        "                            <td>"+data[i].pivot.id+"</td>\n" +
                        "                            <td>"+data[i].title+"</td>\n" +
                        "                            <td>"+statusMsg+"</td>\n" +
                        "                            <td class=\"date\">"+begin+"</td>\n" +
                        "                            <td class=\"date\">"+end+"</td>\n" +
                        "                            <td class=\"date\">"+createTime+"</td>\n" +
                        "                            <td class=\"date\">"+updateTime+"</td>\n" +
                        "                            <td>\n" +
                        "                                <button onclick=\"getPaper("+data[i].id+",this)\"'>查看试卷</button>\n" +
                        "                            </td>\n"+
                        "                            <td hidden class=\"date\">"+data[i].pivot.id+"</td>\n";
                    paperList.appendChild(tr);
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
        for (let i=0;i<statusArr.length;i++){
            templateId=statusArr[i].id;
            changeStatus(statusArr[i].status);
        }
        templateId=0;
    };
    var stuArr=[];
    function addStuToPaper(th) {
        stuArr.push(parseInt(th.parentNode.parentNode.childNodes[0].innerText));
        th.parentNode.innerHTML="<button class=\"remove-btn\" onclick=\"removeStu(this)\">移除</button>";
        // console.log(stuArr)
    }
    function removeStu(th) {
        stuArr.splice(stuArr.indexOf(th.parentNode.parentNode.childNodes[1].innerText),1)
        th.parentNode.innerHTML="<button onclick=\"addStuToPaper(this)\">添加</button>";
        // console.log(stuArr)
    }
    var controlId;
    var paperTitle;
    function saveTime() {
        var begin=formatDate(document.getElementById('begin').value);
        var end=formatDate(document.getElementById('end').value);
        if (deadline(begin,end)||begin.indexOf('NaN')!=-1||end.indexOf('NaN')!=-1){
            alert('请检查你输入的时间');
            return;
        }
        $.post({
            async:true,
            url:'/api/teacher/savePaperTime',
            data:{id:templateId,begin:begin,end:end},
            success:function (data) {
                if (data){
                    alert('修改成功');
                    cancelFrame();
                    getPaperList();
                } else {
                    alert('修改失败');
                }
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
    function publish() {
        saveTime();
        var begin=formatDate(document.getElementById('begin').value);
        var end=formatDate(document.getElementById('end').value);
        var publicFlag=document.getElementById('public').value;
        var paperInfoObj={pid:controlId,tempid:templateId};
        if (deadline(begin,end)||begin.indexOf('NaN')!=-1||end.indexOf('NaN')!=-1){
            alert('你还未设置时间');
            return;
        }
        if (publicFlag==0){
            stuArr.push(paperInfoObj);
            console.log(stuArr)
            $.post({
                async:false,
                url:'/api/teacher/addPaperForStu',
                data:JSON.stringify(stuArr),
                success:function (data) {
                    console.log(data)
                    stuArr.pop(paperInfoObj);
                    if (data==1){
                        alert("操作成功")
                    } else {
                        alert(data);
                    }
                },
                error:function (jqXHR) {
                    stuArr.pop(paperInfoObj);
                    console.log(jqXHR.status);
                }
            })
        }
            $.post({
                async:false,
                url:'/api/teacher/publishPaper',
                data:{id:templateId,public:publicFlag},
                success:function (data) {
                    if (data){
                        alert('发布成功');
                        cancelFrame();
                        getPaperList();
                    } else {
                        alert('出现问题啦');
                    }
                },
                error:function (jqXHR) {
                    console.log(jqXHR.status);
                }
            })
    }
    var templateId;
    function changeStatus(status) {
        $.post({
            async:true,
            url:'/api/teacher/changeStatus',
            data:{id:templateId,status:status},
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }
    function cancelFrame() {
        document.getElementById('paper-pop').style.display='none';
    }
    function getPaper(id,th) {
        // stuArr=[];
        document.getElementById('paper-pop').style.display='block';
        controlId=th.parentNode.parentNode.childNodes[1].innerText;
        paperTitle=th.parentNode.parentNode.childNodes[3].innerText;
        templateId=th.parentNode.parentNode.childNodes[17].innerText;
        // console.log(templateId);
        // return;
        // var begin=
        let begin=document.getElementById('begin').value;
        let end=document.getElementById('end').value;
        // console.log(begin=='')
        document.getElementById('begin').value=begin==''?formatInputDate(new Date(th.parentNode.parentNode.childNodes[7].innerText)):begin;
        document.getElementById('end').value=end==''?formatInputDate(new Date(th.parentNode.parentNode.childNodes[9].innerText)):end;
        // console.log(document.getElementById('end').value);
        document.getElementById('paper-title').innerText=paperTitle;
        $.get({
            async:false,
            url:'/api/teacher/getPaper?id='+id,
            success:function (data) {
                data=JSON.parse(data).sort(compare('species'));
                var questionType;
                var node;
                var paperDemo=document.getElementById('paper-detail');
                paperDemo.innerHTML='';
                for (let i=0;i<data.length;i++){
                    switch (parseInt(data[i].species)) {
                        case 1:
                            questionType = 'radio';
                            node =$(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].a+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].b+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].c+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].d+"</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 2:
                            questionType = "checkbox";
                            node =$(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].a+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].b+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].c+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].d+"</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 3:
                            questionType='radio';
                            node =$(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].a+"</span>\n" +
                                "                            </div>\n" +
                                "                            <div>\n" +
                                "                                <input disabled type=\"" + questionType + "\">\n" +
                                "                                <span>"+data[i].b+"</span>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        case 4:
                            node =$(
                                "                        <fieldset qid=\"" + data[i].id + "\">\n" +
                                "                            <p>" + data[i].description + "</p>\n" +
                                "                            <div>\n" +
                                "                                <textarea name=\"\" id=\"\" cols=\"30\" rows=\"10\"></textarea>\n" +
                                "                            </div>\n" +
                                "                        </fieldset>");
                            break;
                        default:
                            alert('出错');
                            break;
                    }
                    $(paperDemo).append(node);
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

    function generateStuPage(info) {
        currentPage=info.current_page;
        lastPage=info.last_page;
        var pageUl=document.getElementById('student-pageUl');
        pageUl.innerHTML="";
        var preLi=document.createElement('li');
        preLi.innerHTML="<a href=\"#\" onclick=\"searchStudent(1)\">&lt;&lt;</a>";
        var lastLi=document.createElement('li');
        lastLi.innerHTML="<a href=\"#\" onclick=\"searchStudent(lastPage)\">&gt;&gt;</a>";
        pageUl.appendChild(preLi);
        for (let i=1;i<=lastPage;i++){
            var newLi=document.createElement('li');
            newLi.innerHTML="<a href=\"#\" onclick=\"searchStudent("+i+")\">"+i+"</a>";
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
</script>
</html>
