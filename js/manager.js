
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

document.getElementById("btn_person").onmouseenter = function () {
    document.getElementById("menu_person").style.opacity = 1;
    document.getElementById("menu_person").style.visibility = "visible";
}

document.getElementById("btn_person").onmouseleave = function () {
    document.getElementById("menu_person").style.opacity = 0;
    document.getElementById("menu_person").style.visibility = "hidden";
}

document.getElementById("menu_person").onmouseenter = function () {
    document.getElementById("menu_person").style.opacity = 1;
    document.getElementById("menu_person").style.visibility = "visible";
}

document.getElementById("menu_person").onmouseleave = function () {
    document.getElementById("menu_person").style.opacity = 0;
    document.getElementById("menu_person").style.visibility = "hidden";
}

setInterval( function () {
    var MyDate = new Date().toLocaleDateString('fa-IR');
    document.getElementById("date").children[0].innerText = MyDate;
    var secend = new Date().getSeconds();
    var minute = new Date().getMinutes();
    var hour = new Date().getHours();
    document.getElementById("date").children[1].innerText = hour + ":" + minute + ":" +secend;
} , 1000);

document.getElementById("btn_new_food").onclick = function () {
    document.getElementById("main_diets").style.opacity = 0.4;
    document.getElementById("main_diets").style.filter = "blur(4px)";
    document.getElementById("new_food").style.zIndex = 2;
    document.getElementById("new_food").style.opacity = 1;
    document.getElementById("new_food").style.visibility = "visible";
    document.getElementById("new_food").style.zIndex = 2;
}

document.getElementById("exit_new_food").onclick = function () {
    document.getElementById("main_diets").style.opacity =1;
    document.getElementById("main_diets").style.filter = "none";
    document.getElementById("new_food").style.opacity = 0;
    document.getElementById("new_food").style.visibility = "hidden";
    document.getElementById("new_food").style.zIndex = 2;
}

document.getElementById("btn_new_medical").onclick = function () {
    document.getElementById("main_diets").style.opacity = 0.4;
    document.getElementById("main_diets").style.filter = "blur(4px)";
    document.getElementById("new_medical").style.zIndex = 2;
    document.getElementById("new_medical").style.opacity = 1;
    document.getElementById("new_medical").style.visibility = "visible";
    document.getElementById("new_medical").style.zIndex = 2;
}

document.getElementById("exit_new_medical").onclick = function () {
    document.getElementById("main_diets").style.opacity =1;
    document.getElementById("main_diets").style.filter = "none";
    document.getElementById("new_medical").style.opacity = 0;
    document.getElementById("new_medical").style.visibility = "hidden";
    document.getElementById("new_medical").style.zIndex = 2;
}



