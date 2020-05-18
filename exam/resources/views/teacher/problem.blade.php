<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
    <link rel="stylesheet" href="/css/teacher/problem.css">
</head>

<body>
<header>
    <div class="logout">
        <a href="#" onclick="logout();" id="logout-btn">退出登录</a>
    </div>
    <div>
        <nav class="nav">
            <a href="/teacher/problem" class="nav-btn">
                <div class="selected">试题编辑</div>
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
        <div class="drop-btn-box"><span><img src="/images/change.png" class="drop-btn" onclick="changeFloor()"></span>
        </div>
        <div class="content-box">
            <div id="list">
                <div class="search-box">
                    <input type="text" name="key" id="key" placeholder="输入关键字">
                    <button onclick="searchKey()">查找试题</button>
                </div>
                <div class="page" id="page-btn">
                    <ul id="pageUl">
                    </ul>
                </div>
                <div id="show-list">

                </div>
            </div>
            <div id="add">
                <div class="add-box">
                    <select name="type" id="type" onchange="flashType();" class="select-btn">
                        <option selected style="display: none;">请选择要添加的题目类型</option>
                        <option value=1>单选题</option>
                        <option value=2>多选题</option>
                        <option value=3>判断题</option>
                        <option value=4>解答题</option>
                    </select>
                    <button onclick="addQuestion();" class="add-btn">+添加</button>
                </div>
                <div class="workspace" id="workspace">

                </div>
                <div class="sub-bar">
                    <button onclick="saveProblem()">加入题库</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modify">
        <form id="modify-form">
{{--            题目：<input type="text"><br>--}}
            <div id="selection">

            </div>
        </form>
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
    var selectNum = 4; //选项个数  最多为4
    var paperJson = [];
    var questionType;
    var qid = 0;
    var questionNum=0;
    var property = {
        a: 'a',
        b: 'b',
        c: 'c',
        d: 'd'
        // ay:0,
        // by:0,
        // cy:0,
        // dy:0
    };
    var answerClassName = {
        nodeClass: 'node',
        titleClass: 'title',
        radioClass: 'radio',
        checkboxClass: 'checkbox',
        judgeClass: 'judge',
        textareaClass: 'text',
        hiddenBtnClass: 'delete-btn'
    };
    var workspace = document.getElementById('workspace');

    function flashType() {
        questionType = document.getElementById('type').value;
        num = 1;
        fillFlag = true;
        fillNum = 0;
    }
    $(document).ready(function () {
        workspace.innerHTML='';
    })
    //题目类型工厂
    function answerFactory(questionType) {
        let node = document.createElement('fieldset');
        node.className = answerClassName.nodeClass;
        let deleteBtn = document.createElement('a');
        deleteBtn.className = answerClassName.hiddenBtnClass;
        deleteBtn.innerText = "X";
        deleteBtn.setAttribute('qid',qid);
        deleteBtn.onclick=function () {
            let deletdId=this.getAttribute('qid');
            // console.log(this.parentNode)
            for (let key in paperJson){
                if (paperJson[key].qid==deletdId);
                paperJson.splice(key,1);
            }
            $(this.parentNode).remove();
        }
        node.appendChild(deleteBtn);
        let questionScript = document.createElement('textarea');
        questionScript.className = answerClassName.titleClass;
        questionScript.type='text';
        let questionDetail = new Object();
        // questionDetail={qid:0,type:'',a:'a',b:'b',c:'c',d:'d',selected:'',ay:0,by:0,cy:0,dy:0,score:0}
        questionDetail['qid'] = qid;
        questionScript.onchange = function () {
            questionDetail['title'] = questionScript.value;
            // console.log(questionScript.value);
        }
        // console.log(questionDetail);
        node.appendChild(questionScript);
        switch (questionType) {
            case '1': //单选题
                questionDetail['type'] = '1';
                for (let index in property) {
                    let answerBox = document.createElement('div');
                    answerBox.className = answerClassName.radioClass;
                    let answer = document.createElement('input');
                    answer.type = 'radio';
                    answer.name =  num;
                    num++;
                    answer.onclick=function () {
                        questionDetail.selected=this.value;
                    };
                    answer.value=property[index];
                    // questionDetail[answer.value]=0;
                    let answerSpan = document.createElement('input'); //填写答案的内容
                    answerSpan.className = answerClassName.radioClass;
                    answerSpan.type='text';
                    answerSpan.onchange = function () { //为每个选项的内容绑定事件判断内容是否填写
                        questionDetail[index] = answerSpan.value;
                    };
                    answerBox.appendChild(answer);
                    answerBox.appendChild(answerSpan);
                    node.appendChild(answerBox);
                }
                var scoreBox = document.createElement('div');
                var scoreSpan = document.createElement('span');
                var score = document.createElement('input');
                scoreBox.className = '';
                scoreSpan.className = '';
                scoreSpan.innerText = '分值';
                score.className = '';
                score.type = 'text';
                score.name = 'score';
                score.maxLength = 2;
                score.onchange = function () {
                    questionDetail['score'] = score.value;
                };
                score.oninput = function () {
                    score.value = score.value.replace(/[^\d]/g, '');
                };
                scoreBox.appendChild(scoreSpan);
                scoreBox.appendChild(score);
                node.appendChild(scoreBox);
                paperJson.push(questionDetail);
                break;
            case '2': //多选题
                questionDetail['type'] = '2';
                for (let index in property) {
                    let answerBox = document.createElement('div');
                    answerBox.className = answerClassName.checkboxClass;
                    let answer = document.createElement('input');
                    answer.type = 'checkbox';
                    answer.name = num++;
                    answer.onclick=function () {
                        // console.log(this.checked);
                        // console.
                        if (this.checked){
                            // console.log(this.value);
                            questionDetail[this.value]='checked';
                        }else {
                            questionDetail[this.value]='';
                        }
                    }
                    answer.value=property[index]+'y';
                    questionDetail[answer.value]=0;
                    let answerSpan = document.createElement('input');
                    answerSpan.className = answerClassName.checkboxClass;
                    answerSpan.type='text';
                    answerSpan.onchange = function () { //为每个选项的内容绑定事件判断内容是否填写
                        questionDetail[index] = answerSpan.value;
                        // console.log(answerSpan.value + ":" + questionDetail[index]);
                    };
                    answerBox.appendChild(answer);
                    answerBox.appendChild(answerSpan);
                    node.appendChild(answerBox);
                }
                var scoreBox = document.createElement('div');
                var scoreSpan = document.createElement('span');
                var score = document.createElement('input');
                scoreBox.className = '';
                scoreSpan.className = '';
                scoreSpan.innerText = '分值';
                score.className = '';
                score.type = 'text';
                score.name = 'score';
                score.maxLength = 2;
                score.onchange = function () {
                    questionDetail['score'] = score.value;
                };
                score.oninput = function () {
                    score.value = score.value.replace(/[^\d]/g, '');
                };
                scoreBox.appendChild(scoreSpan);
                scoreBox.appendChild(score);
                node.appendChild(scoreBox);
                paperJson.push(questionDetail);
                break;
            case '3': //判断题
                questionDetail['type'] = '3';
                for (let index = 0; index < 2; index++) {
                    let answerBox = document.createElement('div');
                    let answer = document.createElement('input');
                    answer.type = 'radio';
                    answer.name = num++;
                    answer.onclick=function () {
                        questionDetail.selected=this.value;
                    };
                    if (index==0){
                        answer.value='a';
                    } else {
                        answer.value='b';
                    }
                    let answerSpan = document.createElement('span');
                    answerSpan.className = answerClassName.judgeClass;
                    if (index == 0)
                        answerSpan.innerText = '对';
                    else
                        answerSpan.innerText = '错';
                    answerBox.appendChild(answer);
                    answerBox.appendChild(answerSpan);
                    node.appendChild(answerBox);
                }
                var scoreBox = document.createElement('div');
                var scoreSpan = document.createElement('span');
                var score = document.createElement('input');
                scoreBox.className = '';
                scoreSpan.className = '';
                scoreSpan.innerText = '分值';
                score.className = '';
                score.type = 'text';
                score.name = 'score';
                score.maxLength = 2;
                score.onchange = function () {
                    questionDetail['score'] = score.value;
                };
                score.oninput = function () {
                    score.value = score.value.replace(/[^\d]/g, '');
                };
                scoreBox.appendChild(scoreSpan);
                scoreBox.appendChild(score);
                node.appendChild(scoreBox);
                questionDetail['a'] = 'a';
                questionDetail['b'] = 'b';
                questionDetail['c'] = 'c';
                questionDetail['d'] = 'd';
                paperJson.push(questionDetail);
                break;
            case '4': //解答题
                questionDetail['type'] = '4';
                let textareaBox = document.createElement('div');
                let textarea = document.createElement('textarea');
                textarea.onchange = function () {
                    questionDetail['text']
                }
                textarea.className = answerClassName.textareaClass;
                textareaBox.appendChild(textarea);
                node.appendChild(textareaBox);
                var scoreBox = document.createElement('div');
                var scoreSpan = document.createElement('span');
                var score = document.createElement('input');
                scoreBox.className = '';
                scoreSpan.className = '';
                scoreSpan.innerText = '分值';
                score.className = '';
                score.type = 'text';
                score.name = 'score';
                score.maxLength = 2;
                score.onchange = function () {
                    questionDetail['score'] = score.value;
                };
                score.oninput = function () {
                    score.value = score.value.replace(/[^\d]/g, '');
                };
                scoreBox.appendChild(scoreSpan);
                scoreBox.appendChild(score);
                node.appendChild(scoreBox);
                questionDetail['a'] = 'a';
                questionDetail['b'] = 'b';
                questionDetail['c'] = 'c';
                questionDetail['d'] = 'd';
                paperJson.push(questionDetail);
                break;
            default:
                break;
        }
        workspace.appendChild(node);
        qid++;
    }

    //题目类型工厂   end!
    function addQuestion() {
        // paperJson=[];
        console.log(paperJson);
        if (textareaTextIsNull() && answerTextIsNull()) {
            answerFactory(questionType);
            // beEmpty();
        } else {
            return;
        }
    }

    function textareaTextIsNull() {
        let flag = 0;
        let textareaTag = document.getElementsByTagName('textarea');
        let textareaTagLength = textareaTag.length;
        if (textareaTagLength == 0) {
            flag = -1;
        }
        for (let key in textareaTag) {
            if (textareaTag[key].value != '' && textareaTag[key].value != undefined) {
                flag++;
            }
        }
        // console.log(flag);
        if (flag != textareaTagLength && flag >= 0) {
            alert('你的问题没填写完整');
            return false;
        }
        return true;
    }

    function answerTextIsNull() {
        let flag = 0;
        let flagNum = 0;
        let inputTag = document.getElementsByTagName('input');
        // inputTag.
        console.log(inputTag);
        let textareaTagLength = document.getElementsByTagName('textarea').length;
        let inputTagLength = inputTag.length;
        if (questionType == undefined) {
            alert('请选择你想添加的题目类型');
            return;
        }
        if (textareaTagLength == 0) {
            flag = -1;
        }
        for (let key in inputTag) {
            if (inputTag[key].type == 'text' && inputTag[key].id != 'key') {
                flagNum++;
                console.log(inputTag[key].value);
                if (inputTag[key].value != '') {
                    flag++;
                }
            }
        }
        console.log(flagNum+":"+flag);
        if (flag != flagNum && flag >= 0) {
            alert('你的问题还没填写完整');
            return false;
        }
        return true;
    }

    var changeFlag = 0;

    function changeFloor() {
        if (changeFlag == 0) {
            $("#list").removeClass().addClass('lower');
            $("#add").removeClass().addClass('upper');
            changeFlag = 1;
        } else {
            $("#list").removeClass().addClass('upper');
            $("#add").removeClass().addClass('lower');
            changeFlag = 0;
        }
        }

        var currentPage;
        var lastPage;
    function searchKey(page) {
        page=page||1;
        var key = $("#key").val()
        var list = document.getElementById('show-list');
        list.innerHTML='';
        $.get({
            async: true,
            url: '/api/teacher/searchProblem?page='+page,
            // url:pageUrl,
            data: {'key': key},
            success: function (data) {
                var info=JSON.parse(data);
                console.log(info);
                currentPage=info.current_page;
                lastPage=info.last_page;
                var pageUl=document.getElementById('pageUl');
                pageUl.innerHTML="";
                var preLi=document.createElement('li');
                preLi.innerHTML="<a href=\"#\" onclick=\"searchKey(1)\">&lt;&lt;</a>";
                var lastLi=document.createElement('li');
                lastLi.innerHTML="<a href=\"#\" onclick=\"searchKey(lastPage)\">&gt;&gt;</a>";
                pageUl.appendChild(preLi);
                for (let i=1;i<=lastPage;i++){
                    var newLi=document.createElement('li');
                    newLi.innerHTML="<a href=\"#\" onclick=\"searchKey("+i+")\">"+i+"</a>";
                    pageUl.appendChild(newLi);
                }
                pageUl.appendChild(lastLi);
                data = JSON.parse(data).data;
                // return;
                for (let index = 0; index < data.length; index++) {
                    var field = document.createElement('fieldset');
                    field.setAttribute('qid',data[index].id);
                    // console.log(data[index]);
                    // if (data[index].species==1||data[index].species==2){
                    //
                    // }
                    switch (data[index].species) {
                        case 1:
                            field.innerHTML =
                                "<p class=\"show-title\">" + data[index].description + "</p>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].a_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].a+"</span>" +
                                "</div>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].b_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].b+"</span>" +
                                "</div>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].c_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].c+"</span>" +
                                "</div>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].d_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].d+"</span>" +
                                "</div>" +
                                "<div class=\"modify\">" +
                                "<button onclick='modify(this)'>修改</button>"+
                                "</div>"
                            break;
                        case 2:
                            field.innerHTML =
                                "<p class=\"show-title\">" + data[index].description + "</p>" +
                                "<div class=\"checkbox\"><input type=\"checkbox\" disabled=\"disabled\""+data[index].a_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].a+"</span>" +
                                "</div>" +
                                "<div class=\"checkbox\"><input type=\"checkbox\" disabled=\"disabled\""+data[index].b_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].b+"</span>" +
                                "</div>" +
                                "<div class=\"checkbox\"><input type=\"checkbox\" disabled=\"disabled\""+data[index].c_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].c+"</span>" +
                                "</div>" +
                                "<div class=\"checkbox\"><input type=\"checkbox\" disabled=\"disabled\""+data[index].d_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].d+"</span>" +
                                "</div>" +
                                "<div class=\"modify\">" +
                                "<button onclick='modify(this)'>修改</button>"+
                                "</div>"
                            break;
                        case 3:
                            field.innerHTML =
                                "<p class=\"show-title\">" + data[index].description + "</p>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].a_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].a+"</span>" +
                                "</div>" +
                                "<div class=\"radio\"><input type=\"radio\" disabled=\"disabled\""+data[index].b_selected+" name=\""+data[index].id+"\">" +
                                "<span>"+data[index].b+"</span>" +
                                "</div>" +
                                "<div class=\"modify\">" +
                                "<button onclick='modify(this)'>修改</button>"+
                                "</div>"
                            break;
                        case 4:
                            field.innerHTML =
                                "<p class=\"show-title\">" + data[index].description + "</p>" +
                                "<hr>"+
                                "<div class=\"modify\">" +
                                "<button onclick='modify(this)'>修改</button>"+
                                "</div>"
                            break;
                        default:
                            break;
                    }
                    list.appendChild(field);
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
    }

    function saveProblem() {
        console.log(paperJson);
        if(workspace.childNodes.length==0){
            alert('请至少添加一道题');
            return;
        }
        $.post({
            async: false,
            url: '/api/teacher/createProblem',
            data: JSON.stringify(paperJson),
            success: function (data) {
                alert(data);
                workspace.innerHTML='';
            },
            error: function (jqXHR) {
                console.log(jqXHR.status);
            }
        })
    }

    var modifyFlag=0;
    function modify(th) {
        if (modifyFlag!=0){
            alert('你还有题目未保存');
            return;
        }
        var arr=[0,'a','b','c','d'];
        // var obj={};
        var childNode=th.parentNode.parentNode.childNodes;
        $(childNode[0]).replaceWith('<textarea value='+childNode[0].innerText+'>'+childNode[0].innerText+'</textarea>');
        for(let i=1;i<childNode.length-1;i++){
            if (childNode[i].childNodes[0]==undefined){
                break;
            }
            childNode[i].childNodes[0].disabled=false;
            $(childNode[i].childNodes[1]).replaceWith("<input type='text' value="+childNode[i].innerText+" name="+arr[i]+">");
        }
        console.log(childNode)
        $(childNode[childNode.length-1].childNodes[0]).replaceWith("<button onclick='changeProblem(this)'>保存</button>")
        modifyFlag=1;
        // console.log(modifyId);
        // $("#modify-form").
        // console.log(th.parentNode.parentNode.childNodes);
    }
    function changeProblem(th) {
        var arr=[0,'a','b','c','d'];
        var obj={}
        var str,strSel
        var modifyId=th.parentNode.parentNode.getAttribute('qid');
        obj.qid=modifyId;
        var childNode=th.parentNode.parentNode.childNodes;
        obj.title=childNode[0].value;
        $(childNode[0]).replaceWith('<p class="show-title">'+childNode[0].value+'</p>');
        console.log(childNode[1].childNodes);
        for(let i=1;i<childNode.length-1;i++){
            // console.log();
            if (childNode[i].childNodes.length==0){
                break;
            }
            str=arr[i];
            strSel=arr[i]+"_selected";
            obj[str]=childNode[i].childNodes[1].value;
            obj[strSel]=childNode[i].childNodes[0].checked?'checked':'';
            $(childNode[i].childNodes[1]).replaceWith("<span>"+childNode[i].childNodes[1].value+"</span>");
        }
        console.log(obj);
        // console.log(childNode)
        $(childNode[childNode.length-1].childNodes[0]).replaceWith("<button onclick='modify(this)'>修改</button>")
        $.post({
            async:true,
            url:'/api/teacher/updateProblem',
            data:obj,
            success:function (data) {
                console.log(data)
            },
            error:function (jqXHR) {
                alert(jqXHR.status);
            }
        })
        // console.log(th)
        modifyFlag=0;
    }
    function cancelProblem(th) {
        console.log(th);
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
    // function beEmpty() {
    //     for (let key in questionDetail) {
    //         questionDetail[key] = '';
    //     }
    //     fillFlag = false;
    //     fillNum = 0;
    // }
</script>

</html>
