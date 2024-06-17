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
    $users = get_users_info($pdo , $_COOKIE['id']);
    $number_users = count($users);
    $number_food_plans = count( give_title_food_plans($pdo));
    $number_sport_plans = count( give_title_sport_plans($pdo));
    ?>
</header>

<main id="dashboard">
    <div>
        <span>
            تعداد شاگردان
        </span>
        <span>
            <?php
            echo "$number_users نفر"
            ?>
        </span>
    </div>
    <div id="date">
        <span></span>
        <span></span>
    </div>
    <div>
        <span>
            تعداد برنامه تمرینی
        </span>
        <span>
            <?php
            echo "$number_sport_plans عدد"
            ?>

        </span>
    </div>
    <div>
        <span>
            تعداد برنامه غذایی
        </span>
        <span>
            <?php
            echo "$number_food_plans عدد"
            ?>
        </span>
    </div>
    <div>
        <span>
            تعداد افراد آنلاین
        </span>
        <span>
            50 نفر
        </span>
    </div>
    <div>

    </div>
</main>

<footer>
    <div class="remember">
        <form method="post" action="manager_dashboard.php">
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
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>

