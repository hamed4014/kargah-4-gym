<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باشگاه</title>
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <link href="css/manager.css" type="text/css" rel="stylesheet">
</head>

<?php
if (isset($_POST['text']))
{
    $id = $_COOKIE ['id'];
    $text = $_POST['text'];
    save_text(  $id , $text , $pdo);
}
if (!isset($_COOKIE ['fname']))
{
    redirect("error_log.php");
}
?>

<body>

<div class="header_menu">

    <div>
        <a href="index.php">
            <div style="width: 90px">
                &nbsp;صفحه نخست
            </div>
        </a>
        <div>دوره ها &nbsp;
            <i class="fa-solid fa-chalkboard-user" style="color: #000000;"></i>
        </div>
        <div>مقالات &nbsp;
            <i class="fa-solid fa-book" style="color: #000000;"></i>
        </div>
        <div id="btn_call">تماس با ما &nbsp;
            <i class="fa-solid fa-phone-volume" style="color: #000000;"></i>
        </div>
    </div>
    <div style="width: 20%;" class="menu_person">
        <?php
        $name = $_COOKIE ['fname']." ".$_COOKIE ['lname'];
        $file_name = "admin_".$_COOKIE['id'].".jpg";
        if (file_exists("image/$file_name"))
        {
            echo "
            <div style='float: left; font-size: 10pt; width: 130px' id='btn_person'> 
                $name
                <img src='image/$file_name' class='image' >
                
            </div>
            ";
        }
        else
        {
            echo "
            <div style='float: left; font-size: 10pt; width: 130px' id='btn_person'> 
                $name
                <i class='fa-solid fa-circle-user fa-lg' style='color: #000000;font-size: 20pt;margin-left: 1px;'></i>
            </div>
            ";
        }

        ?>
        <ul id="menu_person">
            <a href="manager_profile.php">
                <li>
                    پروفایل
                </li>
            </a>
            <form action="index.php" method="post">
                <input name="exit" value="1" readonly style="display: none">
                <button type="submit" style="border: none">
                    <li>
                        خروج
                    </li>
                </button>
            </form>
        </ul>
        <a href="manager_dashboard.php">
            <div style='float: left; font-size: 10pt; width: 130px' id='btn_person'>
                داشبورد
            </div>
        </a>
    </div>

    <span style="position: absolute; height: 50px; top: 18px; right: 48%">
        <i class="fa-sharp fa-regular fa-dumbbell fa-2xl" style="color: #000000;"></i>
    </span>
</div>
<script src="js/manager.js"></script>
<script src="js/main.js"></script>
</body>


</html>


