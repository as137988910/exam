<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线考试教师管理系统</title>
    <link rel="stylesheet" href="/css/teacher/public.css">
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
                <a href="/teacher/person" class="nav-btn">
                    <div class="selected">个人信息</div>
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
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="main">
            <div class="problem-list">
                <fieldset pid='1'>
                    <p>dasdasdsadasdasdqwdqawdasdasd</p>
                    <div>
                        <input type="radio" name="q1">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="radio" name="q1">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="radio" name="q1">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="radio" name="q1">
                        <span>sadasdasdasdasdas</span>
                    </div>
                </fieldset>
                <fieldset>
                    <p>dasdasdsadasdasdqwdqawdasdasd</p>
                    <div>
                        <input type="checkbox" name="q2">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="checkbox" name="q2">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="checkbox" name="q2">
                        <span>sadasdasdasdasdas</span>
                    </div>
                    <div>
                        <input type="checkbox" name="q2">
                        <span>sadasdasdasdasdas</span>
                    </div>
                </fieldset>
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
</script>

</html>
