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
    create_new_food( $pdo , $_POST['new_title']);
}

if ( isset($_POST['id_delete']))
{
    delete_food($pdo , $_POST['id_delete']);
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

?>
<main id="main_diets">
    مکمل های دارویی
    <table>
        <?php
        if ( count($medical_supplements) != 0 )
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
            foreach ($medical_supplements as $key )
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
                    <form method='post' action='manager_medicals.php'>
                    <input type='text' value = '$id' readonly name='id_delete_medical' id='id_delete_medical'>
                    <input type='submit' class='delete' value='حذف'>
                    </form>
                    
                    <button class='change' id='btn_change_medical_$id'>
                        ویرایش
                    </button>
                    
                    <div class='change_window' id='change_medical_$id'>
                        <div>
                            <div>
                                <span id='exit_change_medical_$id'>
                                    <i class='fa-solid fa-xmark fa-2xl' style='color: #ff253a;' ></i>
                                </span>
                                <div style='text-align: center;'>
                                    ویرایش مکمل دارویی
                                </div>
                                <form class='form_new' method='post' action='manager_medicals.php'>
                                    <label for='title'>
                                عنوان:
                                    </label>
                                    <input type='text' maxlength='200' name='new_title_medical_$id' id='new_title'>
                                    <input type='text' name='new_title_medical_id_$id' id='new_title' style='display: none;' value='$id'>
                                    <br>
                                    <input type='submit' value='ثبت'>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                    document.getElementById('exit_change_medical_$id').onclick = function () {
                    document.getElementById('main_diets').style.opacity =1;
                    document.getElementById('main_diets').style.filter = 'none';
                    document.getElementById('change_medical_$id').style.opacity = 0;
                    document.getElementById('change_medical_$id').style.visibility = 'hidden';
                    document.getElementById('change_medical_$id').style.zIndex = 2;
                    }   
                    document.getElementById('btn_change_medical_$id').onclick = function () {
                    document.getElementById('change_medical_$id').style.opacity = 1;
                    document.getElementById('change_medical_$id').style.visibility = 'visible';
                    document.getElementById('change_medical_$id').style.zIndex = 2;
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
            هیچ مکمل دارویی تعریف نشده است.
            </td>
            ";
        }

        ?>
    </table>
    <button id="btn_new_medical">
        <i class="fa-solid fa-plus fa-sm" style="color: #ffffff;"></i>
        تعریف مکمل دارویی جدید
    </button>
</main>

<div class="change_window" id="new_medical">
    <div>
        <div>
                <span id="exit_new_medical">
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ff253a;" ></i>
                </span>

            <div style="text-align: center;">
                تعریف مکمل دارویی جدید
            </div>
            <form class="form_new" method="post" action="manager_medicals.php">
                <label for="title">
                    عنوان:
                </label>
                <input type="text" maxlength="200" name="new_title_medical" id="new_title_medical">
                <br>
                <input type="submit" value="ثبت">
            </form>
        </div>
    </div>
</div>


<footer>
    <div class="remember">
        <form method="post" action="manager_medicals.php">
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

<script>
    document.getElementById("btn_new_medical").onclick = function () {
        document.getElementById("main_diets").style.opacity = 0.4;
        document.getElementById("main_diets").style.filter = "blur(4px)";
        document.getElementById("new_medical").style.zIndex = 2;
        document.getElementById("new_medical").style.opacity = 1;
        document.getElementById("new_medical").style.visibility = "visible";
        document.getElementById("new_medical").style.zIndex = 2;
    }

    document.getElementById("exit_new_medical").onclick = function () {
        document.getElementById("main_diets").style.opacity =1;
        document.getElementById("main_diets").style.filter = "none";
        document.getElementById("new_medical").style.opacity = 0;
        document.getElementById("new_medical").style.visibility = "hidden";
        document.getElementById("new_medical").style.zIndex = 2;
    }
</script>

<script src="js/manager.js"></script>
<script src="js/manager_diets.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>

