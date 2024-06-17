
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

document.getElementById("btn_new_day").onclick = function () {
    document.getElementById("main_student_info").style.opacity = 0.4;
    document.getElementById("main_student_info").style.filter = "blur(4px)";
    document.getElementById("new_day").style.zIndex = 2;
    document.getElementById("new_day").style.opacity = 1;
    document.getElementById("new_day").style.visibility = "visible";
    document.getElementById("new_day").style.zIndex = 2;
}

document.getElementById("exit_new_day").onclick = function () {
    document.getElementById("main_student_info").style.opacity =1;
    document.getElementById("main_student_info").style.filter = "none";
    document.getElementById("new_day").style.opacity = 0;
    document.getElementById("new_day").style.visibility = "hidden";
    document.getElementById("new_day").style.zIndex = 2;
}

document.getElementById("btn_users_list_show").onclick = function () {
    document.getElementById("main_student_info").style.opacity = 0.4;
    document.getElementById("main_student_info").style.filter = "blur(4px)";
    document.getElementById("users_list_show").style.zIndex = 2;
    document.getElementById("users_list_show").style.opacity = 1;
    document.getElementById("users_list_show").style.visibility = "visible";
    document.getElementById("users_list_show").style.zIndex = 2;
}

document.getElementById("exit_users_list").onclick = function () {
    document.getElementById("main_student_info").style.opacity =1;
    document.getElementById("main_student_info").style.filter = "none";
    document.getElementById("users_list_show").style.opacity = 0;
    document.getElementById("users_list_show").style.visibility = "hidden";
    document.getElementById("users_list_show").style.zIndex = 2;
}