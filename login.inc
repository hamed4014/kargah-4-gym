<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باشگاه</title>
    <link href="css/main.css" type="text/css" rel="stylesheet">
</head>

<body>
<div style="width: 100%; position: fixed; opacity: 0; visibility: hidden; background-color: rgba(255,255,255,0); transition: 0.5s" id="login">
    <div class="signin">
        <div>
            <span id="exit_login">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center;">
                ورود
            </div>
            <form class="form" method="post" action="index.php">
                <br>
                <div style="float: none; text-align: center; margin-right: auto; margin-left: auto"">
                    <div>
                        نام کاربری:
                    </div>
                    <div>
                        <input type="text" name="username_log" id="username_log" maxlength="15" minlength="3" class="form-control">
                    </div>
                </div>
                <div style="float: none; text-align: center; margin-right: auto; margin-left: auto">
                    <div>
                        رمز عبور:
                    </div>
                    <div>
                        <input type="password" name="password_log" id="password_log" maxlength="16" minlength="8" class="form-control">
                    </div>
                </div>
                <a style="text-align: center; font-size: 10pt;font-family: 'Titr'; cursor: pointer; margin-top: 15px; color: blue; text-decoration: blue underline">
                    فراموشی کلمه عبور
                </a>
                <a style="text-align: center; font-size: 10pt;font-family: 'Titr';
                 cursor: pointer; margin-top: 15px; color: blue; text-decoration: blue underline; margin-right: 80px" id="btn_signin">
                    ساخت حساب جدید
                </a>
                <input type="submit" value="تایید" class="form-control btn_ok">

            </form>

        </div>
    </div>
</div>


<script src="js/main.js"></script>
</body>


</html>


