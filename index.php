<?php
require ('functions.inc');
if ( isset($_POST['exit']) )
{
    delete_cookie ();
}
if ( isset ($_POST['username_log']) )
{
    $admin = [
        'username' => $_POST['username_log'],
        'password' => $_POST['password_log']];
    if ( check_admin_text_for_log($admin) )
    {
        $pdo = require_once ('connection.inc');
        $check_log = check_for_log( $admin , $pdo);
        if ( $check_log[0] && $check_log[1] )
        {
            create_cookie ( $admin , $pdo);
            redirect("manager_dashboard.php");
        }
    }
    else
    {

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
</head>

<body>

<header>
    <?php
    if (isset($_COOKIE['username']))
    {
        $pdo = require_once ('connection.inc');
        require ('manager_header_index.inc');
    }
    else
    {
        require ('main_header.inc');
    }
    ?>
</header>
<?php
require('signin_admin.inc');
require ('login.inc');
?>

<?php


if ( isset ($_POST['username']) )
{
    $admin = [
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'fname' => $_POST['fname'],
    'lname' => $_POST['lname'],
    'email' => $_POST['email']];
    if ( check_admin_text($admin) )
    {
        $pdo = require_once ('connection.inc');
        $check = check( $admin , $pdo);
        if ( $check[0] && $check[1] )
        {
            $risult = save_info_admin($pdo , $admin);
            if ( isset($_FILES['image']))
            {
                $id_admin = give_id_admin($pdo , $_POST['username'] );
                $file = $_FILES['image']['tmp_name'];
                $file_name = "admin_".$id_admin.".jpg";
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
            if (!$check[0])
            {
                echo "<div class='massage_erorr' id='massage'>نام کاربری قبلا ثبت نام شده است!!!</div>";
            }
            else
            {
                echo "<div class='massage_erorr' id='massage'>ایمیل قبلا ثبت شده است!!!</div>";
            }
        }
    }
    else
    {

    }
}


if ( isset ($_POST['username_log']) )
{
    if ( $check_log[0] && !$check_log[1])
    {
        echo "<div class='massage_erorr' id='massage'>رمز عبور اشتباه است!!!</div>";
    }
    else if (!$check_log[0] && !$check_log[1])
    {
        echo "<div class='massage_erorr' id='massage'>نام کاربری وجود ندارد!!!</div>";
    }
}



?>

<main id="main" style="transition: 0.5s">
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" style="margin-top: 52px">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="background-color: rgba(180,180,180,1)"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" style="background-color: rgba(180,180,180,1)"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" style="background-color: rgba(180,180,180,1)"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000" style="height: 450px">
                <div class="first_si_log" style="padding: 40px; background-size: 100% 100%;">
                    <div style="width: 100%; ">

                    </div>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000" style="background-color: rgba(200,230,255,1); height: 450px; text-align: center">
                <div style="display: inline-block; text-align: center; height: 100px; width: 100%; margin-top: 60px">
                    <img src="image/arm.jpg" style="width: 100px;height: 100px">
                </div>
                <div style="width: 70%; font-family: 'B Titr'; text-align: center;
                color: navy ; display: inline-block; font: 40pt bolder; margin-top: 50px; border: solid blue 5px;
                border-radius: 20px; margin-left: auto; margin-right: auto;">
                    فقط با سه قدم بدن متناسب خود را بسازید!!!
                </div>
            </div>
            <div class="carousel-item" style="background-color: green; height: 450px" data-bs-interval="3000">

            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev" >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="levels">
        <div style="float: left;width: 40%">
            <img src="image/signin_vector.jpg"  >
        </div>
        <div style="float: left; width: 60%">
            <div>
                قدم اول
                <br>
                ثبت نام کنید!
            </div>
            <br>
            <a>
                <div id="btn_signin2">ثبت نام</div>
            </a>
        </div>
    </div>
    <div class="levels" style="background-color: rgba(200,200,200,0.8)">
        <div style="float: right;width: 40%">
            <img src="image/plan_vector.png"  >
        </div>
        <div style="float: right; width: 60%">
            <div>
                قدم دوم
                <br>
                برنامه بگیرید!
            </div>
            <br>
            <a>
                <div>برنامه</div>
            </a>
        </div>
    </div>
    <div class="levels">
        <div style="float: left;width: 40%; line-height: 500px">
            <img src="image/exerciess_vector.jpg">
        </div>
        <div style="float: left; width: 60%">
            <div>
                قدم سوم
                <br>
                تمرین کنید!
            </div>
            <br>
            <a>
                <div>تمرین</div>
            </a>
        </div>
    </div>
    <div class="levels" style="background-color: rgba(200,200,200,0.8)">
        <div style="float: right;width: 40%">
            <img src="image/final_vector.png"  >
        </div>
        <div style="float: right; width: 60%">
            <div>
                در نهایت
                <br>
                بدنی متناسب داشته باشید!
            </div>
        </div>
    </div>
</main>

<footer>
    <?php
    require ("main_footer.inc");
    ?>
</footer>

<script src="js/main.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
