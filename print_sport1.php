
<?php
$pdo = require_once ('connection.inc');
require ('functions.inc');
require ('jdf.php');

$id = $_POST['id'];

$sports = get_sports($pdo);
$title_sport_plans = give_title_sport_plans ($pdo);
$user = get_user_info_full ( $pdo , $id );
$fname = $user['fname'];
$lname = $user['lname'];
$phone = $user['phone'];
$weight = $user['weight'];
$height = $user['height'];
$birthday = $user['birthday'];
$birthday = substr($birthday , 4 , 7);
$birthday = (int) $birthday;
$date = jdate('Y' , time() , '' , 'Asia/Tehran' , 'en');
$date = (integer) $date;
$old = $date - $birthday;
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
$sportplan_id = $user['sportplan'];

$day = array();
if ( $sportplan_id != null )
{
    $sport_plan = give_sport_plan ($pdo , $sportplan_id);
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

$persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
$english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  4 ,  5 ,  5 ,  6 ,  6 ,  7 ,  8 ,  9 ];
$old = str_replace($english, $persian, $old);
$height = str_replace($english, $persian, $height);
$weight = str_replace($english, $persian, $weight);


$date = $date = jdate('Y/m/d');

$name = $fname." ".$lname;

$font = "mitra";
$image_addres = "image/print.jpg";
$stylesheet1 = file_get_contents('css/print.css');
$stylesheet2 = file_get_contents('fontawesome-free-6.4.0-web/css/fontawesome.css');
$stylesheet3 = file_get_contents('fontawesome-free-6.4.0-web/css/brands.css');
$stylesheet4 = file_get_contents('fontawesome-free-6.4.0-web/css/solid.css');
$print_text = "
<html style='width: 100%; height: 100%' lang='fa' dir='rtl'>
<head>
    <link rel='stylesheet' type='text/css' href='css/print.css'>
</head>

<body style='direction: rtl;  background-color: white; position: relative; background-color: rgba(200,230,255,1);'>
    <div class='header'>
        <div style='width: 33%'>
            <div style='text-align: right; width: 38%'>
                نام ورزشکار:
                <br>
                وزن:
                <br>
                قد:
                <br>
                جنسیت:
                <br>
            </div>
            <div style='text-align: left; width: 50%; color: rgba(0,0,0,1)'>
                $name
                <br>
                $weight
                <br>
                $height
                <br>
                $gender
                <br>
            </div>
        </div>
        <div style='width: 31%; text-align: center; height: 110px; background-color: rgba(0,0,0,0); color: black; line-height: 10px'>
            <br>
            <img src='image/arm.jpg'>
        </div>
        <div style='width: 33%;'>
            <div style='text-align: right; width: 38%;'>
                تاریخ:
                <br>
                سن:
                <br>
                هدف:
                <br>
                بیماری:
                <br>
            </div>
            <div style='text-align: left; width: 50%; color: rgba(0,0,0,1)'>
                $date
                <br>
                $old سال
                <br>
                $target
                <br>
                $injury
                <br>
            </div>
        </div>
    </div>
    <div class='title'>
        <div>
             برنامه تخصصی تمرین
        </div>
    </div>
    ";

$number = 0;
foreach ( $day as $key )
{
    $number++;
    $key = str_replace($english, $persian, $key);
    $print_text = $print_text."
    <br>
    <div class='title_sport'>
    $key
    </div>
    <table class='table_food'>
    <tr style='height: 40px;
        background-color: rgba(252,130,0,1);
        font: 15pt bold;
        text-align: center;
        border-radius: 50%;
        line-height: 40px;
        text-align: center !important;'>
        <td style='width: 22%; text-align: center; font: 13pt bold;'>
            تمرین
        </td>
        <td style='width: 26%; text-align: center; font: 13pt bold;'>
            تعداد تکرار و مقدار ست
        </td>
        <td style='width: 26%; text-align: center; font: 13pt bold;'>
            زمان استراحت بین ست ها
        </td>
        <td style='width: 26%; text-align: center; font: 13pt bold;'>
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
        $repead_test = str_replace($english, $persian, $repead_test);
        $rest_test = str_replace($english, $persian, $rest_test);
        $move_test = str_replace($english, $persian, $move_test);
        foreach ($sports as $key_sport) {
            if ($key_sport['id'] == $title_test) {
                $title_test = $key_sport['title'];
            }
        }
        $print_text = $print_text."
        <tr style='width: 100%;'>
            <td style='width: 34%; height: 30px; text-align: right; padding-right: 10px; font: 12pt bolder'>
        ";
        $number3 = 0;
        foreach ( $key_temp['title'] as $key_test)
        {
            $number3++;
            $key_test = str_replace($english, $persian, $key_test);
            if ($number3 == 1)
            {
                $print_text = $print_text."
                $key_test
                ";
            }
            else
            {
                $print_text = $print_text." + "."
                $key_test
                ";
            }
        }
        $print_text = $print_text."
        </td>
            <td  style='width:22%; height: 30px; text-align: right; padding-right: 10px; font: 12pt bolder'>
                $repead_test
            </td>
            <td  style='width: 22%; height: 30px; text-align: right; padding-right: 10px; font: 12pt bolder'>
                $rest_test
            </td>
            <td  style='width: 22%; height: 30px; text-align: right; padding-right: 10px;  font: 12pt bolder'>
                $move_test
            </td>
        </tr>
        ";
    }
    $text_t = $text [$number-1];
    $print_text = $print_text."
    <tr>
        <td style='width: 100%; font-size: 12pt; text-align: right; padding: 5px' colspan='4'>
            $text_t
        </td>
    </tr>
    </table>
    ";
}






$print_text = $print_text."
    <footer>
    راه های ارتباطی:
        <br><br>
        <div class='footer_div'>
            Email:
            <br>
            reza7reza77@gmail.com
        </div>
        <div class='footer_div'>
            Instagram:
            <br>
            @Reza.Rezaeian
        </div>
        <div class='footer_div'>
            Telegram:
            <br>
            @Rezaeian_13
        </div>
        <div class='footer_div'>
            Phone:
            <br>
            09360679338
        </div>
    </footer>
    
</body>

</html>
";

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8'
]);
$mpdf->WriteHTML($stylesheet1 , 1);
$mpdf->WriteHTML($stylesheet2 , 1);
$mpdf->WriteHTML($stylesheet3 , 1);
$mpdf->WriteHTML($stylesheet4 , 1);
$mpdf->WriteHTML($print_text);

$file_name = $name.'.pdf';
ob_clean();
$mpdf->Output($file_name , 'D');
?>
