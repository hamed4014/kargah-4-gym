<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باشگاه</title>
    <link href="css/main.css" type="text/css" rel="stylesheet">
</head>

<body>
<div style="width: 100%; position: fixed; opacity: 0; visibility: hidden; background-color: rgba(255,255,255,0); transition: 0.5s; top: 65px" id="signin">
    <div class="signin" style="height: 550px; width: 1400px;">
        <div style="width: 1400px;">
            <span id="exit_signin">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div>
                ثبت نام شاگرد جدید
            </div>
            <form class="form" method="post" action="manager_students.php" enctype="multipart/form-data">
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
                        شماره همراه:
                    </div>
                    <div>
                        <input type="tel" pattern="[0-9]{11}" name="phone" id="phone" maxlength="11" minlength="11" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        تاریخ تولد:
                    </div>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="day" id="day" required>
                        <?php
                        for ($i = 1 ; $i <= 31 ; $i++)
                        {
                            echo "<option selected value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="month" id="month" required>
                        <?php
                        for ($i = 1 ; $i <= 12 ; $i++)
                        {
                            echo "<option selected value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="year" id="year" required>
                        <?php
                        for ($i = 1300 ; $i <= 1402 ; $i++)
                        {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <div>
                        جنسیت:
                    </div>
                    <div>
                        <span class="form-check" style="width: 90px; float: right">
                            <input class="form-check-input" type="radio" name="gender" id="gender1" value="female">
                            <label class="form-check-label" for="gender1">
                                زن
                            </label>
                        </span>
                        <span class="form-check" style="width: 90px; float: right">
                            <input class="form-check-input" type="radio" name="gender" id="gender2" value="male" checked>
                            <label class="form-check-label" for="gender2">
                                مرد
                            </label>
                        </span>
                    </div>
                </div>
                <div>
                    <div>
                        قد:
                    </div>
                    <div>
                        <input type="number" name="height" id="height" max="250" min="100" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        وزن:
                    </div>
                    <div>
                        <input type="number" name="weight" id="weight" class="form-control" required>
                    </div>
                </div>
                <div>
                    <div>
                        عکس پروفایل:
                    </div>
                    <div>
                        <input type="file" name="image1" id="image" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 1:
                    </div>
                    <div>
                        <input type="file" name="image2" id="image" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 2:
                    </div>
                    <div>
                        <input type="file" name="image3" id="image" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 3:
                    </div>
                    <div>
                        <input type="file" name="image4" id="image" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 4:
                    </div>
                    <div>
                        <input type="file" name="image5" id="image" class="form-control">
                    </div>
                </div>
                <br><br><br>
                <div class="input_text">
                    <div style="font-size: 10pt; width: 160px">
                        در صورت داشتن مصدومیت آن را توضیح دهید:
                    </div>
                    <div style="width: 165px">
                        <textarea type="text" name="injury" id="injury" class="form-control"></textarea>
                    </div>
                </div>
                <div class="input_text">
                    <div style="font-size: 10pt; width: 160px">
                        هدف:
                    </div>
                    <div style="width: 165px">
                        <textarea type="text" name="target" id="target" class="form-control"></textarea>
                    </div>
                </div>
                <div class="input_text">
                    <div style="font-size: 10pt; width: 160px">
                        در صورت داشتن سابقه تمرین آن را بنویسید:
                    </div>
                    <div style="width: 165px">
                        <textarea type="text" name="history" id="history" class="form-control"></textarea>
                    </div>
                </div>


                <input type="submit" value="تایید" class="form-control btn_ok" style="position: absolute; bottom: 80px">

            </form>

        </div>
    </div>
</div>
</body>


</html>


