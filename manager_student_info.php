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
    require ('jdf.php');
    $id = $_POST['id'];

for ($i = 1; $i <= 4 ; $i++)
{
    if (isset($_FILES["image_img_$i"]))
    {
        save_images ( $pdo , $id , $_COOKIE['id'] , $_FILES["image_img_$i"]);
    }
}


if ( isset ($_POST['fname']) )
{
    echo "1";
    if ( $_POST['day'] < 10 )
    {
        $day = "0".(string)$_POST['day'];
    }
    else{
        $day = (string)$_POST['day'];
    }
    if ( $_POST['month'] < 10 )
    {
        $month = "0".(string)$_POST['month'];
    }
    else{
        $month = (string)$_POST['month'];
    }
    $year = (string)$_POST['year'];
    $date = $day.$month.$year;
    $user = [
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'phone' => $_POST['phone'],
        'birthday' => $date ,
        'gender' => $_POST['gender'],
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'injury' => $_POST['injury'],
        'target' => $_POST['target'],
        'history' => $_POST['history']];

    if ( check_user_text($user) )
    {
        $risult = change_info_user($pdo , $user , $id);
        if ( isset($_FILES['image1']))
        {
            $id_user = $id;
            $file = $_FILES['image1']['tmp_name'];
            $file_name = "user_".$_COOKIE['id']."_".$id_user."_1".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
            echo "2";
        }
        if ( isset($_FILES['image2']))
        {
            $id_user = $id;
            $file = $_FILES['image2']['tmp_name'];
            $file_name = "user_".$_COOKIE['id']."_".$id_user."_2".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
        }
        if ( isset($_FILES['image3']))
        {
            $id_user = $id;
            $file = $_FILES['image3']['tmp_name'];
            $file_name = "user_".$_COOKIE['id']."_".$id_user."_3".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
        }
        if ( isset($_FILES['image4']))
        {
            $id_user = $id;
            $file = $_FILES['image4']['tmp_name'];
            $file_name = "user_".$_COOKIE['id']."_".$id_user."_4".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
        }
        if ( isset($_FILES['image5']))
        {
            $id_user = $id;
            $file = $_FILES['image5']['tmp_name'];
            $file_name = "user_".$_COOKIE['id']."_".$id_user."_5".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
        }
        if ($risult)
        {
            echo "<div class='massage' id='massage'>ویرایش اطلاعات با موفقیت انجام شد.</div>";
        }
        else
        {

        }
    }
    else
    {

    }
}


    $foodplans =get_foods($pdo);
    $sports = get_sports($pdo);
    $medicals = get_medical_supplements($pdo);

    $title_food_plans = give_title_food_plans ($pdo);
    $title_sport_plans = give_title_sport_plans ($pdo);
    $user = get_user_info_full ( $pdo , $id );

    $fname = $user['fname'];
    $lname = $user['lname'];
    $phone = $user['phone'];
    $weight = $user['weight'];
    $height = $user['height'];
    $birthday = $user['birthday'];
    $birthday = substr($birthday , 0 , 2)." / ".substr($birthday , 2 , 2)." / ".substr($birthday , 4 , 4);
    $gender = $user['gender'];
    if ($gender == "male")
    {
        $gender = "مرد";
    }
    else if ($gender == "female")
    {
        $gender = "زن";
    }
    $injury = $user['injury'];
    $history = $user['history'];
    $target = $user['target'];
    $foodplan_id = $user['foodplan'];
    $history_foodplan = $user['history_foodplan'];
    $sportplan_id = $user['sportplan'];
    $history_sportplan = $user['history_sportplan'];
    $image = $user['image'];
    $history_image = $user['history_image'];

    $history_image_t = $history_image;
    $history_image = array();
    for ( $i = 0 ; $i < strlen($history_image_t) ; $i++)
    {
        if ( $history_image_t[$i] == "[")
        {
            $temp = 0;
            while (true)
            {
                $i++;
                if ($history_image_t[$i] == "]")
                {
                    array_push( $history_image , $temp );
                    break;
                }
                $temp = $temp.$history_image_t[$i];
            }
        }

    }

    $day = array();
    if ( $sportplan_id != null )
    {
        $sport_plan = give_sport_plan ($pdo , $sportplan_id);
        if ($sport_plan['type'] == "1")
        {
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
            $sportplans_temp = $sport_plan ['sports'];
            $sportplans = array(array());
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
        }
        else
        {
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
                            if ($day_temp[$i] == "}")
                            {
                                array_push( $day , $temp );
                                break;
                            }
                            $temp = $temp.$day_temp[$i];

                        }
                    }
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
                            $sportplans[$number_1][$number_2]['title'] = "";
                            $titles = array();
                            while (true)
                            {
                                $i++;
                                if ($sportplans_temp[$i] == ":")
                                {
                                    for ($j = 0 ; $j < count($titles) ; $j++)
                                    {
                                        $sportplans[$number_1][$number_2]['title'] = $sportplans[$number_1][$number_2]['title'].$titles[$j];
                                        if ( $j != count($titles) - 1)
                                        {
                                            $sportplans[$number_1][$number_2]['title'] = $sportplans[$number_1][$number_2]['title']."+ ";
                                        }
                                    }
                                    if (count($titles) == 0)
                                    {
                                        $sportplans[$number_1][$number_2]['title'] = "";
                                    }
                                    break;
                                }
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
                                                    array_push( $titles , $key['title'] );
                                                }
                                            }
                                            break;
                                        }
                                        $temp = $temp.$sportplans_temp[$i];
                                    }
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
                                if ($sportplans_temp[$i] == ")")
                                {
                                    $sportplans[$number_1][$number_2]['text'] = $temp;
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
        }
    }

if ( $foodplan_id != null )
{
    $food_plan = give_food_plan ($pdo , $foodplan_id);
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

    $medicalplans_temp = $food_plan ['medicals'];
    $medicalplans = array();
    for ( $i = 0 ; $i < strlen($medicalplans_temp) ; $i++)
    {
        if ($medicalplans_temp[$i] == "{")
        {
            $temp = "";
            while ( true )
            {
                $i++;
                if ($medicalplans_temp[$i] == "}")
                {
                    array_push( $medicalplans , $temp );
                    break;
                }
                $temp = $temp.$medicalplans_temp[$i];
            }
        }
    }
}
?>


<datalist id="food_plans_list">
    <?php
    foreach ( $title_food_plans as $key )
    {
        $temp = $key;
        echo "
        <option value='$temp'>$temp</option>
        ";
    }
    ?>
</datalist>

<datalist id="sport_plans_list">
    <?php
    foreach ( $title_sport_plans as $key )
    {
        $temp = $key;
        echo "
        <option value='$temp'>$temp</option>
        ";
    }
    ?>
</datalist>

<main id="main_student_info">
    <div>
        <?php
        $number_day = count($day);
        echo "
        نام:
        &nbsp;
        $fname
        <br>
        شماره همراه:
        &nbsp;
        $phone
        <br>
        قد:
        &nbsp;
        $height
        ";
        ?>
    </div>
    <div>
        <?php
        echo "
        نام خانوادگی:
        &nbsp;
        $lname
        <br>
        جنسیت:
        &nbsp;
        $gender
        <br>
        وزن:
        &nbsp;
        $weight
        "
        ?>
    </div>
    <div>
        <?php
        echo "
        تاریخ تولد:
        &nbsp;
        $birthday
        <br>
        تعداد روز های تمرین در هفته:
        &nbsp;
        $number_day
        <br>
        ";
        ?>

    </div>
    <section style="line-height: 30px">
        <?php
            $file_name = "user_".$_COOKIE['id']."_".$id."_1".".jpg";
            if (file_exists("image/$file_name"))
            {
                echo "
                <img src='image/$file_name' class='image_info_user'>
                <br>
                ID:
                &nbsp;
                $id
                <br>
                <button id='btn_change_user' style='margin-right: 0px'>
                    ویرایش اطلاعات
                </button>
                <button id='btn_images' style='margin-right: 0px'>
                    تصاویر
                </button>
                ";
            }
            else
            {
                echo "
                <i class='fa-solid fa-circle-user' style='color: #000000;'></i>
                <br>
                ID:
                &nbsp;
                $id
                <br>
                <button id='btn_change_user' style='margin-right: 0px'>
                    ویرایش اطلاعات
                </button>
                <button id='btn_images' style='margin-right: 0px; margin-top: 5px'>
                    تصاویر
                </button>
                ";
            }
        ?>

    </section>
    <div id="text">
        <div>
            هدف:
            <section>
                <?php
                echo "$target";
                ?>
            </section>
        </div>
        <div>
            مصدومیت:
            <section>
                <?php
                echo "$injury";
                ?>
            </section>
        </div>
        <div>
            سابقه تمرین:
            <section>
                <?php
                echo "$history";
                ?>
            </section>
        </div>
    </div>
    <?php
    $file_name2 = "user_".$_COOKIE['id']."_".$id."_2".".jpg";
    $file_name3 = "user_".$_COOKIE['id']."_".$id."_3".".jpg";
    $file_name4 = "user_".$_COOKIE['id']."_".$id."_4".".jpg";
    $file_name5 = "user_".$_COOKIE['id']."_".$id."_5".".jpg";
    if (file_exists("image/$file_name2")
    || file_exists("image/$file_name3")
    || file_exists("image/$file_name4")
    || file_exists("image/$file_name5"))
    {
        ?>
        <div style='width: 100%'>
            <?php
            if (file_exists("image/$file_name2"))
            {
                echo "
                <img src='image/$file_name2' class='image_user'>
                ";
            }
            if (file_exists("image/$file_name3"))
            {
                echo "
                <img src='image/$file_name3' class='image_user'>
                ";
            }
            if (file_exists("image/$file_name4"))
            {
                echo "
                <img src='image/$file_name4' class='image_user'>
                ";
            }
            if (file_exists("image/$file_name5"))
            {
                echo "
                <img src='image/$file_name5' class='image_user'>
                ";
            }
            ?>
        </div>
        <?php
    }
    if (file_exists("image/$file_name2")
    || file_exists("image/$file_name3")
    || file_exists("image/$file_name4")
    || file_exists("image/$file_name5"))
    {
        echo "<span style='margin-top: 210px'>";
    }
    else
    {
        echo "<span>";
    }
    ?>
        برنامه ورزشی
        <?php
        if ($sportplan_id == null)
        {
            echo "
            <div>
            برنامه ای تعریف نشده است!
            </div>
            ";

        }
        else
        {
            echo "<br>
            تاریخ ثبت: $history_sportplan";
            if ($sport_plan['type'] == "1")
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
                        <td style='width: 22%'>
                            تمرین
                        </td>
                        <td style='width: 26%'>
                            تعداد تکرار و مقدار ست
                        </td>
                        <td style='width: 26%'>
                            زمان استراحت بین ست ها
                        </td>
                        <td style='width: 26%'>
                            زمان برای حرکت
                        </td>
                    </tr>
                    ";
                    $number_2 = 0;
                    foreach ( $sportplans[ $number - 1] as $key_temp )
                    {
                        $number_2++;
                        $title_test = $key_temp['title'];
                        $repead_test = $key_temp['repead'];
                        $rest_test = $key_temp['rest'];
                        $move_test = $key_temp['move'];
                        foreach ($sports as $key_sport) {
                            if ($key_sport['id'] == $title_test) {
                                $title_test = $key_sport['title'];
                            }
                        }
                        echo "
                        <tr style='width: 100%;'>
                            <td style='width: 22%; height: 30px; text-align: right; padding-right: 10px'>
                                ";
                        $number3 = 0;
                        foreach ( $key_temp['title'] as $key_test)
                        {
                            $number3++;
                            if ($number3 == 1)
                            {
                                echo $key_test;
                            }
                            else
                            {
                                echo " + ".$key_test;
                            }
                        }
                        echo "
                            </td>
                            <td  style='width: 26%; height: 30px; text-align: right; padding-right: 10px'>
                                $repead_test
                            </td>
                            <td  style='width: 26%; height: 30px; text-align: right; padding-right: 10px'>
                                $rest_test
                            </td>
                            <td  style='width: 26%; height: 30px; text-align: right; padding-right: 10px'>
                                $move_test
                            </td>
                        </tr>
                        ";
                    }
                    $text_t = $text [$number-1];
                    echo "
                    <tr>
                        <form method='post' action='manager_sport_plan_1.php' >
                            <td style='width: 100%' colspan='4'>
                                <textarea type='text' name='text_sport' readonly id='text_food' maxlength='1000' class='form-control'
                                style='resize: none; width: 100%; height: 150px; margin: 0px; border: none;padding: 7px; line-height: 22px;box-shadow: none'> $text_t </textarea>
                            </td>
                        </form>
                    </tr>
                    </table>
                    ";
                }
                echo "
                <hr>
                <form method='post' action='print_sport1.php'>
                    <input type='text' name='id' value='$id' style='display: none'>
                    <button class='print'>
                    چاپ
                    </button>
                </form>
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
                    <td style='width: 36%'>
                        تمرین
                    </td>
                    <td style='width: 32%'>
                        تعدادست، تکرار، زمان اجرا
                    </td>
                    <td style='width: 32%'>
                        توضیحات
                    </td>
                </tr>
                ";
                    $number_2 = 0;
                    foreach ( $sportplans[ $number - 1] as $key_temp )
                    {
                        $number_2++;
                        $title_test = $key_temp['title'];
                        $repead_test = $key_temp['repead'];
                        $text_test = $key_temp['text'];
                        foreach ($sports as $key_sport) {
                            if ($key_sport['id'] == $title_test) {
                                $title_test = $key_sport['title'];
                            }
                        }
                        echo "
                    <tr style='width: 100%;'>
                        <td style='width: 36%; height: 30px; text-align: right; padding-right: 10px'>
                            $title_test
                        </td>
                        <td  style='width: 32%; height: 30px; text-align: right; padding-right: 10px'>
                            $repead_test
                        </td>
                        <td  style='width: 32%; height: 30px; text-align: right; padding-right: 10px'>
                            $text_test
                        </td>
                    </tr>
                    ";
                    }
                    ?>
                    </table>
                    <?php
                }
                echo "
                <hr>
                <form method='post' action='print_sport2.php'>
                    <input type='text' name='id' value='$id' style='display: none'>
                    <button class='print'>
                    چاپ
                    </button>
                </form>
                ";
            }

        }
        ?>
    </span>

    <span>
        برنامه غذایی
        <?php
        if ($foodplan_id == null)
        {
            echo "
            <div>
            برنامه ای تعریف نشده است!
            </div>
            ";
        }
        else
        {
            echo "<br>
            تاریخ ثبت: $history_foodplan";
            ?>
            <table>
                <tr>
                    <td style="width: 21%">
                        وعده
                    </td>
                    <td style="width: 79%">
                        برنامه تغذیه
                    </td>
                </tr>
                <?php
                $number = 0;
                foreach ( $level_foods as $key )
                {
                $number++;
                ?>
                    <tr>
                        <td style="width: 21%">
                            <?php
                            echo $key;
                            ?>
                        </td style="width: 79%">
                        <td>
                            <table class='table2'>
                                <?php
                                $number_2 = 0;
                                foreach ( $foods[ $number - 1] as $key_temp )
                                {
                                    $number_2++;
                                    $id_test = $number."_".$number_2;
                                    echo "
                                    <tr style='width: 100%;'>
                                        <td style='width: 100%; height: 30px; text-align: right; padding-right: 10px'>
                                            $key_temp
                                        </td>
                                    </tr>
                                    ";
                                }
                                ?>
                            </table>
                        </td>
                        <?php
                        echo "
                    </tr>
                    ";
                        }
                        ?>
            </table>
            <?php

                }
    if ($foodplan_id == null)
        {

        }
    else
        {
    ?>
        دارو های مکمل
            <table>
                <tr>
                    <td>
                        نام دارو
                    </td>
                    <td>
                        توضیحات
                    </td>
                </tr>
                <?php
                $number = 0;
                for ( $i = 0 ; $i < count($level_medicals) ; $i++)
                {
                    $number++;
                ?>
                    <tr>
                        <td style="width: 20%">
                            <?php
                            echo $level_medicals[$i];
                            ?>
                        </td>
                        <td style="width: 80%">
                            <?php
                            echo $medicalplans[$i];
                            ?>
                        </td>
                        <?php
                        echo "
                    </tr>
                    ";
                        }

                        ?>
            </table>
            <?php
            if ( $foodplan_id != null)
            {
                $text = $food_plan ['text'];
                echo "
                <form method='post' style='margin-bottom: 30px; text-align: center;'>
                    <label>توضیحات:</label>
                    <textarea type='text' name='text_sport' readonly id='text_food' maxlength='1000' class='form-control' 
                    style='resize: none; width: 95%; height: 150px; margin-top: 10px; margin-left: auto; margin-right: auto;padding: 7px; line-height: 22px;'> $text </textarea>
                </form>
                ";
            }
            echo "
            <hr>
            <form method='post' action='print_food.php'>
                <input type='text' name='id' value='$id' style='display: none'>
                <button class='print'>
                چاپ
                </button>
            </form>
            
            ";
        ?>
    </span>
    <?php

        }

    ?>


</main>

<?php
require ('change_info_user.inc');
?>

<div class="change_window" id="images">
    <div style="height: 600px; width: 1400px; overflow-y: scroll;">
        <div>
            <span id="exit_images">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>
            <span id="add_images" style="top: 5px; left: 150px; right: auto; width: 150px; height: 30px">
                <button id="btn_add_image">
                    اضافه کردن تصویر
                </button>
            </span>

            <div style="text-align: center;">
                تصاویر
            </div>
            <br>
            <hr>

            <?php
            for ($i = 0 ; $i < (integer)$image ; $i++)
            {
                $name = "user_".$_COOKIE['id']."_".$id."_".$i."img".".jpg";
                $test = substr( $history_image[$i] , 1);
                echo "
                <section style='height: 420px; width: 300px; margin-right: 1%; margin-bottom: 20px; text-align: center; float: right; display: inline-block'>
                    <img src='image/$name' style='height: 400px; width: 99%'>
                    <br>
                    $test
                </section>
                ";
            }
            ?>



        </div>
    </div>
</div>

<div class="change_window" id="add_image">
    <div style="height: 230px; text-align: center">
        <div>
            <span id="exit_add_image">
                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
            </span>

            <div style="text-align: center;">
                اضافه کردن تصویر
            </div>
            <form class="form" method="post" action="manager_student_info.php" enctype="multipart/form-data">
                <div>
                    <div>
                        عکس 1:
                    </div>
                    <div>
                        <input type="file" name="image_img_1" id="image1" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 2:
                    </div>
                    <div>
                        <input type="file" name="image_img_2" id="image2" class="form-control">
                    </div>
                </div>
                <br>
                <div>
                    <div>
                        عکس 3:
                    </div>
                    <div>
                        <input type="file" name="image_img_3" id="image3" class="form-control">
                    </div>
                </div>
                <div>
                    <div>
                        عکس 4:
                    </div>
                    <div>
                        <input type="file" name="image_img_4" id="image4" class="form-control">
                    </div>
                </div>
                <br>
                <?php
                echo "<input type='text' name='id' style='display: none;' value='$id'>";
                ?>
                <input type="submit" value="ثبت" class="form-control btn_ok" style="margin-top: 90px">
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="remember">
        <form method="post" action="manager_student_info.php">
            <label for="text">
                یادداشت:
            </label>
            <?php
            $text = give_text( $_COOKIE['id'] , $pdo);
            echo "
                    <textarea type='text' name='text' id='text' maxlength='1000' class='form-control'> $text </textarea>
                    <input type='text' style='display: none' value='$id' name='id'>
                    ";
            ?>

            <input type="submit" value="ذخیره" id="save_remember">
        </form>
    </div>
</footer>
<script>
    document.getElementById("btn_images").onclick = function () {
        document.getElementById("main_student_info").style.opacity = 0.4;
        document.getElementById("main_student_info").style.filter = "blur(4px)";
        document.getElementById("images").style.zIndex = 200;
        document.getElementById("images").style.opacity = 1;
        document.getElementById("images").style.visibility = "visible";
    }

    document.getElementById("exit_images").onclick = function () {
        document.getElementById("main_student_info").style.opacity =1;
        document.getElementById("main_student_info").style.filter = "none";
        document.getElementById("images").style.opacity = 0;
        document.getElementById("images").style.visibility = "hidden";
        document.getElementById("images").style.zIndex = 1;
    }

    document.getElementById("btn_add_image").onclick = function () {
        document.getElementById("main_student_info").style.opacity = 0.4;
        document.getElementById("main_student_info").style.filter = "blur(4px)";
        document.getElementById("add_image").style.zIndex = 200;
        document.getElementById("add_image").style.opacity = 1;
        document.getElementById("add_image").style.visibility = "visible";
        document.getElementById("images").style.opacity = 0;
        document.getElementById("images").style.visibility = "hidden";
        document.getElementById("images").style.zIndex = 1;
    }

    document.getElementById("exit_add_image").onclick = function () {
        document.getElementById("main_student_info").style.opacity =1;
        document.getElementById("main_student_info").style.filter = "none";
        document.getElementById("add_image").style.opacity = 0;
        document.getElementById("add_image").style.visibility = "hidden";
        document.getElementById("add_image").style.zIndex = 1;
    }
</script>
<script src="js/manager_student_info.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>



