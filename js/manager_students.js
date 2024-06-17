
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

document.getElementById("btn_new_user").onclick = function () {
    document.getElementById("main_students").style.opacity = 0.4;
    document.getElementById("main_students").style.filter = "blur(4px)";
    document.getElementById("signin").style.opacity = 1;
    document.getElementById("signin").style.visibility = "visible";
    document.getElementById("signin").style.zIndex = 100;
}

document.getElementById("exit_signin").onclick = function () {
    document.getElementById("main_students").style.opacity =1;
    document.getElementById("main_students").style.filter = "none";
    document.getElementById("signin").style.opacity = 0;
    document.getElementById("signin").style.visibility = "hidden";
    document.getElementById("signin").style.zIndex = 100;
}

window.setTimeout( function (){
    document.getElementById("massage").style.visibility = "hidden";
    document.getElementById("massage").style.opacity = 0;
},4500)