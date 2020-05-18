
function logout(){
    $("#logout-btn").css('display','none');
    $(".dropdown").css('display','inline-block');
    $(".header-button").css('display','none');
    setCookie('role','student',-1);
    setCookie('headImg',0,-1);
    setCookie('signature',0,-1);
    setCookie('id',0,-1);
    $.get({
        asyne:true,
        url:'http://localhost/api/logout'
    })
    location.href='/user';
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/user";
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
$(function() {
    if (getCookie('role')=='student'){
        $("#logout-btn").css('display','inline-block');
        $(".dropdown").css('display','inline-block');
        $(".header-button").css('display','none');
    }else {
        $("#logout-btn").css('display','none');
        $(".dropdown").css('display','none');
        $(".header-button").css('display','inline-block');
    }
});
