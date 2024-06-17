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
    $pdo = require_once ('connection.inc');
    require ('functions.inc');
    require ('manager_header.inc');
    ?>
</header>
<?php

if (isset($_POST['new_title']))
{
    create_new_food( $pdo , $_POST['new_title']);
}

if ( isset($_POST['id_delete']))
{
    delete_food($pdo , $_POST['id_delete']);
}

if ( isset($_POST['id_delete_food_plan']))
{
    delete_food_plan($pdo , $_POST['id_delete_food_plan']);
}

$foods = get_foods($pdo);
$check_change =false;
$id = 0;
foreach ( $foods as $key )
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
    update_food( $pdo , $id , $_POST["new_title_$id"]);
    $foods = get_foods($pdo);
}

?>
<main id="main_diets">
    وعده های غذایی
    <table>
        <?php
        if ( count($foods) != 0 )
        {
            echo "
            <tr>
                <td>
                    ردیف
                </td>
                <td>
                    عنوان
                </td>
                <td>
                    ###
                </td>
            </tr>
            ";
            $i = 1;
            foreach ($foods as $key )
            {
                $title = $key['title'];
                $id = $key['id'];
                echo "
            <tr>
                <td>
                    $i
                </td>
                <td>
                    $title
                </td>
                <td>
                    <form method='post' action='manager_foods.php'>
                    <input type='text' value = '$id' readonly name='id_delete' id='id_delete'>
                    <input type='submit' class='delete' value='حذف'>
                    </form>
                    
                    <button class='change' id='btn_change_$id'>
                        ویرایش
                    </button>
                    
                    <div class='change_window' id='change_food_$id'>
                        <div>
                            <div>
                                <span id='exit_change_food_$id'>
                                    <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                </span>
                                <div style='text-align: center;'>
                                    ویرایش برنامه غذایی
                                </div>
                                <form class='form_new' method='post' action='manager_foods.php'>
                                    <label for='title'>
                                عنوان:
                                    </label>
                                    <input type='text' maxlength='200' name='new_title_$id' id='new_title'>
                                    <input type='text' name='new_title_id_$id' id='new_title' style='display: none;' value='$id'>
                                    <br>
                                    <input type='submit' value='ثبت'>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                    document.getElementById('exit_change_food_$id').onclick = function () {
                    document.getElementById('main_diets').style.opacity =1;
                    document.getElementById('main_diets').style.filter = 'none';
                    document.getElementById('change_food_$id').style.opacity = 0;
                    document.getElementById('change_food_$id').style.visibility = 'hidden';
                    document.getElementById('change_food_$id').style.zIndex = 2;
                    }   
                    document.getElementById('btn_change_$id').onclick = function () {
                    document.getElementById('change_food_$id').style.opacity = 1;
                    document.getElementById('change_food_$id').style.visibility = 'visible';
                    document.getElementById('change_food_$id').style.zIndex = 2;
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
            هیچ برنامه غذایی تعریف نشده است.
            </td>
            ";
        }

        ?>
    </table>
    <button id="btn_new_food">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        تعریف وعده غذایی جدید
    </button>
</main>

<div class="change_window" id="new_food">
    <div>
        <div>
                <span id="exit_new_food">
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
                </span>

            <div style="text-align: center;">
                تعریف وعده غذایی جدید
            </div>
            <form class="form_new" method="post" action="manager_foods.php">
                <label for="title">
                    عنوان:
                </label>
                <input type="text" maxlength="200" name="new_title" id="new_title">
                <br>
                <input type="submit" value="ثبت">
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="remember">
        <form method="post" action="manager_diets.php">
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
<script src="js/manager_diets.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
<?php
