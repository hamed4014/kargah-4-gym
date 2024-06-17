
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

window.setTimeout( function (){
    document.getElementById("massage").style.visibility = "hidden";
    document.getElementById("massage").style.opacity = 0;
},4500)

document.getElementById("btn_change_user").onclick = function () {
    document.getElementById("main_student_info").style.opacity = 0.4;
    document.getElementById("main_student_info").style.filter = "blur(4px)";
    document.getElementById("signin").style.opacity = 1;
    document.getElementById("signin").style.visibility = "visible";
    document.getElementById("signin").style.zIndex = 200;
}

document.getElementById("exit_signin").onclick = function () {
    document.getElementById("main_student_info").style.opacity =1;
    document.getElementById("main_student_info").style.filter = "none";
    document.getElementById("signin").style.opacity = 0;
    document.getElementById("signin").style.visibility = "hidden";
    document.getElementById("signin").style.zIndex = 1;
}

document.getElementById("btn_new_food_plan").onclick = function () {
    document.getElementById("main_student_info").style.opacity = 0.4;
    document.getElementById("main_student_info").style.filter = "blur(4px)";
    document.getElementById("new_food_plan").style.opacity = 1;
    document.getElementById("new_food_plan").style.visibility = "visible";
    document.getElementById("new_food_plan").style.zIndex = 200;
}

document.getElementById("exit_new_food_plan").onclick = function () {
    document.getElementById("main_student_info").style.opacity =1;
    document.getElementById("main_student_info").style.filter = "none";
    document.getElementById("new_food_plan").style.opacity = 0;
    document.getElementById("new_food_plan").style.visibility = "hidden";
    document.getElementById("new_food_plan").style.zIndex = 1;
}

document.getElementById("btn_new_sport_plan").onclick = function () {
    document.getElementById("main_student_info").style.opacity = 0.4;
    document.getElementById("main_student_info").style.filter = "blur(4px)";
    document.getElementById("new_sport").style.opacity = 1;
    document.getElementById("new_sport").style.visibility = "visible";
    document.getElementById("new_sport").style.zIndex = 200;
}

document.getElementById("exit_new_sport").onclick = function () {
    document.getElementById("main_student_info").style.opacity =1;
    document.getElementById("main_student_info").style.filter = "none";
    document.getElementById("new_sport").style.opacity = 0;
    document.getElementById("new_sport").style.visibility = "hidden";
    document.getElementById("new_sport").style.zIndex = 1;
}



