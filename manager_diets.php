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

if (isset($_POST['change_title_food_plan']))
{
    change_title_foodplan_1 ($pdo , $_POST['change_title_food_plan'] , $_POST['id_change_title']);
}

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



if (isset($_POST['new_title_medical']))
{
    create_new_medical_supplements( $pdo , $_POST['new_title_medical']);
}

if ( isset($_POST['id_delete_medical']))
{
    delete_medical_supplement($pdo , $_POST['id_delete_medical']);
}
$medical_supplements = get_medical_supplements($pdo);
$check_change =false;
$id = 0;
foreach ( $medical_supplements as $key )
{
    $id_test = $key['id'];
    if (isset($_POST["new_title_medical_id_$id_test"]))
    {
        $check_change = true;
        $id = $_POST["new_title_medical_id_$id_test"];
    }
}

if ($check_change)
{
    update_medical_supplement( $pdo , $id , $_POST["new_title_medical_$id"]);
    $medical_supplements = get_medical_supplements($pdo);
}

$food_plans = give_food_plans( $pdo );

?>

<datalist id="info_list">
    <?php
    foreach ( $food_plans as $key )
    {
        $title = $key['title'];
        echo "
        <option value='$title'>$title</option>
        ";
    }
    ?>
</datalist>

<?php
if ( isset($_GET['search']) )
{
    $food_plans = search_food_plans( $_GET['search'] , $food_plans );
}
?>

<main id="main_diets">
    <div class="search">
        <form method="get" action="manager_diets.php">
            <input list="info_list" id="search" name="search" class="form-control" placeholder="جست وجو">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <button id="btn_new_food_plan">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        تعریف برنامه غذایی جدید
    </button>
    <hr>
    برنامه های غذایی
    <table style="margin-bottom: 20px">
        <?php
        if ( count($food_plans) != 0 )
        {
            echo "
            <tr>
                <td>
                    ردیف
                </td>
                <td  style='width: 55%'>
                    عنوان
                </td>
                <td style='width: 15%'>
                    تاریخ ایجاد
                </td>
                <td>
                    امکانات
                </td>
            </tr>
            ";
            $i = 1;
            foreach ($food_plans as $key )
            {
                $title = $key['title'];
                $id = $key['id'];
                $history = $key['history'];
                echo "
            <tr>
                
                <td>
                    $i
                </td>
                <td style='width: 55%'>
                    $title
                </td  style='width: 15%'>
                <td>
                    $history
                </td>
                <td>
                    <form method='post' action='manager_diets.php'>
                    <input type='text' value = '$id' readonly name='id_delete_food_plan' id='id_delete_food_plan'>
                    <input type='submit' class='delete' value='حذف'>
                    </form>
                    
                    <form method='post' action='manager_food_plan.php'>
                        <input type='number' value='$id' readonly style='width: 0px; height: 0px; display: none' name='id' >
                        <input type='submit' class='delete' value='ویرایش' style='background-color: #0dcaf0'>
                    </form>
                    
                    <button class='delete' style='background-color: #79f00d; font-size: 10pt; width: 70px' id='btn_change_title_sportplan_$i'>
                    ویرایش عنوان
                    </button>
                    
                    <div class='change_window' id='change_title_sportplan_$i'>
                        <div>
                            <div>
                                    <span id='exit_change_title_sportplan_$i'>
                                        <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                    </span>
                    
                                <div style='text-align: center;'>
                                    ویرایش عنوان
                                </div>
                                <form class='form_new' method='post' action='manager_diets.php'>
                                    <label for='title'>
                                        عنوان:
                                    </label>
                                    <input type='text' maxlength='200' name='change_title_food_plan' id='new_title_sport_plan'>
                                    <input type='text' value='$id' name='id_change_title' style='display: none'>
                                    <br>
                                    <br>
                                    <input type='submit' value='ثبت'>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                    document.getElementById('exit_change_title_sportplan_$i').onclick = function () {
                    document.getElementById('change_title_sportplan_$i').style.opacity = 0;
                    document.getElementById('change_title_sportplan_$i').style.visibility = 'hidden';
                    document.getElementById('change_title_sportplan_$i').style.zIndex = 2;
                    }   
                    document.getElementById('btn_change_title_sportplan_$i').onclick = function () {
                    document.getElementById('change_title_sportplan_$i').style.opacity = 1;
                    document.getElementById('change_title_sportplan_$i').style.visibility = 'visible';
                    document.getElementById('change_title_sportplan_$i').style.zIndex = 2;
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
</main>

<div class="change_window" id="new_food_plan">
    <div>
        <div>
                <span id="exit_new_food_plan">
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
                </span>

            <div style="text-align: center;">
                تعریف برنامه غذایی جدید
            </div>
            <form class="form_new" method="post" action="manager_food_plan.php">
                <label for="title">
                    عنوان:
                </label>
                <input type="text" maxlength="200" name="new_title_food_plan" id="new_title_food_plan">
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
            $text = give_text( $_COOKIE['id'] , $pdo);
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