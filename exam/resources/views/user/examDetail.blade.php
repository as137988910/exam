<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试系统</title>
    <link rel="stylesheet" href="/css/user/public.css">
    <link rel="stylesheet" href="/css/user/examDetail.css">
</head>

<body>
    <header>
        <div class="header-top">
            <div class="header-span">
                <a href="/user/exam"id="logout-btn">返回</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="main">
            <div class="paper-main">
                <h1 id="title"></h1>
                <p id="instruction"></p>
                <ul id="paper-list">
                    <li>
                        <div class="paper-detail">
                            <span class="numberProblem"></span>
                            <p class="description"></p>
                            <span>（1）</span>
                        </div>
                        <div class="selection-list">
                            <div>
                                <input type="radio">
                                <span>12311</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>123</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="paper-detail">
                            <span class="numberProblem"></span>
                            <p class="description"></p>
                            <span>（2）</span>
                        </div>
                        <div class="selection-list">
                            <div>
                                <input type="radio">
                                <span>12311</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>123</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="paper-detail">
                            <span class="numberProblem"></span>
                            <p class="description"></p>
                            <span>（3）</span>
                        </div>
                        <div class="selection-list">
                            <div>
                                <input type="radio">
                                <span>12311</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>123</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                            <div>
                                <input type="radio">
                                <span>1231</span>
                            </div>
                        </div>
                    </li>
                </ul>
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
</body>
<script src="/js/app.js"></script>
<script src="/js/user/public.js"></script>
<script>
    var id=window.parent.getCookie('paperId');
    var status=window.parent.getCookie('testStatus');
    $(document).ready(function () {
        switch (parseInt(status)) {
            case 0:
                var url='/api/user/getAnswer?id='+id;
                break;
            case 1:
                var url='api/user/getProblem?id='+id;
                break;
        }
        alert(id)
        // console.log(1233)
        if (id==''){
            alert('出现错误：not find paperId');
            return;
        }
        $.get({
            async:true,
            url:url,
            success:function (data) {
                for (let i=0;i<data.length;i++){
                    var li=document.createElement('li');
                    li.innerHTML=""
                }
                console.log(data)
            },
            error:function (jqXHR) {
                console.log(jqXHR.status);
            }
        });
    })
</script>
</html>
