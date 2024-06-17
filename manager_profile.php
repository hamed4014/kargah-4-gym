
<?php
require ('functions.inc');
$pdo = require_once ('connection.inc');

if(isset($_POST['fname']) )
{
    $admin = [
        'username' => $_POST['username'],
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'email' => $_POST['email'],
        'id' => $_COOKIE['id']];
        if (isset($_POST['password']))
        {
            $admin = [
                'username' => $_POST['username'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'id' => $_COOKIE['id'],
                'password' => $_POST['password']];
        }


    if ( check_admin_text($admin) )
    {
        $check = check_for_change( $admin , $pdo , $_COOKIE['id']);
        if ( $check[0] && $check[1] )
        {
            change_info_admin($pdo , $admin);
            create_cookie ( $admin , $pdo);
            if ( isset($_FILES['image']))
            {
                $id_admin = give_id_admin($pdo, $_POST['username']);
                $file = $_FILES['image']['tmp_name'];
                $file_name = "admin_" . $id_admin . ".jpg";
                move_uploaded_file($file, "image/" . $file_name);
            }
            redirect("manager_profile.php");
        }

    }
}
?>

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
        form>div {
            display: inline-block!important;
            float: right;
            width: 48%!important;
            padding-top: 20px;
            font-family: "B Titr";
        }
        form>div>label {
            display: inline-block;
            width: 30%;
            float: right;
            height: 37px;
            line-height: 37px;
            text-align: left;
            margin-top: 20px;
        }
        form>div>input {
            width: 65%!important;
            height: 37px!important;
            float: right;
            margin-top: 20px;
        }
        section img {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<header>
    <?php
    require ('manager_header.inc');
    ?>
</header>

<?php
$fname = $_COOKIE['fname'];
$lname = $_COOKIE['lname'];
$email = $_COOKIE['email'];
$username = $_COOKIE['username'];
?>
<main id="main_student_info">
    <form class="form" method="post" action="manager_profile.php" enctype="multipart/form-data" style="width: 70%; display: inline-block; float: right">
        <div>
            <label>
                نام:
                &nbsp;
            </label>
            <?php
            echo "<input type='text' value='$fname' name='fname' id='fname' maxlength='15' minlength='3' class='form-control' required>";
            ?>

            <label>
                ایمیل:
                &nbsp;
            </label>
            <?php
            echo "<input type='email' value='$email' name='email' id='email' class='form-control' required>";
            ?>
            <label>
                عکس پروفایل:
                &nbsp;
            </label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div>
            <label>
                نام خانوادگی:
                &nbsp;
            </label>
            <?php
            echo "<input type='text' value='$lname' name='lname' id='lname' maxlength='15' minlength='3' class='form-control' required>";
            ?>
            <label>
                نام کاربری:
                &nbsp;
            </label>
            <?php
            echo "<input type='text' value='$username' name='username' id='username' maxlength='15' minlength='3' class='form-control' required readonly>";
            ?>
            <label>
                رمز عبور:
                &nbsp;
            </label>
            <?php
            echo "<input type='password' name='password' id='password' maxlength='16' minlength='8' class='form-control'>";
            ?>
        </div>

        <input type="submit" value="ذخیره" class="form-control btn_ok" style="margin-top: 220px;margin-right: 10px;margin-bottom: 10px">

    </form>
    <section style="width: 30%">
        <?php
        $id = $_COOKIE['id'];
        $file_name = "admin_".$id.".jpg";
        if (file_exists("image/$file_name"))
        {
            echo "
                <img src='image/$file_name' class='image_info_user'>
                <br>
                ID:
                &nbsp;
                $id
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
                ";
        }
        ?>
    </section>

</main>

<footer>
    <div class="remember">
        <form method="post" action="manager_profile.php">
            <label for="text">
                یادداشت:
            </label>
            <?php
            $text = give_text( $_COOKIE['id'] , $pdo);
            echo "
                    <textarea type='text' name='text' id='text' maxlength='1000' class='form-control'> $text </textarea>
                    <input type='text' name='id' style='display: none' value='$id'>
                    ";
            ?>

            <input type="submit" value="ذخیره" id="save_remember">
        </form>
    </div>
</footer>

<script src="js/manager_student_info.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>




