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
    <style>
        textarea {
            font-family: "B Titr";
        }
    </style>
</head>



<body>

<header>
    <?php
    require ('jdf.php');
    require ('functions.inc');
    $pdo = require_once ('connection.inc');
    require ('manager_header.inc');
    ?>
</header>
<?php

if(isset( $_POST['id']))
{
    $id = $_POST['id'];
}
else
{
    $id = $_POST['id_1'];
}

$sports =get_sports($pdo);

if(isset($_POST['sport_delete']))
{
    delete_one_sport_plan ( $pdo , $_COOKIE['id'] , $id , $_POST['sport_delete'] , $_POST['number2'] , $_POST['number3'] );
}

if (isset($_POST['student_delete']))
{
    delete_sport_plan_of_user ( $pdo , $_COOKIE['id'] , $_POST['student_delete']);
}

if (isset($_POST['new_day']))
{
    create_new_day_sportplan($pdo , $_POST['new_day'] , $id);
}

if (isset($_POST['text_sport']))
{
    change_text_sport($_POST['text_sport'] , $_POST['number'] , $pdo , $id );
}

if (isset($_POST['number_delete_sport']))
{
    delete_sportplan_of_sport_plans( $pdo , $id , $_POST['number_delete_sport']);
}

if (isset($_POST['number_delete_sport_1']))
{
    delete_sportplan_of_sport_plans_2( $pdo , $id , $_POST['number_delete_sport_1'] , $_POST['number_delete_sport_2']);
}

if (isset ($_POST['user']))
{
    add_user_sport_plan ( $pdo , $id , $_POST['user'] );
}


$sport_plan = give_sport_plan ($pdo , $id);

$day_temp = $sport_plan ['day'];
$day = array();
$text = array();
if($day_temp != null)
{
    for ( $i = 0 ; $i < strlen($day_temp) ; $i++)
    {
        if ($day_temp[$i] == "{")
        {
            $temp = "";
            while ( true )
            {
                $i++;
                if ($day_temp[$i] == "/")
                {
                    array_push( $day , $temp );
                    break;
                }
                $temp = $temp.$day_temp[$i];
            }
            $temp = "";
            while ( true )
            {
                $i++;
                if ($day_temp[$i] == "}")
                {
                    array_push( $text , $temp );
                    break;
                }
                $temp = $temp.$day_temp[$i];

            }
        }
    }
}

for ($i = 1 ; $i <= count($day) ; $i++ )
{
    if (isset ($_POST["new_sports_id_1_$i"]))
    {
        change_sport( $pdo , $id , $_POST["new_sports_id_1_$i"] , $_POST["new_sports_id_2_$i"] ,
            $_POST["new_repead_sports_$i"] , $_POST["new_rest_sports_$i"] ,
            $_POST["new_move_sports_$i"]);
        $sport_plan = give_sport_plan ($pdo , $id);
    }
    if (isset($_POST["new_sports_$i"]))
    {
        add_sport_aerobic ( $pdo , $id , $_POST["new_sports_id_1_add_$i"] , $_POST["new_sports_id_2_$i"] , $_POST["new_sports_$i"]);
        $sport_plan = give_sport_plan ($pdo , $id);
    }
    if (isset ($_POST["new_sports_id_$i"]))
    {
        add_sport( $pdo , $id , $_POST["new_sports_id_$i"] ,
        $_POST["new_repead_sports_$i"] , $_POST["new_rest_sports_$i"] , $_POST["new_move_sports_$i"]);
        $sport_plan = give_sport_plan ($pdo , $id);

        $day_temp = $sport_plan ['day'];
        $day = array();
        $text = array();
        if($day_temp != null)
        {
            for ( $i = 0 ; $i < strlen($day_temp) ; $i++)
            {
                if ($day_temp[$i] == "{")
                {
                    $temp = "";
                    while ( true )
                    {
                        $i++;
                        if ($day_temp[$i] == "/")
                        {
                            array_push( $day , $temp );
                            break;
                        }
                        $temp = $temp.$day_temp[$i];
                    }
                    $temp = "";
                    while ( true )
                    {
                        $i++;
                        if ($day_temp[$i] == "}")
                        {
                            array_push( $text , $temp );
                            break;
                        }
                        $temp = $temp.$day_temp[$i];

                    }
                }
            }
        }
        break;
    }
}

$sportplans_temp = $sport_plan ['sports'];
$sportplans = array(array());
$titles = array();
$number_1 = 0;
$number_2 = 0;
$temp ="";
for ( $i = 0 ; $i < strlen($sportplans_temp) ; $i++ )
{
    if ( $sportplans_temp[$i] == "{" )
    {
        $test = $i;
        while (true)
        {
            $i++;
            if ($sportplans_temp[$i] == "}")
            {
                if($i == $test+1)
                {
                    $sportplans[$number_1] = array();
                }
                $number_1++;
                $number_2 = 0;
                break;
            }
            if ($sportplans_temp[$i] == "(")
            {
                $sportplans[$number_1][$number_2]['title'] = array();

                while (true)
                {
                    $i++;
                    if ($sportplans_temp[$i] == "[")
                    {
                        $temp = "";
                        while (true)
                        {
                            $i++;
                            if ($sportplans_temp[$i] == "]")
                            {
                                foreach ($sports as $key)
                                {
                                    if ($key['id'] == $temp)
                                    {
                                        if ($key['text'] == null)
                                        {
                                            array_push( $sportplans[$number_1][$number_2]['title'] , $key['title']);
                                        }
                                        else
                                        {
                                            array_push( $sportplans[$number_1][$number_2]['title'] , $key['title']." (".$key['text'].") " );
                                        }
                                    }
                                }
                                break;
                            }
                            $temp = $temp.$sportplans_temp[$i];
                        }
                    }
                    if ($sportplans_temp[$i] == ":")
                    {
                        break;
                    }
                }
                $temp = "";
                while (true)
                {
                    $i++;
                    if ($sportplans_temp[$i] == ":")
                    {
                        $sportplans[$number_1][$number_2]['repead'] = $temp;
                        break;
                    }
                    $temp = $temp.$sportplans_temp[$i];
                }
                $temp = "";
                while (true)
                {
                    $i++;
                    if ($sportplans_temp[$i] == ":")
                    {
                        $sportplans[$number_1][$number_2]['rest'] = $temp;
                        break;
                    }
                    $temp = $temp.$sportplans_temp[$i];
                }
                $temp = "";
                while (true)
                {
                    $i++;
                    if ($sportplans_temp[$i] == ")")
                    {
                        $sportplans[$number_1][$number_2]['move'] = $temp;
                        $number_2++;
                        break;
                    }
                    $temp = $temp.$sportplans_temp[$i];
                }
                $temp = "";

            }
        }
    }
}

$users = get_users_info($pdo , $_COOKIE['id']);

?>

<datalist id="sportplans_list">
    <?php
    foreach ( $sports as $key )
    {
        $id_temp = $key['id'];
        if ( $key['text'] == null )
        {
            $foodplan_test = $key['title'];
        }
        else
        {
            $foodplan_test = $key['title']." (".$key['text'].")";
        }
        echo "
        <option value='$id_temp'>$foodplan_test</option>
        ";
    }
    ?>
</datalist>
<datalist id="users_list">
    <?php
    foreach ( $users as $key )
    {
        $id_temp = $key['id'];
        $foodplan_test = $key['fname']." ".$key['lname'];
        echo "
        <option value='$id_temp'>$foodplan_test</option>
        ";
    }
    ?>
</datalist>

<main id="main_student_info">
    <span style="border: none; box-shadow: none; text-align: right; padding-right: 10px;">
        <form method="post" action="manager_sport_plan_1.php" style="display: inline-block; float: right">
            <label style="height: 30px; font-size: 15pt">شاگردان:</label>
            &nbsp;
            <input list="users_list" name="user" id="user" style="font-family: 'B Titr'; height: 30px; margin-top: 3px">
            <?php
            echo "<input type='text' name='id' style='display: none;' value='$id'>";
            ?>
            <input type="submit" value="اضافه کردن" id="btn_add_student">
        </form>
        <?php
        $check = false;
        foreach ( $users as $key )
        {
            if ( $key['sportplan'] == $id )
            {
                $check = true;
            }
        }
        if ($check)
        {
            ?>
            <div class="students_list">
                <?php
                foreach ( $users as $key )
                {
                    if ( $key['sportplan'] == $id )
                    {
                        $name = $key['fname']." ".$key['lname'];
                        $id_temp = $key['id'];
                        echo "
                        <div>
                            <form method='post' action='manager_sport_plan_1.php' style='float: right; display: inline-block'>
                                $name &nbsp; &nbsp;
                                <input name='student_delete' type='text' value='$id_temp' style='display: none'>
                                <input name='id' type='text' value='$id' style='display: none'>
                                <button type='submit'>
                                    <i class='fa-regular fa-trash-can' style='color: #4d4d4d;'></i>
                                </button>
                            </form>
                            <form method='post' action='print_sport1.php' style='float: right; display: inline-block'>
                                <input name='id' type='text' value='$id_temp' style='display: none'>
                                <button type='submit' style='float: right'>
                                    <i class='fa-solid fa-print' style='color: #4d4d4d; margin-right: 6px'></i>
                                </button>
                            </form>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
            <?php
        }
        ?>

    </span>
    <hr>
    <span style="border: none; box-shadow: none">
        <br>

        <?php
        echo $sport_plan['title']."<br>";
        if (count($day) == 0)
        {
            echo "
            <div>
            برنامه طراحی نشده است!
            </div>
            ";
        }
        else
        {
            $number = 0;
            foreach ( $day as $key )
            {
                $number++;
                echo "
                <br>
                $key
                <table>
                <tr>
                    <td style='width: 34%'>
                        تمرین
                    </td>
                    <td style='width: 18%'>
                        تعداد تکرار و مقدار ست
                    </td>
                    <td style='width: 18%'>
                        زمان استراحت بین ست ها
                    </td>
                    <td style='width: 18%'>
                        زمان برای حرکت
                    </td>
                    <td style='width: 12%'>
                        <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' value = '$id' readonly name='id' id='id_delete' style='display: none'>
                                <input type='text' value = '$number' readonly name='number_delete_sport' id='number_delete' style='display: none'>
                                <input type='submit' class='delete' value='حذف'>
                            </form>
                            <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' name='new_sports_id_$number' id='new_title' style='display: none;' value='$number'>
                                <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                <input type='text' name='new_move_sports_$number' id='new_text_sportplan' style='display: none' value=''>
                                <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' style='display: none' value=''>
                                <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' style='display: none' value=''>
                                <button class='add' type='submit'>
                                    اضافه کردن
                                </button>
                            </form>
                            
                         
                            
                            <div class='change_window' id='add_sportplan_$number'>
                                <div style='height: 450px'>
                                    <div>
                                        <span id='exit_add_sportplan_$number'>
                                            <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                        </span>
                                        <div style='text-align: center;'>
                                            اضافه کردن تمرین
                                        </div>
                                        <form class='form_new' method='post' action='manager_sport_plan_1.php' style='text-align: left'>
                                            <label for='title'>
                                        تعداد تکرار:
                                            </label>
                                            <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' style='margin-left: 130px'>
                                            <br>
                                            <label for='title'>
                                        زمان استراحت:
                                            </label>
                                            <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' style='margin-left: 130px'>
                                            <br>
                                            <label for='title'>
                                        زمان برای حرکت:
                                            </label>
                                            <input type='text' name='new_move_sports_$number' id='new_text_sportplan' style='margin-left: 130px'>
                                            <input type='text' name='new_sports_id_$number' id='new_title' style='display: none;' value='$number'>
                                            <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                            <br>
                                            <input type='submit' value='ثبت' style='margin-left: 200px'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            document.getElementById('exit_add_sportplan_$number').onclick = function () {
                            document.getElementById('main_student_info').style.opacity =1;
                            document.getElementById('main_student_info').style.filter = 'none';
                            document.getElementById('add_sportplan_$number').style.opacity = 0;
                            document.getElementById('add_sportplan_$number').style.visibility = 'hidden';
                            document.getElementById('add_sportplan_$number').style.zIndex = 2;
                            }   
                            document.getElementById('btn_add_sportplan_$number').onclick = function () {
                            document.getElementById('add_sportplan_$number').style.opacity = 1;
                            document.getElementById('add_sportplan_$number').style.visibility = 'visible';
                            document.getElementById('add_sportplan_$number').style.zIndex = 2;
                            }
                            
                            
                            </script>
                    </td>
                </tr>
                ";
                $number_2 = 0;
                foreach ( $sportplans[ $number - 1] as $key_temp )
                {
                    $number_2++;
                    $name_element = $number."_".$number_2;
                    $repead_test = $key_temp['repead'];
                    $rest_test = $key_temp['rest'];
                    $move_test = $key_temp['move'];
                    echo "
                    <tr style='width: 100%;'>
                        <td style='width: 34%; height: 30px; text-align: right; padding: 4px; padding-right: 10px'>
                    ";
                    $number_3 = 0;
                    foreach ( $key_temp['title'] as $key_title )
                    {
                        $number_3++;
                        echo "
                        <div class='plans_list'>
                            <form method='post' action='manager_sport_plan_1.php'>
                                $key_title &nbsp; &nbsp;
                                <input name='sport_delete' type='text' value='$number' style='display: none'>
                                <input name='number2' type='text' value='$number_2' style='display: none'>
                                <input name='number3' type='text' value='$number_3' style='display: none'>
                                <input name='id' type='text' value='$id' style='display: none'>
                                <button type='submit'>
                                    <i class='fa-regular fa-trash-can' style='color: #4d4d4d;'></i>
                                </button>
                            </form>
                        </div>
                        ";
                    }
                    echo "
                    <form class='form_plans_list' method='post' action='manager_sport_plan_1.php' style='text-align: left'>
                        <input list='sportplans_list' name='new_sports_$number' id='new_text_sportplan' style='margin: 0px; border: none'>
                        <input type='text' name='new_sports_id_1_add_$number' id='new_title' style='display: none;' value='$number'>
                        <input type='text' name='new_sports_id_2_$number' id='new_title' style='display: none;' value='$number_2'>
                        <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                        <button type='submit'>
                            <i class='fa-solid fa-plus' style='color: #3fda34;'></i>
                        </button>
                    </form>
                    ";
                    echo "
                        </td>
                        <td  style='width: 18%; height: 30px; text-align: right; padding-right: 10px'>
                            <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' value='$repead_test' style='margin: 2px; padding: 2px; border: none; width: 160px;float: right'>
                                <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' value='$rest_test' style='display: none;'>
                                <input type='text' name='new_move_sports_$number' id='new_text_sportplan' value='$move_test' style='display: none;'>
                                <input type='text' name='new_sports_id_1_$number' id='new_title' style='display: none;' value='$number'>
                                <input type='text' name='new_sports_id_2_$number' id='new_title' style='display: none;' value='$number_2'>
                                <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                <button type='submit' style='display: inline-block; float: right; border: none; background-color: rgba(31,229,0,0.3); border-radius: 50%; width: 30px; height: 30px; vertical-align: center'>
                                    <i class='fa-solid fa-check' style='color: #00f01c;'></i>
                                </button>
                            </form>
                        </td>
                        <td  style='width: 18%; height: 30px; text-align: right; padding-right: 10px'>
                            <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' value='$repead_test' style='display: none'>
                                <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' value='$rest_test' style='margin: 2px; padding: 2px; border: none; width: 160px;float: right'>
                                <input type='text' name='new_move_sports_$number' id='new_text_sportplan' value='$move_test' style='display: none;'>
                                <input type='text' name='new_sports_id_1_$number' id='new_title' style='display: none;' value='$number'>
                                <input type='text' name='new_sports_id_2_$number' id='new_title' style='display: none;' value='$number_2'>
                                <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                <button type='submit' style='display: inline-block; float: right; border: none; background-color: rgba(31,229,0,0.3); border-radius: 50%; width: 30px; height: 30px; vertical-align: center'>
                                    <i class='fa-solid fa-check' style='color: #00f01c;'></i>
                                </button>
                            </form>
                        </td>
                        <td  style='width: 18%; height: 30px; text-align: right; padding-right: 10px'>
                            <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' value='$repead_test' style='display: none'>
                                <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' value='$rest_test' style='display: none'>
                                <input type='text' name='new_move_sports_$number' id='new_text_sportplan' value='$move_test' style='margin: 2px; padding: 2px; border: none; width: 160px;float: right'>
                                <input type='text' name='new_sports_id_1_$number' id='new_title' style='display: none;' value='$number'>
                                <input type='text' name='new_sports_id_2_$number' id='new_title' style='display: none;' value='$number_2'>
                                <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                <button type='submit' style='display: inline-block; float: right; border: none; background-color: rgba(31,229,0,0.3); border-radius: 50%; width: 30px; height: 30px; vertical-align: center'>
                                    <i class='fa-solid fa-check' style='color: #00f01c;'></i>
                                </button>
                            </form>
                        </td>
                        <td style='width: 12%'>
                            <form method='post' action='manager_sport_plan_1.php'>
                                <input type='text' value = '$id' readonly name='id' id='id_delete' style='display: none'>
                                <input type='text' value = '$number' readonly name='number_delete_sport_1' id='number_delete' style='display: none'>
                                <input type='text' value = '$number_2' readonly name='number_delete_sport_2' id='number_delete' style='display: none'>
                                <input type='submit' class='delete' value='حذف'>
                            </form>
                            <button class='change' id='btn_change_sportplan_$name_element'>
                               ویرایش
                            </button>
                            
                            <div class='change_window' id='change_sportplan_$name_element'>
                                <div style='height: 450px'>
                                    <div>
                                        <span id='exit_change_sportplan_$name_element'>
                                            <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                        </span>
                                        <div style='text-align: center;'>
                                            ویرایش تمرین
                                        </div>
                                        <form class='form_new' method='post' action='manager_sport_plan_1.php' style='text-align: left'>
                                            <label for='title'>
                                        تعداد تکرار:
                                            </label>
                                            <input type='text' name='new_repead_sports_$number' id='new_text_sportplan' value='$repead_test' style='margin-left: 130px'>
                                            <br>
                                            <label for='title'>
                                        زمان استراحت:
                                            </label>
                                            <input type='text' name='new_rest_sports_$number' id='new_text_sportplan' value='$rest_test' style='margin-left: 130px'>
                                            <br>
                                            <label for='title'>
                                        زمان برای حرکت:
                                            </label>
                                            <input type='text' name='new_move_sports_$number' id='new_text_sportplan' value='$move_test' style='margin-left: 130px'>
                                            <input type='text' name='new_sports_id_1_$number' id='new_title' style='display: none;' value='$number'>
                                            <input type='text' name='new_sports_id_2_$number' id='new_title' style='display: none;' value='$number_2'>
                                            <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                            <br>
                                            <input type='submit' value='ثبت' style='margin-left: 200px'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            document.getElementById('exit_change_sportplan_$name_element').onclick = function () {
                            document.getElementById('main_student_info').style.opacity =1;
                            document.getElementById('main_student_info').style.filter = 'none';
                            document.getElementById('change_sportplan_$name_element').style.opacity = 0;
                            document.getElementById('change_sportplan_$name_element').style.visibility = 'hidden';
                            document.getElementById('change_sportplan_$name_element').style.zIndex = 2;
                            }   
                            document.getElementById('btn_change_sportplan_$name_element').onclick = function () {
                            document.getElementById('change_sportplan_$name_element').style.opacity = 1;
                            document.getElementById('change_sportplan_$name_element').style.visibility = 'visible';
                            document.getElementById('change_sportplan_$name_element').style.zIndex = 2;
                            }
                            </script>
                        </td>
                    </tr>
                    ";
                }
                $text_t = $text [$number-1];
                echo "
                <tr>
                    <form method='post' action='manager_sport_plan_1.php'>
                        <td style='width: 88%' colspan='4'>
                            <textarea type='text' name='text_sport' id='text_food' maxlength='1000' class='form-control'
                            style='resize: none; width: 100%; height: 150px; margin: 0px; border: none;padding: 7px; line-height: 22px;box-shadow: none'> $text_t </textarea>
                            <input type='text' name='id' value='$id' style='display: none;'>
                            <input type='text' name='number' value='$number' style='display: none;'>
                        </td>
                        <td style='width: 12%'>
                            <input type='submit' value='ذخیره' id='save_text_food_plan'>
                        </td>
                    </form>
                </tr>
                ";
                ?>
            </table>
            <?php
            }
        }
        ?>

        <button id="btn_new_day">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        اضافه کردن روز جدید
        </button>
    </span>

</main>

<div class="change_window" id="new_day">
    <div>
        <div>
            <span id="exit_new_day">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center;">
                اضافه کردن گروه تمرین جدید
            </div>
            <br><br><br>
            <form class="form_new" method="post" action="manager_sport_plan_1.php">
                <label for="new_name_day">
                    عنوان تمرین:
                </label>
                <input type='text' name='new_day' id='new_name_day' required style='margin-left: 70px; margin-top: 0px'>
                <?php
                echo "<input type='text' value='$id' readonly name='id' id='new_title_id' style='display: none'>";
                ?>
                <br>
                <input type="submit" value="ثبت">
            </form>
        </div>
    </div>
</div>
<div class="change_window" id="users_list_show">
    <div>
        <div>
            <span id="exit_users_list">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center; font-size: 15pt">
                لیست شاگردان متصل به برنامه تمرینی
            </div>
            <br><br><br>
            <div>
                <?php
                $temp = 0;
                for ( $i = 0 ; $i < count($users) ; $i++ )
                {

                    if ( $users[$i]['sportplan'] == $id )
                    {
                        $temp++;
                        if ( $temp == 1)
                        {
                            echo $users[$i]['fname']." ".$users[$i]['lname'];
                        }
                        else
                        {
                            echo "، ".$users[$i]['fname']." ".$users[$i]['lname'];
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="remember">
        <form method="post" action="manager_sport_plan_1.php">
            <label for="text">
                یادداشت:
            </label>
            <?php
            $text = give_text( $_COOKIE['id'] , $pdo);
            echo "
                    <textarea type='text' name='text' id='text' maxlength='1000' class='form-control'> $text </textarea>
                    <input type='text' name='id' value='$id' style='display: none'>
                    ";
            ?>

            <input type="submit" value="ذخیره" id="save_remember">
        </form>
    </div>
</footer>
<script src="js/manager_sport_plan.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>





