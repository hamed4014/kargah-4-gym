
<?php
$pdo = require_once ('connection.inc');
require ('functions.inc');
require ('jdf.php');

$id = $_POST['id'];

$foodplans =get_foods($pdo);
$medicals = get_medical_supplements($pdo);
$title_food_plans = give_title_food_plans ($pdo);
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
$foodplan_id = $user['foodplan'];

if ( $foodplan_id != null ) {
    $food_plan = give_food_plan($pdo, $foodplan_id);
    $level_foods_temp = $food_plan ['level_foods'];
    $level_foods = array();
    if ($level_foods_temp != null) {
        for ($i = 0; $i < strlen($level_foods_temp); $i++) {
            if ($level_foods_temp[$i] == "{") {
                $temp = "";
                while (true) {
                    $i++;
                    if ($level_foods_temp[$i] == "}") {
                        array_push($level_foods, $temp);
                        break;
                    }
                    $temp = $temp . $level_foods_temp[$i];

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

<body style='direction: rtl;  background-color: white; position: relative; background-color: rgba(200,230,255,1)'>
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
            برنامه غذایی 
        </div>
    </div>
    
    <table class='table_food'>
        <tr style='height: 40px;
            background-color: rgba(252,130,0,1);
            font: 15pt bold;
            text-align: center;
            border-radius: 50%;
            line-height: 40px;
            text-align: center !important;'>
            <td style='font: 20pt bold;'>
                وعده
            </td>
            <td style='width: 80%; text-align: center; font: 20pt bold;'>
                برنامه تغذیه
            </td>
        </tr>
        ";

$number = 0;
foreach ( $level_foods as $key )
{
    $number++;
    $print_text = $print_text."
    <tr>
    <td style='width: 21%'>
        $key
    </td style='width: 79%'>
    <td>
        <table class='table2'>
    ";
    $number_2 = 0;
    foreach ( $foods[ $number - 1] as $key_temp )
    {
        $number_2++;
        $id_test = $number."_".$number_2;
        $print_text = $print_text."
        <tr>
            <td>
                $key_temp
            </td>
        </tr>
        ";
    }
    $print_text = $print_text."
    </table>
    </td>
    </tr>
    ";
}
$print_text = $print_text."
    </table>
";
if (count($level_medicals) != 0)
{
    $print_text = $print_text. "
    <div class='title2'>
        <div>
            دارو های مکمل 
        </div>
    </div>
    <table class='table_food'>
    <tr style='height: 40px;
            background-color: rgba(252,130,0,1);
            font: 15pt bold;
            text-align: center;
            border-radius: 50%;
            line-height: 40px;
            text-align: center !important;'>
        <td>
            نام دارو
        </td>
        <td style='text-align: center'>
            توضیحات
        </td>
    </tr>
    ";
    $number = 0;
    for ( $i = 0 ; $i < count($level_medicals) ; $i++)
    {
        $number++;
        $level_medicals[$i] = str_replace($english, $persian, $level_medicals[$i]);
        $medicalplans[$i] = str_replace($english, $persian, $medicalplans[$i]);
        $print_text = $print_text."
        <tr>
            <td style='width: 20%'>
                $level_medicals[$i]
            </td>
            <td style='width: 80%; text-align: center'>
                $medicalplans[$i]
            </td>
        </tr>
        ";
    }
    $print_text = $print_text. "
    </table>
    ";
    $text = $food_plan ['text'];
    $print_text = $print_text. "
    <div class='text'>
        توضیحات:
        $text
    </div>
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