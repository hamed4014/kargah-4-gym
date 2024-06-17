
var scroll_test = localStorage.getItem('scrollTop');
scroll(0,scroll_test);
var scroll_top = 500;
setInterval( function () {
    var scroll_top = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    window.onscroll = e => localStorage.setItem('scrollTop', scroll_top);
} , 100);

document.getElementById("btn_new_food_plan").onclick = function () {
    document.getElementById("main_diets").style.opacity = 0.4;
    document.getElementById("main_diets").style.filter = "blur(4px)";
    document.getElementById("new_food_plan").style.zIndex = 2;
    document.getElementById("new_food_plan").style.opacity = 1;
    document.getElementById("new_food_plan").style.visibility = "visible";
    document.getElementById("new_food_plan").style.zIndex = 2;
}

document.getElementById("exit_new_food_plan").onclick = function () {
    document.getElementById("main_diets").style.opacity =1;
    document.getElementById("main_diets").style.filter = "none";
    document.getElementById("new_food_plan").style.opacity = 0;
    document.getElementById("new_food_plan").style.visibility = "hidden";
    document.getElementById("new_food_plan").style.zIndex = 2;
}

