<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باشگاه</title>
    <link href="css/main.css" type="text/css" rel="stylesheet">
</head>

<body>
<div style="width: 100%; position: fixed; opacity: 0; visibility: hidden; background-color: rgba(255,255,255,0); transition: 0.5s" id="signin">
    <div class="signin">
        <div>
            <span id="exit_signin">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div>
                ثبت نام
            </div>
            <form class="form" method="post" action="index.php" enctype="multipart/form-data">
                <div>
                    <div>
                        نام:
                    </div>
                    <div>
                        <input type="text" name="fname" id="fname" maxlength="15" minlength="3" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        نام خانوادگی:
                    </div>
                    <div>
                        <input type="text" name="lname" id="lname" maxlength="15" minlength="3" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        ایمیل:
                    </div>
                    <div>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        نام کاربری:
                    </div>
                    <div>
                        <input type="text" name="username" id="username" maxlength="15" minlength="3" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        رمز عبور:
                    </div>
                    <div>
                        <input type="password" name="password" id="password" maxlength="16" minlength="8" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        عکس پروفایل:
                    </div>
                    <div>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <br><br><br>
                <section id="btn_login2" style="display: inline-block; width: 100px; text-align: center;
                 font-size: 10pt;font-family: 'Titr'; cursor: pointer; margin-top: 20px; color: blue; text-decoration: blue underline;
                 margin-left: auto;margin-right: auto">
                    قبلا ثبت نام کردم!!!
                </section>
                <input type="submit" value="تایید" class="form-control btn_ok">

            </form>

        </div>
    </div>
</div>


<script src="js/main.js"></script>
</body>


</html>

