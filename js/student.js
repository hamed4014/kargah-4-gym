
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

