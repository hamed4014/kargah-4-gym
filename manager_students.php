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
    <link href="css/manager.css" type="text/css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">
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
if ( isset ($_POST['fname']) )
    {
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
            $id = $_COOKIE ['id'];
            $risult = save_info_user($pdo , $user , $id);
            if ( isset($_FILES['image1']))
            {
                $id_user = give_id_user($pdo , $_COOKIE['id']);
                $file = $_FILES['image1']['tmp_name'];
                $file_name = "user_".$_COOKIE['id']."_".$id_user."_1".".jpg";
                move_uploaded_file( $file, "image/".$file_name );
            }
            if ( isset($_FILES['image2']))
            {
                $id_user = give_id_user($pdo , $_COOKIE['id']);
                $file = $_FILES['image2']['tmp_name'];
                $file_name = "user_".$_COOKIE['id']."_".$id_user."_2".".jpg";
                move_uploaded_file( $file, "image/".$file_name );
            }
            if ( isset($_FILES['image3']))
            {
                $id_user = give_id_user($pdo , $_COOKIE['id']);
                $file = $_FILES['image3']['tmp_name'];
                $file_name = "user_".$_COOKIE['id']."_".$id_user."_3".".jpg";
                move_uploaded_file( $file, "image/".$file_name );
            }
            if ( isset($_FILES['image4']))
            {
                $id_user = give_id_user($pdo , $_COOKIE['id']);
                $file = $_FILES['image4']['tmp_name'];
                $file_name = "user_".$_COOKIE['id']."_".$id_user."_4".".jpg";
                move_uploaded_file( $file, "image/".$file_name );
            }
            if ( isset($_FILES['image5']))
            {
                $id_user = give_id_user($pdo , $_COOKIE['id']);
                $file = $_FILES['image5']['tmp_name'];
                $file_name = "user_".$_COOKIE['id']."_".$id_user."_5".".jpg";
                move_uploaded_file( $file, "image/".$file_name );
            }
            if ($risult)
            {
                echo "<div class='massage' id='massage'>ثبت نام شما با موفقیت انجام شد.</div>";
            }
            else
            {

            }
        }
        else
        {

        }
    }
$users = get_users_info($pdo , $_COOKIE['id']);

?>

<datalist id="info_list">
    <?php
    foreach ( $users as $key )
    {
        $fname = $key['fname'];
        $lname = $key['lname'];
        $name = $fname." ".$lname;
        echo "
        <option value='$fname'>$fname</option>
        <option value='$lname'>$lname</option>
        <option value='$name'>$name</option>
        
        ";
    }
    ?>
</datalist>

<?php
if ( isset($_GET['search']) )
{
    $users = search_users( $_GET['search'] , $users );
}
?>
<main id="main_students">

    <div class="search">
        <form method="get" action="manager_students.php">
            <input list="info_list" id="search" name="search" class="form-control" placeholder="جست وجو">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>

    </div>
    <section style="height: 40px; display: inline-block; float: right; width: 500px; margin-top: 20px"></section>
    <button id="btn_new_user" style="margin-right: 0px">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        ثبت نام شاگرد جدید
    </button>
    <?php
    if ( count($users) != 0 )
    {
        echo "<hr>";
    }
    foreach ($users as $key)
    {
        $id = $key['id'];
        $fname = $key['fname'];
        $lname = $key['lname'];
        $phone = $key['phone'];
        $weight = $key['weight'];
        $height = $key['height'];
        $birthday = $key['birthday'];
        $birthday = substr($birthday , 4 , 7);
        $birthday = (int) $birthday;
        $date = jdate('Y' , time() , '' , 'Asia/Tehran' , 'en');
        $date = (integer) $date;
        $old = $date - $birthday;
        $name = $fname." ".$lname;
        $file_name = "user_".$_COOKIE['id']."_".$id."_1".".jpg";
        if(file_exists("image/$file_name"))
        {
            echo "
            <div style='position: relative;'>
                <div>
                    <img src='image/$file_name' class='image_user_list'>
                </div>
                <span>$name</span>
                <span>$phone</span>
                <span>سن: &nbsp;$old سال</span>
                <span>وزن:&nbsp;$weight</span>
                <span>قد:&nbsp;$height</span>
                <form method='post' action='manager_student_info.php'>
                    <input type='number' value='$id' readonly style='width: 0px; height: 0px; display: none' name='id' >
                    <input type='submit' style='opacity: 0;height: 100%; width: 100%; position: absolute; top: 0px;right: 0px'>
                </form>
            </div>
            ";
        }
        else
        {
            echo "
            <div style='position: relative; display: inline-block'>
                <div>
                    <i class='fa-solid fa-circle-user fa-xl' style='color: #000000;'></i>
                </div>
                <span>$name</span>
                <span>$phone</span>
                <span>سن: &nbsp;$old سال</span>
                <span>وزن:&nbsp;$weight</span>
                <span>قد:&nbsp;$height</span>
                <form method='post' action='manager_student_info.php'>
                    <input type='number' value='$id' readonly style='width: 0px; height: 0px; display: none' name='id' >
                    <input type='submit' style='opacity: 0;height: 100%; width: 100%; position: absolute; top: 0px;right: 0px'>
                </form>
            </div>
            ";
        }
    }
    ?>

</main>

<?php
require ('signin_user.inc');
?>

<footer>
    <div class="remember">
        <form method="post" action="manager_students.php">
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

<script src="js/manager_students.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>


