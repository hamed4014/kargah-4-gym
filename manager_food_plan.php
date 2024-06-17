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
    require ('jdf.php');
    require ('functions.inc');
    $pdo = require_once ('connection.inc');
    require ('manager_header.inc');
    ?>
</header>

<?php
if (isset($_POST['new_title_food_plan']))
{
    $id = create_food_plan( $pdo , $_POST['new_title_food_plan']);
}
else
{
    $id = $_POST['id'];
}

$foodplans =get_foods($pdo);

if (isset($_POST['student_delete']))
{
    delete_food_plan_of_user ( $pdo , $_COOKIE['id'] , $_POST['student_delete']);
}

if (isset ($_POST['user']))
{
    add_user_food_plan ( $pdo , $id , $_POST['user'] );
}

if(isset($_POST['number_delete_group_food']))
{
    delete_foods_of_group_food ( $pdo , $id , $_POST['number_delete_group_food'] , $_POST['delete_foods_id_2'] );
}

if (isset($_POST['number_add']))
{
    add_group_food ( $pdo , $id , $_POST['number_add'] );
}

if ( isset ($_POST['new_level_foodplan']) )
{
    create_new_level_foodplan( $pdo , $_POST['new_level_foodplan'] , $id);
}
if (isset($_POST['new_level_medical']))
{
    create_new_level_medical($pdo , $_POST['new_level_medical'] , $_POST['new_text_medical'] , $id);
}

if (isset($_POST['text_food']))
{
    change_text($_POST['text_food'] , $pdo , $id );
}

if (isset($_POST['number_delete']))
{
    delete_foods_of_food_plans( $pdo , $id , $_POST['number_delete']);
}

if (isset($_POST['number_delete_medical']))
{
    delete_medical_of_food_plan( $pdo , $id , $_POST['number_delete_medical']);
}

$medicals_list = get_medical_supplements($pdo);
$food_plan = give_food_plan( $pdo , $id );

$level_foods_temp = $food_plan ['level_foods'];
$level_foods = array();
if($level_foods_temp != null)
{
    for ( $i = 0 ; $i < strlen($level_foods_temp) ; $i++)
    {
        if ($level_foods_temp[$i] == "{")
        {
            $temp = "";
            while ( true )
            {
                $i++;
                if ($level_foods_temp[$i] == "}")
                {
                    array_push( $level_foods , $temp );
                    break;
                }
                $temp = $temp.$level_foods_temp[$i];

            }
        }
    }
}

for ($i = 1 ; $i <= count($level_foods) ; $i++ )
{
    if(isset($_POST["new_title_$i"]))
    {
        change_title_foodplan ( $pdo , $_COOKIE['id'] , $id , $_POST["new_title_$i"] , $_POST["new_title_id_$i"]);
        $food_plan = give_food_plan( $pdo , $id );
        $level_foods_temp = $food_plan ['level_foods'];
        $level_foods = array();
        if($level_foods_temp != null)
        {
            for ( $i = 0 ; $i < strlen($level_foods_temp) ; $i++)
            {
                if ($level_foods_temp[$i] == "{")
                {
                    $temp = "";
                    while ( true )
                    {
                        $i++;
                        if ($level_foods_temp[$i] == "}")
                        {
                            array_push( $level_foods , $temp );
                            break;
                        }
                        $temp = $temp.$level_foods_temp[$i];

                    }
                }
            }
        }
    }
    if (isset ($_POST["new_foods_id_$i"]))
    {
        add_food( $pdo , $id , $i , $_POST["new_foods_id_$i"] , $_POST["new_foods_$i"] , $_POST["new_text_foods_$i"]);
        $food_plan = give_food_plan( $pdo , $id );
        $level_foods_temp = $food_plan ['level_foods'];
        $level_foods = array();
        if($level_foods_temp != null)
        {
            for ( $i = 0 ; $i < strlen($level_foods_temp) ; $i++)
            {
                if ($level_foods_temp[$i] == "{")
                {
                    $temp = "";
                    while ( true )
                    {
                        $i++;
                        if ($level_foods_temp[$i] == "}")
                        {
                            array_push( $level_foods , $temp );
                            break;
                        }
                        $temp = $temp.$level_foods_temp[$i];

                    }
                }
            }
        }
        break;
    }
}


$foods_temp = $food_plan ['foods'];
$foods = array(array());
$number_1 = 0;
$number_2 = 0;
$temp ="";
for ( $i = 0 ; $i < strlen($foods_temp) ; $i++ )
{
    if ( $foods_temp[$i] == "{" )
    {
        $test = $i;
        while (true)
        {
            $i++;
            if ($foods_temp[$i] == "}")
            {
                if($i == $test+1)
                {
                    $foods[$number_1] = array();
                }
                $number_1++;
                $number_2 = 0;
                break;
            }
            $temp = "";
            if ($foods_temp[$i] == "(")
            {
                $number_2++;
                while (true)
                {
                    $i++;
                    if ($foods_temp[$i] == "[")
                    {
                        $temp_test = "";
                        while (true)
                        {
                            $i++;
                            if ($foods_temp[$i] == ":")
                            {
                                foreach ( $foodplans as $key_food)
                                {
                                    if ($key_food['id'] == $temp_test )
                                    {
                                        $temp = $temp.$key_food['title'];
                                    }
                                }
                                break;
                            }
                            $temp_test = $temp_test.$foods_temp[$i];
                        }
                        $number_test = 0;
                        while (true)
                        {
                            $i++;
                            $number_test++;
                            if ($foods_temp[$i] == "]" && $foods_temp[$i+1] != ")")
                            {
                                if ( $number_test != 1)
                                {
                                    $temp = $temp." )";
                                }
                                $temp = $temp." ، ";
                                break;
                            }
                            else if ($foods_temp[$i] == "]")
                            {
                                if ( $number_test != 1)
                                {
                                    $temp = $temp." )";
                                }
                                break;
                            }
                            else if ($foods_temp[$i] != "]")
                            {
                                if ( $number_test == 1)
                                {
                                    $temp = $temp." ( ";
                                }
                                $temp = $temp.$foods_temp[$i];
                            }
                        }
                    }
                    else if ($foods_temp[$i] == ")")
                    {
                        $foods[$number_1][$number_2] = $temp;
                        break;
                    }
                }
            }
        }
    }
}

$level_medicals_temp = $food_plan ['level_medicals'];
$level_medicals = array();
if($level_medicals_temp != null)
{
    for ( $i = 0 ; $i < strlen($level_medicals_temp) ; $i++)
    {
        if ($level_medicals_temp[$i] == "{")
        {
            $temp = "";
            while ( true )
            {
                $i++;
                if ($level_medicals_temp[$i] == "}")
                {
                    array_push( $level_medicals , $temp );
                    break;
                }
                $temp = $temp.$level_medicals_temp[$i];
            }
        }
    }
}

$medicals_temp = $food_plan ['medicals'];
$medicals = array();
for ( $i = 0 ; $i < strlen($medicals_temp) ; $i++)
{
    if ($medicals_temp[$i] == "{")
    {
        $temp = "";
        while ( true )
        {
            $i++;
            if ($medicals_temp[$i] == "}")
            {
                array_push( $medicals , $temp );
                break;
            }
            $temp = $temp.$medicals_temp[$i];
        }
    }
}

for ( $i = 1 ; $i <= count($level_medicals) ; $i++)
{
    if (isset ($_POST["new_medicals_$i"]))
    {
        change_medical_plan ( $pdo , $_COOKIE['id'] , $id , $_POST["new_medicals_$i"] , $_POST["new_text_medicals_$i"] , $_POST["new_medicals_id_$i"]);
        $food_plan = give_food_plan( $pdo , $id );
        $level_medicals_temp = $food_plan ['level_medicals'];
        $level_medicals = array();
        if($level_medicals_temp != null)
        {
            for ( $i = 0 ; $i < strlen($level_medicals_temp) ; $i++)
            {
                if ($level_medicals_temp[$i] == "{")
                {
                    $temp = "";
                    while ( true )
                    {
                        $i++;
                        if ($level_medicals_temp[$i] == "}")
                        {
                            array_push( $level_medicals , $temp );
                            break;
                        }
                        $temp = $temp.$level_medicals_temp[$i];
                    }
                }
            }
        }

        $medicals_temp = $food_plan ['medicals'];
        $medicals = array();
        for ( $i = 0 ; $i < strlen($medicals_temp) ; $i++)
        {
            if ($medicals_temp[$i] == "{")
            {
                $temp = "";
                while ( true )
                {
                    $i++;
                    if ($medicals_temp[$i] == "}")
                    {
                        array_push( $medicals , $temp );
                        break;
                    }
                    $temp = $temp.$medicals_temp[$i];
                }
            }
        }
    }
}

$users = get_users_info($pdo , $_COOKIE['id']);

?>

<datalist id="foodplans_list">
    <?php
    foreach ( $foodplans as $key )
    {
        $id_temp = $key['id'];
        $foodplan_test = $key['title'];
        echo "
        <option value='$foodplan_test'>$foodplan_test</option>
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

<datalist id="medicals_list">
    <?php
    foreach ( $medicals_list as $key )
    {
        $medicals_test = $key['title'];
        echo "
        <option value='$medicals_test'>$medicals_test</option>
        ";
    }
    ?>
</datalist>

<main id="main_student_info">
    <span style="border: none; box-shadow: none; text-align: right; padding-right: 10px;">
        <form method="post" action="manager_food_plan.php" style="display: inline-block; float: right">
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
            if ( $key['foodplan'] == $id )
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
                    if ( $key['foodplan'] == $id )
                    {
                        $name = $key['fname']." ".$key['lname'];
                        $id_temp = $key['id'];
                        echo "
                        <div>
                            <form method='post' action='manager_food_plan.php' style='float: right; display: inline-block'>
                                $name &nbsp; &nbsp;
                                <input name='student_delete' type='text' value='$id_temp' style='display: none'>
                                <input name='id' type='text' value='$id' style='display: none'>
                                <button type='submit'>
                                    <i class='fa-regular fa-trash-can' style='color: #4d4d4d;'></i>
                                </button>
                            </form>
                            <form method='post' action='print_food.php' style='float: right; display: inline-block'>
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
        echo $food_plan['title'];
        if (count($level_foods) == 0)
        {
            echo "
            <div>
            برنامه طراحی نشده است!
            </div>
            ";
        }
        else
        {
            ?>
            <table>
                <tr>
                    <td style="width: 16%">
                        وعده
                    </td>
                    <td style="width: 71%">
                        برنامه تغذیه
                    </td>
                    <td style="width: 13%">
                        ###
                    </td>
                </tr>
                <?php
                $number = 0;
                foreach ( $level_foods as $key )
                {
                $number++;
                ?>
                    <tr>
                        <td style="width: 16%">
                            <?php
                            echo $key;
                            ?>
                        </td>
                        <td style="width: 71%">
                            <table class='table2'>
                                <?php
                                $number_2 = 0;
                                foreach ( $foods[ $number - 1] as $key_temp )
                                {
                                    $number_2++;
                                    $id_test = $number."_".$number_2;
                                    echo "
                                    <tr style='width: 100%;'>
                                        <td style='width: 86%; height: 30px; text-align: right; padding-right: 10px'>
                                            $key_temp
                                        </td>
                                        <td style='width: 14%; height: 30px; text-align: center;' >
                                            <button class='add' id='btn_add_foodplan_$id_test' style='margin-right: 10%'>
                                               اضافه کردن
                                            </button>
                                            <form method='post' action='manager_food_plan.php'>
                                                <input type='text' value = '$id' readonly name='id' id='id_delete' style='display: none'>
                                                <input type='text' value = '$number' readonly name='number_delete_group_food' id='number_delete' style='display: none'>
                                                <input type='text' name='delete_foods_id_2' id='new_title' style='display: none;' value='$number_2'>
                                                <input type='submit' class='delete' value='حذف'>
                                            </form>
                                            
                                            <div class='change_window' id='add_foodplan_$id_test'>
                                                <div style='height: 300px'>
                                                    <div>
                                                        <span id='exit_add_foodplan_$id_test'>
                                                            <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                                        </span>
                                                        <div style='text-align: center;'>
                                                            اضافه کردن ماده غذایی
                                                        </div>
                                                        <form class='form_new' method='post' action='manager_food_plan.php'>
                                                            <label for='title'>
                                                        عنوان:
                                                            </label>
                                                            <input list='foodplans_list' placeholder='جست و جو' name='new_foods_$number' id='new_foods'>
                                                            <br>
                                                            <label for='title'>
                                                        توضیحات:
                                                            </label>
                                                            <input type='text' name='new_text_foods_$number' id='new_text_foodplan'>
                                                            <input type='text' name='new_foods_id_$number' id='new_title' style='display: none;' value='$number'>
                                                            <input type='text' name='new_foods_id_$number' id='new_title' style='display: none;' value='$number_2'>
                                                            <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                                            <br>
                                                            <input type='submit' value='ثبت'>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                            document.getElementById('exit_add_foodplan_$id_test').onclick = function () {
                                            document.getElementById('main_student_info').style.opacity =1;
                                            document.getElementById('main_student_info').style.filter = 'none';
                                            document.getElementById('add_foodplan_$id_test').style.opacity = 0;
                                            document.getElementById('add_foodplan_$id_test').style.visibility = 'hidden';
                                            document.getElementById('add_foodplan_$id_test').style.zIndex = 2;
                                            }   
                                            document.getElementById('btn_add_foodplan_$id_test').onclick = function () {
                                            document.getElementById('add_foodplan_$id_test').style.opacity = 1;
                                            document.getElementById('add_foodplan_$id_test').style.visibility = 'visible';
                                            document.getElementById('add_foodplan_$id_test').style.zIndex = 2;
                                            }
                                            
                                            
                                            </script>
                                        </td>
                                    </tr>
                                    ";
                                }
                                ?>
                            </table>
                        </td>
                        <?php
                        echo "
                        <td style='width: 13%'>
                            <form method='post' action='manager_food_plan.php'>
                                <input type='text' value = '$id' readonly name='id' id='id_delete' style='display: none'>
                                <input type='text' value = '$number' readonly name='number_delete' id='number_delete' style='display: none'>
                                <input type='submit' class='delete' value='حذف' style='margin-right: 5px; margin-left: 5px'>
                            </form>
                            <button class='change' id='btn_change_foodplan_$number' style='margin-right: 0px; margin-left: 5px; height: 30px'>
                               ویرایش
                            </button>
                            <form method='post' action='manager_food_plan.php'>
                                <input type='text' value = '$id' readonly name='id' id='id_add' style='display: none'>
                                <input type='text' value = '$number' readonly name='number_add' id='number_delete' style='display: none'>
                                <input type='submit' class='add' value='اضافه کردن'>
                            </form>
                            <div class='change_window' id='change_foodplan_$number'>
                                <div style='height: 300px'>
                                    <div>
                                        <span id='exit_change_foodplan_$number'>
                                            <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                        </span>
                                        <div style='text-align: center;'>
                                            ویرایش برنامه غذایی
                                        </div>
                                        <form class='form_new' method='post' action='manager_food_plan.php'>
                                            <label for='title'>
                                        عنوان:
                                            </label>
                                            <input type='text' name='new_title_$number' id='new_foods'>
                                            <br>
                                            <input type='text' name='new_title_id_$number' id='new_title' style='display: none;' value='$number'>
                                            <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                            <br>
                                            <input type='submit' value='ثبت'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            document.getElementById('exit_change_foodplan_$number').onclick = function () {
                            document.getElementById('main_student_info').style.opacity =1;
                            document.getElementById('main_student_info').style.filter = 'none';
                            document.getElementById('change_foodplan_$number').style.opacity = 0;
                            document.getElementById('change_foodplan_$number').style.visibility = 'hidden';
                            document.getElementById('change_foodplan_$number').style.zIndex = 2;
                            }   
                            document.getElementById('btn_change_foodplan_$number').onclick = function () {
                            document.getElementById('change_foodplan_$number').style.opacity = 1;
                            document.getElementById('change_foodplan_$number').style.visibility = 'visible';
                            document.getElementById('change_foodplan_$number').style.zIndex = 2;
                            }
                            </script>
                        </td>
                    </tr>
                    ";
                        }

                        ?>
            </table>
            <?php
        }
        ?>

        <button id="btn_new_food_plan">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        اضافه کردن وعده غذایی
        </button>
    </span>

    <?php
    if (count($level_medicals) == 0)
    {
        echo "
            <button id='btn_new_medical'>
            <i class='fa-solid fa-plus fa-sm' style='color: #ffffff;'></i>
            اضافه کردن داروی مکمل
            </button>
            ";
    }
    else
    {
        ?>
        <span>
        دارو های مکمل
            <table>
                <tr>
                    <td>
                        نام دارو
                    </td>
                    <td>
                        توضیحات
                    </td>
                    <td>
                        ###
                    </td>
                </tr>
                <?php
                $number = 0;
                for ( $i = 0 ; $i < count($level_medicals) ; $i++)
                {
                $number++;
                ?>
                    <tr>
                        <td>
                            <?php
                            echo $level_medicals[$i];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $medicals[$i];
                            ?>
                        </td>
                        <?php
                        echo "
                        <td>
                            <form method='post' action='manager_food_plan.php'>
                                <input type='text' value = '$id' readonly name='id' id='id_delete_medical' style='display: none'>
                                <input type='text' value = '$number' readonly name='number_delete_medical' id='number_delete_medical' style='display: none'>
                                <input type='submit' class='delete' value='حذف'>
                            </form>
                            <button class='change' id='btn_change_medical_$number' style='margin-right: 0px; margin-left: 5px; height: 30px'>
                               ویرایش
                            </button>
                            
                            <div class='change_window' id='change_medical_$number'>
                                <div style='height: 300px'>
                                    <div>
                                        <span id='exit_change_medical_$number'>
                                            <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                        </span>
                                        <div style='text-align: center;'>
                                            ویرایش دارو مکمل
                                        </div>
                                        <form class='form_new' method='post' action='manager_food_plan.php'>
                                            <label for='title'>
                                        عنوان:
                                            </label>
                                            <input list='medicals_list' placeholder='جست و جو' name='new_medicals_$number' id='new_medicals_$number' value='$level_medicals[$i]'>
                                            <br>
                                            <label for='title'>
                                        توضیحات:
                                            </label>
                                            <input type='text' name='new_text_medicals_$number' id='new_text_medicalplan' value='$medicals[$i]'>
                                            <input type='text' name='new_medicals_id_$number' id='new_title' style='display: none;' value='$number'>
                                            <input type='text' name='id' id='id_$number' style='display: none;' value='$id'>
                                            <br>
                                            <input type='submit' value='ثبت'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                            document.getElementById('exit_change_medical_$number').onclick = function () {
                            document.getElementById('main_student_info').style.opacity =1;
                            document.getElementById('main_student_info').style.filter = 'none';
                            document.getElementById('change_medical_$number').style.opacity = 0;
                            document.getElementById('change_medical_$number').style.visibility = 'hidden';
                            document.getElementById('change_medical_$number').style.zIndex = 2;
                            }   
                            document.getElementById('btn_change_medical_$number').onclick = function () {
                            document.getElementById('change_medical_$number').style.opacity = 1;
                            document.getElementById('change_medical_$number').style.visibility = 'visible';
                            document.getElementById('change_medical_$number').style.zIndex = 2;
                            }
                            
                            
                            </script>
                        </td>
                        
                    </tr>
                    ";
                        }

                        ?>
            </table>
            <?php
            ?>

        <button id="btn_new_medical">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        اضافه کردن داروی مکمل
        </button>
    </span>



        <?php
    }
    ?>
    <form method="post" action="manager_food_plan.php" style="margin-bottom: 30px; text-align: center;font-family: 'B Titr'">
        <label style="font-family: 'B Titr'">توضیحات:</label>
        <?php
        $text = $food_plan ['text'];
        echo "
            <textarea type='text' name='text_food' id='text_food' maxlength='1000' class='form-control' 
            style='resize: none; width: 95%; height: 150px; margin-top: 10px; margin-left: auto; margin-right: auto;padding: 7px; line-height: 22px;'> $text </textarea>
            <input type='text' name='id' value='$id' style='display: none;'>
            ";
        ?>
        <input type="submit" value="ذخیره" id="save_text_food_plan">
    </form>


</main>

<div class="change_window" id="new_food_plan">
    <div>
        <div>
            <span id="exit_new_food_plan">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center;">
                اضافه کردن وعده غذایی
            </div>
            <form class="form_new" method="post" action="manager_food_plan.php">
                <label for="new_title_foodplan">
                    عنوان وعده:
                </label>
                <input type="text" maxlength="200" name="new_level_foodplan" id="new_level_foodplan">
                <?php
                echo "<input type='text' value='$id' readonly name='id' id='new_level_id' style='display: none'>";
                ?>
                <br>
                <input type="submit" value="ثبت">
            </form>
        </div>
    </div>
</div>

<div class="change_window" id="new_medical_plan">
    <div style="height: 300px">
        <div>
            <span id="exit_new_medical_plan">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center;">
                اضافه کردن دارو مکمل
            </div>
            <form class="form_new" method="post" action="manager_food_plan.php">
                <label for="new_title_medical">
                    عنوان دارو:
                </label>
                <input list="medicals_list" name="new_level_medical" id="new_title_medical">
                <br>
                <label for="new_text_medical">
                    توضیحات:
                </label>
                <input type="text" maxlength="200" name="new_text_medical" id="new_text_medical">
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
                لیست شاگردان متصل به برنامه غذایی
            </div>
            <br><br><br>
            <div>
                <?php
                $temp = 0;
                for ( $i = 0 ; $i < count($users) ; $i++ )
                {

                    if ( $users[$i]['foodplan'] == $id )
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
        <form method="post" action="manager_food_plan.php">
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
<script>
    window.onload = e = => {
        const scrollTop = localStorage.getItem('scrollTop');
        document.body.scrollTop = scrollTop;
    }
    window.onscroll = e => localStorage.setItem('scrollTop' , document.body.scrollTop);

</script>
<script src="js/manager_food_plan.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>




