
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/admin";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
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
$(document).ready(function () {
        document.getElementById('name').innerText=getCookie('aname')+"▼";
});
