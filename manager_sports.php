<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باشگاه</title>

    <link href="bootstrap-5.3.0-dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
          crossorigin="anonymous">
    <link href="fontawesome-free-6.4.0-web/css/fontawesome.css" rel="stylesheet">
    <link href="fontawesome-free-6.4.0-web/css/brands.css" rel="stylesheet">
    <link href="fontawesome-free-6.4.0-web/css/solid.css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <link href="css/manager.css" type="text/css" rel="stylesheet">
</head>

<body>

<header>
    <?php
    require ('functions.inc');
    $pdo = require_once ('connection.inc');
    require ('manager_header.inc');
    ?>
</header>
<?php

if (isset($_POST['new_title']))
{
    create_new_sport( $pdo , $_POST['new_title'] , $_POST['new_text']);
}

if ( isset($_POST['id_delete']))
{
    delete_sport($pdo , $_POST['id_delete']);
}

if (isset($_POST['new_title_sport_plan']))
{
    create_sport_plan( $pdo , $_POST['new_title_sport_plan'] , $_POST['type_sport_plan']);
}

if ( isset($_POST['id_delete_sport_plan']))
{
    delete_sport_plan($pdo , $_POST['id_delete_sport_plan']);
}

$sports = get_sports($pdo);
$check_change =false;
$id = 0;
foreach ( $sports as $key )
{
    $id_test = $key['id'];
    if (isset($_POST["new_title_id_$id_test"]))
    {
        $check_change = true;
        $id = $_POST["new_title_id_$id_test"];
    }
}

if ($check_change)
{
    update_sport( $pdo , $id , $_POST["new_title_$id"] , $_POST["new_text_$id"]);
    $sports = get_sports($pdo);
}

?>
<main id="main_diets">
    تمرین ها
    <table>
        <?php
        if ( count($sports) != 0 )
        {
            echo "
            <tr>
                <td style='width: 10%'>
                    ردیف
                </td>
                <td style='width: 30%'>
                    عنوان
                </td>
                <td style='width: 40%'>
                    توضیحات
                </td>
                <td style='width: 20%'>
                    ###
                </td>
            </tr>
            ";
            $i = 1;
            foreach ($sports as $key )
            {
                $title = $key['title'];
                $text = $key['text'];
                $id = $key['id'];
                echo "
            <tr>
                <td style='width: 10%'>
                    $i
                </td>
                <td style='width: 30%'>
                    $title
                </td>
                <td style='width: 40%'>
                    $text
                </td>
                <td style='width: 20%'>
                    <form method='post' action='manager_sports.php'>
                    <input type='text' value = '$id' readonly name='id_delete' id='id_delete'>
                    <input type='submit' class='delete' value='حذف'>
                    </form>
                    
                    <button class='change' id='btn_change_$id'>
                        ویرایش
                    </button>
                    
                    <div class='change_window' id='change_sport_$id'>
                        <div style='height: 300px'>
                            <div>
                                <span id='exit_change_sport_$id'>
                                    <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                </span>
                                <div style='text-align: center;'>
                                    ویرایش برنامه تمرینی
                                </div>
                                <form class='form_new' method='post' action='manager_sports.php'>
                                    <label for='title'>
                                عنوان:
                                    </label>
                                    <input type='text' maxlength='200' name='new_title_$id' value='$title' id='new_title'>
                                    <br>
                                    <label for='title'>
                                توضیحات:
                                    </label>
                                    <input type='text' maxlength='200' name='new_text_$id' value='$text' id='new_title'>
                                    <input type='text' name='new_title_id_$id' id='new_title' style='display: none;' value='$id'>
                                    <br>
                                    <input type='submit' value='ثبت'>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                    document.getElementById('exit_change_sport_$id').onclick = function () {
                    document.getElementById('main_diets').style.opacity =1;
                    document.getElementById('main_diets').style.filter = 'none';
                    document.getElementById('change_sport_$id').style.opacity = 0;
                    document.getElementById('change_sport_$id').style.visibility = 'hidden';
                    document.getElementById('change_sport_$id').style.zIndex = 2;
                    }   
                    document.getElementById('btn_change_$id').onclick = function () {
                    document.getElementById('change_sport_$id').style.opacity = 1;
                    document.getElementById('change_sport_$id').style.visibility = 'visible';
                    document.getElementById('change_sport_$id').style.zIndex = 2;
                    }
                    
                    
                    </script>
                    
                </td>
            </tr>
            ";
                $i++;
            }
        }
        else
        {
            echo "
            <td style='width: 100%'>
            هیچ برنامه تمرینی تعریف نشده است.
            </td>
            ";
        }

        ?>
    </table>
    <button id="btn_new_sport">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        تعریف تمرین جدید
    </button>

</main>

<div class="change_window" id="new_sport">
    <div style="height: 300px">
        <div>
                <span id="exit_new_sport">
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
                </span>

            <div style="text-align: center;">
                تعریف تمرین جدید
            </div>
            <form class="form_new" method="post" action="manager_sports.php">
                <label for="title">
                    عنوان:
                </label>
                <input type="text" maxlength="200" name="new_title" id="new_title">
                <br>
                <label for="title">
                    توضیحات:
                </label>
                <input type="text" maxlength="200" name="new_text" id="new_title">
                <br>
                <input type="submit" value="ثبت">
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="remember">
        <form method="post" action="manager_sports.php">
            <label for="text">
                یادداشت:
            </label>
            <?php
            $id = $_COOKIE['id'];
            $text = give_text( $id , $pdo);
            echo "
                    <textarea type='text' name='text' id='text' maxlength='1000' class='form-control'> $text </textarea>
                    ";
            ?>

            <input type="submit" value="ذخیره" id="save_remember">
        </form>
    </div>
</footer>

<script src="js/manager.js"></script>
<script>
    document.getElementById("btn_new_sport").onclick = function () {
        document.getElementById("main_diets").style.opacity = 0.4;
        document.getElementById("main_diets").style.filter = "blur(4px)";
        document.getElementById("new_sport").style.opacity = 1;
        document.getElementById("new_sport").style.visibility = "visible";
        document.getElementById("new_sport").style.zIndex = 2;
    };

    document.getElementById("exit_new_sport").onclick = function () {
        document.getElementById("main_diets").style.opacity =1;
        document.getElementById("main_diets").style.filter = "none";
        document.getElementById("new_sport").style.opacity = 0;
        document.getElementById("new_sport").style.visibility = "hidden";
        document.getElementById("new_sport").style.zIndex = 2;
    };
</script>
<script src="js/manager_sports.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
