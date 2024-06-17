
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

document.getElementById("btn_call").onclick = function () {
    scroll(0,3000); return false;
}

document.getElementById("btn_signin").onclick = function () {
    document.getElementById("main").style.opacity = 0.4;
    document.getElementById("main").style.filter = "blur(4px)";
    document.getElementById("main_footer").style.opacity = 0.8;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "blur(4px)";
    document.getElementById("signin").style.opacity = 1;
    document.getElementById("signin").style.visibility = "visible";
    document.getElementById("signin").style.zIndex = 2;
    document.getElementById("login").style.opacity = 0;
    document.getElementById("login").style.visibility = "hidden";
    document.getElementById("login").style.zIndex = 2;
}

document.getElementById("btn_signin2").onclick = function () {
    document.getElementById("main").style.opacity = 0.4;
    document.getElementById("main").style.filter = "blur(4px)";
    document.getElementById("main_footer").style.opacity = 0.8;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "blur(4px)";
    document.getElementById("signin").style.opacity = 1;
    document.getElementById("signin").style.visibility = "visible";
    document.getElementById("signin").style.zIndex = 2;
    document.getElementById("login").style.opacity = 0;
    document.getElementById("login").style.visibility = "hidden";
    document.getElementById("login").style.zIndex = 2;
}

document.getElementById("exit_signin").onclick = function () {
    document.getElementById("main").style.opacity =1;
    document.getElementById("main").style.filter = "none";
    document.getElementById("main_footer").style.opacity = 1;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "none";
    document.getElementById("signin").style.opacity = 0;
    document.getElementById("signin").style.visibility = "hidden";
    document.getElementById("signin").style.zIndex = 2;
}

document.getElementById("btn_login").onclick = function () {
    document.getElementById("main").style.opacity = 0.4;
    document.getElementById("main").style.filter = "blur(4px)";
    document.getElementById("login").style.zIndex = 1;
    document.getElementById("main_footer").style.opacity = 0.8;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "blur(4px)";
    document.getElementById("login").style.opacity = 1;
    document.getElementById("login").style.visibility = "visible";
    document.getElementById("login").style.zIndex = 2;
    document.getElementById("signin").style.opacity = 0;
    document.getElementById("signin").style.visibility = "hidden";
    document.getElementById("signin").style.zIndex = 2;
}

document.getElementById("exit_login").onclick = function () {
    document.getElementById("main").style.opacity =1;
    document.getElementById("main").style.filter = "none";
    document.getElementById("login").style.zIndex = 1;
    document.getElementById("main_footer").style.opacity = 1;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "none";
    document.getElementById("login").style.opacity = 0;
    document.getElementById("login").style.visibility = "hidden";
    document.getElementById("login").style.zIndex = 2;
}

document.getElementById("btn_login2").onclick = function () {
    document.getElementById("main").style.opacity = 0.4;
    document.getElementById("main").style.filter = "blur(4px)";
    document.getElementById("login").style.zIndex = 1;
    document.getElementById("main_footer").style.opacity = 0.8;
    document.getElementById("main_footer").style.zIndex = 1;
    document.getElementById("main_footer").style.filter = "blur(4px)";
    document.getElementById("login").style.opacity = 1;
    document.getElementById("login").style.visibility = "visible";
    document.getElementById("login").style.zIndex = 2;
    document.getElementById("signin").style.opacity = 0;
    document.getElementById("signin").style.visibility = "hidden";
    document.getElementById("signin").style.zIndex = 2;
}

window.setTimeout( function (){
    document.getElementById("massage").style.visibility = "hidden";
    document.getElementById("massage").style.opacity = 0;
},4500)


