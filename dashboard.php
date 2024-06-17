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
    <link href="css/student.css" type="text/css" rel="stylesheet">

    <script type="text/javascript">
         const handlePrint = () => {
            document.getElementById("myheader").setAttribute("hidden", "hidden");
            window.print();
            document.getElementById("myheader").removeAttribute("hidden");
         }
      </script>
</head>

<body>

<header id="myheader">
    <?php
    require ('student_header.inc');
    ?>
</header>

<!-- <main id="main">
    <div>
        <span>
            تعداد شاگردان
        </span>
        <span>
            50 نفر
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
    <div id="date">
        <span></span>
        <span></span>
    </div>
    <div>
        <span>
            تعداد برنامه تمرینی
        </span>
        <span>
            50 عدد
        </span>
    </div>
    <div>
        <span>
            تعداد برنامه غذایی
        </span>
        <span>
            50 عدد
        </span>
    </div>
    <div>

    </div>
    <div>

    </div>
</main> -->


    <div id="info">
      

        <table>
            <tr>
                <td>نام:</td>
                <td></td>
                <td>سطح یا سابقه تمرین:</td>
                <td></td>
            </tr>
            <tr>
                <td>وزن:</td>
                <td></td>
                <td>هدف:</td>
                <td></td>
            </tr>
            <tr>
                <td>قد:</td>
                <td></td>
                <td>تعداد روزهای تمرین در هفته:</td>
                <td></td>
            </tr>
            <tr>
                <td>جنسیت:</td>
                <td></td>
                <td>مصدومیت:</td>
                <td></td>
            </tr>
        </table>

    </div>



    <div class="plan">
        <h3>شنبه</h3>

        <table>
            <tr>
                <th>تمرین</th>
                <th>تعداد تکرار و تعداد ست</th>
                <th>استراحت بین ست ها</th>
                <th>؟؟؟ اجرای حرکت</th>
            </tr>
            <tr>
                <td>بالا سینه دمبل</td>
                <td>10*4</td>
                <td>1min</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

    </div>

    <button id="print" onclick='handlePrint()'>priiiiiiiiint</>


<footer>

</footer>

<script src="js/student.js"></script>
<script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>

