<?php

function check ($admin , $pdo)
{

    $username_test = $admin['username'];
    $username = "'$username_test'";
    $sql = "SELECT username FROM gym.admins_info WHERE username =$username";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    $check = array(true , true);
    if ( count($admins) != 0 )
    {
        $check[0] = false;
    }
    reset($admins);
    $email_test = $admin['email'];
    $email = "'$email_test'";
    $sql = "SELECT email FROM gym.admins_info WHERE email =$email";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    if ( count($admins) != 0 )
    {
        $check[1] = false;
    }
    reset($admins);
    return $check;
}

function check_for_change ( $admin , $pdo , $id)
{
    $username_test = $admin['username'];
    $username = "'$username_test'";
    $sql = "SELECT username , id FROM gym.admins_info WHERE username =$username";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    $check = array(true , true);
    if ( count($admins) != 0 && $admins[0]['id'] != $id )
    {
        $check[0] = false;
    }
    reset($admins);
    $email_test = $admin['email'];
    $email = "'$email_test'";
    $sql = "SELECT email , id FROM gym.admins_info WHERE email =$email";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    if ( count($admins) != 0 && $admins[0]['id'] != $id )
    {
        $check[1] = false;
    }
    reset($admins);
    return $check;
}

function check_text ( $text )
{
    $check = true;
    $length = strlen($text);
    for ($i = 0 ; $i < $length ; $i++)
    {
        $askii = ord($text[$i]);
        if ( ($askii >= 33 && $askii <=45) ||
            ($askii == 47) ||
            ($askii >= 58 && $askii <=63) ||
            ($askii >= 91 && $askii <=96) ||
            ($askii >= 123 && $askii <=127))
        {
            $check = false;
        }
    }
    return $check;
}

function check_admin_text ( $admin )
{
    $check_text = true;
    if ( !check_text($admin['username']) )
    {
        $check_text = false;
    }
    if ( !check_text($admin['fname']) )
    {
        $check_text = false;
    }
    if ( !check_text($admin['lname']) )
    {
        $check_text = false;
    }
    if ( !check_text($admin['email']) )
    {
        $check_text = false;
    }
    return $check_text;
}

function check_user_text ( $user )
{
    $check_text = true;
    if ( !check_text($user['fname']) )
    {
        $check_text = false;
    }
    if ( !check_text($user['lname']) )
    {
        $check_text = false;
    }
    if ( !check_text($user['phone']) )
    {
        $check_text = false;
    }
    if ( !check_text($user['injury']) )
    {
        $check_text = false;
    }
    if ( !check_text($user['target']) )
    {
        $check_text = false;
    }
    if ( !check_text($user['history']) )
    {
        $check_text = false;
    }
    return $check_text;
}

function save_info_user ($pdo , $user , $id)
{
    $sql = "INSERt INTO users_info_$id (fname,lname,phone,birthday,gender,height,weight,injury,target,history)
            VALUES (:fname,:lname,:phone,:birthday,:gender,:height,:weight,:injury,:target,:history)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ([
        ':fname' => $user['fname'] ,
        ':lname' => $user['lname'] ,
        ':phone' => $user['phone'] ,
        ':birthday' => $user['birthday'] ,
        ':gender' => $user['gender'] ,
        ':height' => $user['height'] ,
        ':weight' => $user['weight'] ,
        ':injury' => $user['injury'] ,
        ':target' => $user['target'] ,
        ':history' => $user['history']
    ]);
    return true;
}

function change_info_user ($pdo , $user , $id)
{
    $id_admin = $_COOKIE['id'];
    $fname = $user['fname'];
    $lname = $user['lname'];
    $phone = $user['phone'];
    $birthday = $user['birthday'];
    $gender = $user['gender'];
    $height = $user['height'];
    $weight = $user['weight'];
    $injury = $user['injury'];
    $target = $user['target'];
    $history = $user['history'];
    $sql = "UPDATE users_info_$id_admin SET  fname = '$fname' ,lname = '$lname', phone = '$phone',
            birthday = '$birthday',gender = '$gender', height = '$height',weight = '$weight',
            injury = '$injury',target = '$target',history = '$history' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    return true;
}

function save_info_admin ($pdo , $admin)
{
    $option = [
        "cost" => "10"
    ];
    $password = password_hash($admin['password'] , PASSWORD_BCRYPT , $option);
    $sql = "INSERt INTO admins_info (fname,lname,email,username,password)
            VALUES (:fname,:lname,:email,:username,:password)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ([
        ':fname' => $admin['fname'] ,
        ':lname' => $admin['lname'] ,
        ':email' => $admin['email'] ,
        ':username' => $admin['username'] ,
        ':password' => $password ]);
    $username = $admin['username'];
    $sql = "SELECT id FROM gym.admins_info WHERE username = '$username'";
    $statment = $pdo -> query ($sql);
    $id = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = $id[0]['id'];
    $sql = "
    CREATE TABLE `users_info_$id` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `birthday` varchar(9) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `height` int NOT NULL,
  `weight` int NOT NULL,
  `injury` varchar(300) DEFAULT NULL,
  `target` varchar(300) DEFAULT NULL,
  `history` varchar(300) DEFAULT NULL,
  `foodplan` varchar(60) DEFAULT NULL,
  `history_foodplan` varchar(60) DEFAULT NULL,
  `sportplan` varchar(60) DEFAULT NULL,
  `history_sportplan` varchar(60) DEFAULT NULL,
  `image` varchar(60) DEFAULT NULL,
  `history_image` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
    ";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    $sql = "
    CREATE TABLE `food_plans_$id` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `level_foods` varchar(500) DEFAULT NULL,
  `foods` varchar(1000) DEFAULT NULL,
  `level_medicals` varchar(500) DEFAULT NULL,
  `medicals` varchar(1000) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `history` varchar(60),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
    ";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    $sql = "
    CREATE TABLE `sport_plans_$id` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `type` varchar(10) NOT NULL,
  `day` varchar(500) DEFAULT NULL,
  `sports` varchar(1000) DEFAULT NULL,
  `history` varchar(60),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
    ";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    return true;
}

function change_info_admin ($pdo , $admin)
{
    $fname = $admin['fname'];
    $lname = $admin['lname'];
    $email = $admin['email'];
    $username = $admin['username'];
    $id = $admin['id'];
    if (isset($admin['password']))
    {
        $option = [
            "cost" => "10"
        ];
        $password = password_hash($admin['password'] , PASSWORD_BCRYPT , $option);
        $sql = "UPDATE gym.admins_info SET fname = '$fname' , lname = '$lname' , email = '$email' , username = '$username' , password = '$password' WHERE id = $id";
        $statment = $pdo -> prepare ($sql);
        $statment -> execute ();
    }
    else
    {
        $sql = "UPDATE gym.admins_info SET fname = '$fname' , lname = '$lname' , email = '$email' , username = '$username' WHERE id = $id";
        $statment = $pdo -> prepare ($sql);
        $statment -> execute ();
    }



}

function give_text ( $id , $pdo )
{
    $sql = "SELECT text FROM gym.admins_info WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $statment -> execute ();
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $admins[0]['text'];
}

function save_text ( $id , $text , $pdo)
{
    $sql = "UPDATE gym.admins_info SET text = '$text' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function redirect($url)
{
    if (!headers_sent()){
        header("Location: $url");
    }else{
        echo "<script type='text/javascript'>window.location.href='$url'</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=$url'/></noscript>";
    }
    exit;
}

function check_for_log ($admin , $pdo) {
    $username_test = $admin['username'];
    $username = "'$username_test'";
    $sql = "SELECT username , password FROM gym.admins_info WHERE username = $username";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    $check = array(false , false);
    if ( count($admins) != 0 )
    {
        $check[0] = true;
        if ( password_verify( $admin['password'] , $admins[0]['password']))
        {
            $check[1] = true;
        }
    }
    return $check;
}

function check_admin_text_for_log ( $admin )
{
    $check_text = true;
    if ( !check_text($admin['username']) )
    {
        $check_text = false;
    }
    return $check_text;
}

function create_cookie ( $admin , $pdo )
{
    $username_test = $admin['username'];
    $username = "'$username_test'";
    $sql = "SELECT id , fname , lname , email , username , password , text FROM gym.admins_info WHERE username = $username";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    if ( count($admins) != 0 )
    {
        $admin = $admins[0];
        setcookie( 'id' , $admin['id'] , time() + 5400);
        setcookie( 'fname' , $admin['fname'] , time() + 5400);
        setcookie( 'lname' , $admin['lname'] , time() + 5400);
        setcookie( 'email' , $admin['email'] , time() + 5400);
        setcookie( 'username' , $admin['username'] , time() + 5400);
        setcookie( 'text' , $admin['text'] , time() + 5400);
    }
}

function creat_session ( $admin , $pdo )
{
    $username_test = $admin['username'];
    $username = "'$username_test'";
    $sql = "SELECT id , fname , lname , phone , username , password FROM gym.admins_info WHERE username = $username";
    $statment = $pdo -> query ($sql);
    $admins = $statment -> fetchall (PDO::FETCH_ASSOC);
    $check = false;
    if ( count($admins) != 0 )
    {
        if ( $admins[0]['password'] == $admin['password'] )
        {
            $admin = $admins[0];
            session_start();
            $_SESSION ['id'] = $admin['id'];
            $_SESSION ['fname'] = $admin['fname'];
            $_SESSION ['lname'] = $admin['lname'];
            $_SESSION ['phone'] = $admin['phone'];
            $_SESSION ['username'] = $admin['username'];
            $check = true;
        }
    }
    return $check;
}

function get_users_info ( $pdo , $id )
{
    $sql = "SELECT id , fname , lname , birthday , phone , height , weight , sportplan , foodplan FROM gym.users_info_$id";
    $statment = $pdo -> query ($sql);
    $users = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $users;
}

function get_user_info_full ( $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT * FROM gym.users_info_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $user = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $user[0];
}

function create_new_food ( $pdo , $title)
{
    $title_temp = "'$title'";
    $sql = "INSERt INTO foods (title)
            VALUES ($title_temp)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function get_foods ($pdo)
{
    $sql = "SELECT id , title FROM gym.foods";
    $statment = $pdo -> query ($sql);
    $food_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $food_plans;
}

function delete_food ( $pdo , $id )
{
    $sql = "DELETE FROM gym.foods WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function update_food ( $pdo , $id , $title)
{
    $sql = "UPDATE gym.foods SET title = '$title' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_medical_supplements ( $pdo , $title)
{
    $title_temp = "'$title'";
    $sql = "INSERt INTO medical_supplements (title)
            VALUES ($title_temp)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function get_medical_supplements ($pdo)
{
    $sql = "SELECT id , title FROM gym.medical_supplements";
    $statment = $pdo -> query ($sql);
    $food_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $food_plans;
}

function delete_medical_supplement ( $pdo , $id )
{
    $sql = "DELETE FROM gym.medical_supplements WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function update_medical_supplement ( $pdo , $id , $title)
{
    $sql = "UPDATE gym.medical_supplements SET title = '$title' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_sport ( $pdo , $title , $text)
{
    $title_temp = "'$title'";
    $text_temp = "'$text'";
    $sql = "INSERt INTO sports (title , text)
            VALUES ($title_temp , $text_temp)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function get_sports ($pdo)
{
    $sql = "SELECT id , title , text FROM gym.sports";
    $statment = $pdo -> query ($sql);
    $sports = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $sports;
}

function delete_sport ( $pdo , $id )
{
    $sql = "DELETE FROM gym.sports WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function update_sport ( $pdo , $id , $title , $text)
{
    $sql = "UPDATE gym.sports SET title = '$title' , text = '$text' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_level_foodplan ( $pdo , $level , $id)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT foods , level_foods FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $food_plan = $food_plan[0];
    $new_foods = $food_plan ['foods']." {}";
    $new_level_foods = $food_plan ['level_foods']." {"."$level"."}";
    $sql = "UPDATE gym.food_plans_$id_admin SET level_foods = '$new_level_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    $sql = "UPDATE gym.food_plans_$id_admin SET foods = '$new_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function add_group_food ( $pdo , $id , $number )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT foods FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $foods = $food_plan[0]['foods'];
    $test = 0;
    for ($i = 0 ; $i < strlen($foods); $i++)
    {
        if ($foods[$i] == "{")
        {
            $test++;
            if ( $test == $number )
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $foods[$i] == "}" )
        {
            $new_foods = substr ( $foods , 0 , $i)."()".substr($foods , $i );
            break;
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET foods = '$new_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function add_food ( $pdo , $id , $number , $number_2 , $title , $text ) {
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT id FROM gym.foods WHERE title = '$title'";
    $statment = $pdo -> query ($sql);
    $foods = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id_foods = $foods[0]['id'];
    $sql = "SELECT foods FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $food_plan = $food_plan[0]['foods'];
    $test = 0;
    $test_1 = 0;
    $new = "["."$id_foods".":"."$text"."]";
    for ($i = 0 ; $i < strlen($food_plan); $i++)
    {
        if ($food_plan[$i] == "{")
        {
            $test++;
        }
        if ( $test == $number )
        {
            while (true)
            {
                $i++;
                if ($food_plan[$i] == ")")
                {
                    $test_1++;
                    if ( $test_1 == $number_2 )
                    {
                        $new_foods = substr ( $food_plan , 0 , $i ).$new.substr($food_plan , $i );
                        break;
                    }
                }
            }
            break;
        }
    }

    $sql = "UPDATE gym.food_plans_$id_admin SET foods = '$new_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_foods_of_food_plans ( $pdo , $id , $number)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT foods , level_foods FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $foods = $food_plan[0]['foods'];
    $level_foods = $food_plan[0]['level_foods'];
    $test = 0;
    for ($i = 0 ; $i < strlen($foods); $i++)
    {
        if ($foods[$i] == "{")
        {
            $test++;
            if ( $test == $number )
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $foods[$i] == "}" )
        {
            $new_foods = substr ( $foods , 0 , $test_1 - 1).substr($foods , $i + 1 );
            break;
        }
    }
    $test = 0;
    for ($i = 0 ; $i < strlen($level_foods); $i++)
    {
        if ($level_foods[$i] == "{")
        {
            $test++;
            if ( $test == $number )
            {
                $test_1 = $i;
                echo $id;
            }
        }
        if ( $test == $number && $level_foods[$i] == "}" )
        {
            echo $id;
            $new_level_foods = substr ( $level_foods , 0 , $test_1 - 1).substr($level_foods , $i + 1 );
            break;
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET foods = '$new_foods' , level_foods = '$new_level_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_foods_of_group_food ( $pdo , $id , $number , $number_2 )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT foods FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $foods = $food_plan[0]['foods'];
    $level_foods = $food_plan[0]['level_foods'];
    $test = 0;
    $test_2 = 0;
    for ($i = 0 ; $i < strlen($foods); $i++)
    {
        if ($foods[$i] == "(")
        {
            $test_2++;
            if ( $test_2 == $number_2 )
            {
                $test_1 = $i;
            }
        }
        if ($foods[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ( $test == $number && $test_2 == $number_2 && $foods[$i] == ")" )
        {
            $new_foods = substr ( $foods , 0 , $test_1).substr($foods , $i + 1 );

            break;
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET foods = '$new_foods' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_day_sportplan ( $pdo , $day , $id)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports,day FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sport_plan = $sport_plan[0];
    $new_sports = $sport_plan ['sports']." {(:::)}";
    $new_day = $sport_plan ['day']." {"."$day"."/"."توضیحات:"."}";
    $sql = "UPDATE gym.sport_plans_$id_admin SET day = '$new_day' , sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_day_sportplan_aerobic ( $pdo , $day , $id)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports,day FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sport_plan = $sport_plan[0];
    $new_sports = $sport_plan ['sports']." {(::)}";
    $new_day = $sport_plan ['day']." {"."$day"."}";
    $sql = "UPDATE gym.sport_plans_$id_admin SET day = '$new_day' , sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}



function add_sport ( $pdo , $id , $number , $repead , $rest , $move ) {
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $test = 0;
    $new = "(".":"."$repead".":"."$rest".":"."$move".")";
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
        }
        if ( $test == $number )
        {
            while (true)
            {
                $i++;
                if ($sports[$i] == "}")
                {
                    $new_sports = substr ( $sports , 0 , $i ).$new.substr($sports , $i);
                    break;
                }
            }
            break;
        }
    }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function add_group_sport_2( $pdo , $id , $number, $repead , $text)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $test = 0;
    $new = "(".":"."$repead".":"."$text".")";
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
        }
        if ( $test == $number )
        {
            while (true)
            {
                $i++;
                if ($sports[$i] == "}")
                {
                    $new_sports = substr ( $sports , 0 , $i ).$new.substr($sports , $i);
                    break;
                }
            }
            break;
        }
    }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_sport ( $pdo , $id , $number , $number_2 , $repead , $rest , $move ) {
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $new ="$repead".":"."$rest".":"."$move";
    $test = 0;
    $test_1 = 0;
    $test_2 = 0;
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ($sports[$i] == "(" && $test == $number)
        {
            $test_2++;
            if ($test_2 == $number_2)
            {
                while (true)
                {
                    $i++;
                    if ($sports[$i] == ":")
                    {
                        $test_1 = $i;
                        break;
                    }
                }
            }
        }
        if ( $test == $number && $test_2 == $number_2 && $sports[$i] == ")" )
        {
            $new_sports = substr ( $sports , 0 , $test_1 + 1).$new.substr($sports , $i);
            break;
        }
    }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_sport_2 ( $pdo , $id , $number , $number_2 , $repead , $text ) {
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $test = 0;
    $test_2 = 0;
    $id_sport = "";
    for ($i = 0 ; $i < strlen($sports) ; $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ($sports[$i] == "(" && $test == $number)
        {
            $test_2++;
            if ($test_2 == $number_2)
            {
                $temp = "";
                while (true)
                {
                    $i++;
                    if ( $sports[$i] == ":")
                    {
                        $id_sport = $temp;
                        break;
                    }
                    $temp = $temp.$sports[$i];
                }
            }
        }
    }
    $new ="$id_sport".":"."$repead".":"."$text";
    $test = 0;
    $test_2 = 0;
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ($sports[$i] == "(" && $test == $number)
        {
            $test_2++;
            if ($test_2 == $number_2)
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $test_2 == $number_2 && $sports[$i] == ")" )
        {
            $new_sports = substr ( $sports , 0 , $test_1 + 1).$new.substr($sports , $i);
            break;
        }
    }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function add_sport_aerobic ( $pdo , $id , $number , $number_2 , $id_sport)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT id FROM gym.sports WHERE id = '$id_sport'";
    $statment = $pdo -> query ($sql);
    $sports = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id_sport = $sports[0]['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $new ="["."$id_sport"."]";
    $test = 0;
    $test_2 = 0;
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ($sports[$i] == "(" && $test == $number)
        {
            $test_2++;
            if ($test_2 == $number_2)
            {
                while (true)
                {
                    $i++;
                    if ($sports[$i] == ":")
                    {
                        $new_sports = substr ( $sports , 0 , $i).$new.substr($sports , $i);
                        break;
                    }
                }
                break;
            }
        }
    }
    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_sportplan_of_sport_plans ( $pdo , $id , $number)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports , day FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo->query($sql);
    $sport_plan = $statment->fetchall(PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $day = $sport_plan[0]['day'];
    $test = 0;
    for ($i = 0; $i < strlen($sports); $i++) {
        if ($sports[$i] == "{") {
            $test++;
            if ($test == $number) {
                $test_1 = $i;
            }
        }
        if ($test == $number && $sports[$i] == "}") {
            $new_sports = substr($sports, 0, $test_1 - 1) . substr($sports, $i + 1);
            break;
        }
    }
    $test = 0;
    for ($i = 0; $i < strlen($day); $i++) {
        if ($day[$i] == "{") {
            $test++;
            if ($test == $number) {
                $test_1 = $i;
            }
        }
        if ($test == $number && $day[$i] == "}") {
            $new_day = substr($day, 0, $test_1 - 1) . substr($day, $i + 1);
            break;
        }
    }
    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' , day = '$new_day' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_sportplan_of_sport_plans_2 ( $pdo , $id , $number , $number_2)
{
        $id_admin = $_COOKIE['id'];
        $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
        $statment = $pdo -> query ($sql);
        $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
        $sports = $sport_plan[0]['sports'];
        $test = 0;
        $test_2 = 0;
        for ($i = 0 ; $i < strlen($sports); $i++)
        {
            if ($sports[$i] == "{")
            {
                $test++;
                $test_2 = 0;
            }
            if ($sports[$i] == "(")
            {
                $test_2++;
                if ( $test == $number && $test_2 = $number_2)
                {
                    $test_1 = $i;
                }
            }
            if ( $test == $number && $test_2 = $number_2 && $sports[$i] == ")" )
            {
                $new_sports = substr ( $sports , 0 , $test_1).substr($sports , $i + 1 );
                break;
            }
        }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_sportplan_of_sport_plans_3 ( $pdo , $id , $number , $number_2)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT sports FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sport_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sport_plan[0]['sports'];
    $test = 0;
    $test_2 = 0;
    for ($i = 0 ; $i < strlen($sports); $i++)
    {
        if ($sports[$i] == "{")
        {
            $test++;
            $test_2 = 0;
        }
        if ($sports[$i] == "(")
        {
            $test_2++;
            if ( $test == $number && $test_2 = $number_2)
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $test_2 = $number_2 && $sports[$i] == ")" )
        {
            $new_sports = substr ( $sports , 0 , $test_1).substr($sports , $i + 1 );
            break;
        }
    }

    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function create_new_level_medical ( $pdo , $level , $text , $id)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT medicals , level_medicals FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $food_plan = $food_plan[0];
    $new_medical = $food_plan ['medicals']."{".$text."}";
    $new_level_medical = $food_plan ['level_medicals']." {"."$level"."}";
    $sql = "UPDATE gym.food_plans_$id_admin SET level_medicals = '$new_level_medical' , medicals = '$new_medical' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_medical_of_food_plan ( $pdo , $id , $number)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT medicals , level_medicals FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $medicals = $food_plan[0]['medicals'];
    $level_medicals = $food_plan[0]['level_medicals'];
    $test = 0;
    for ($i = 0 ; $i < strlen($medicals); $i++)
    {
        if ($medicals[$i] == "{")
        {
            $test++;
            if ( $test == $number )
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $medicals[$i] == "}" )
        {
            $new_medicals = substr ( $medicals , 0 , $test_1).substr($medicals , $i + 1 );
            break;
        }
    }
    $test = 0;
    for ($i = 0 ; $i < strlen($level_medicals); $i++)
    {
        if ($level_medicals[$i] == "{")
        {
            $test++;
            if ( $test == $number )
            {
                $test_1 = $i;
            }
        }
        if ( $test == $number && $level_medicals[$i] == "}" )
        {
            $new_level_medicals = substr ( $level_medicals , 0 , $test_1 - 1).substr($level_medicals , $i + 1 );
            break;
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET medicals = '$new_medicals' , level_medicals = '$new_level_medicals' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function give_food_plans ( $pdo )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT * FROM gym.food_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $food_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $food_plans;
}

function create_food_plan ( $pdo , $title )
{
    $id_admin = $_COOKIE['id'];
    $title_temp = "'$title'";
    $date = jdate('Y/m/d');
    $date = "'$date'";
    $sql = "INSERt INTO food_plans_$id_admin (title , history)
            VALUES ($title_temp , $date)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
    $sql = "SELECT id FROM gym.food_plans_$id_admin WHERE title = '$title'";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = $food_plan[0]['id'];
    return $id;
}

function delete_food_plan ( $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT id , foodplan FROM gym.users_info_$id_admin";
    $statment = $pdo -> query ($sql);
    $users = $statment -> fetchall (PDO::FETCH_ASSOC);
    for ( $i = 0; $i < count($users); $i++ )
    {
        if ( $users[$i]['foodplan'] == $id )
        {
            $id_temp = $users[$i]['id'];
            $sql = "UPDATE gym.users_info_$id_admin SET foodplan = null , history_foodplan = null WHERE id = $id_temp";
            $statment = $pdo -> prepare ($sql);
            $statment -> execute ();
        }
    }
    $sql = "DELETE FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function give_food_plan ( $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT * FROM gym.food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $food_plan[0];
}

function change_text ($text , $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "UPDATE gym.food_plans_$id_admin SET text = '$text' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function give_sport_plans ( $pdo )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT * FROM gym.sport_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $sport_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $sport_plans;
}

function create_sport_plan ( $pdo , $title , $type )
{
    $id_admin = $_COOKIE['id'];
    $title_temp = "'$title'";
    $date = jdate('Y/m/d');
    $date = "'$date'";
    $sql = "INSERt INTO sport_plans_$id_admin (title , type , history)
            VALUES ($title_temp , $type , $date)";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_sport_plan ( $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT id , sportplan FROM gym.users_info_$id_admin";
    $statment = $pdo -> query ($sql);
    $users = $statment -> fetchall (PDO::FETCH_ASSOC);
    for ( $i = 0; $i < count($users); $i++ )
    {
        if ( $users[$i]['sportplan'] == $id )
        {
            $id_temp = $users[$i]['id'];
            $sql = "UPDATE gym.users_info_$id_admin SET sportplan = null , history_sportplan = null WHERE id = $id_temp";
            $statment = $pdo -> prepare ($sql);
            $statment -> execute ();
        }
    }
    $sql = "DELETE FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function give_sport_plan ( $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT * FROM gym.sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $food_plan = $statment -> fetchall (PDO::FETCH_ASSOC);
    return $food_plan[0];
}

function change_text_sport ($text , $number , $pdo , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT day FROM sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $day = $statment -> fetchall (PDO::FETCH_ASSOC);
    $day = $day[0]['day'];
    $test = 0;
    for ($i = 0 ; $i < strlen($day); $i++)
    {
        if ($day[$i] == "{")
        {
            $test++;
            if ($test == $number)
            {
                while (true)
                {
                    $i++;
                    if( $day[$i] == "/")
                    {
                        $test_1 = $i;
                        break;
                    }
                }
                while (true)
                {
                    $i++;
                    if ( $day[$i] == "}")
                    {
                        $new_day = substr ( $day , 0 , $test_1 + 1).$text.substr($day , $i);
                        break;
                    }
                }
                break;
            }
        }
    }
    $sql = "UPDATE gym.sport_plans_$id_admin SET day = '$new_day' WHERE id = $id";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function give_title_food_plans ($pdo)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT title FROM gym.food_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $food_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    $title_food_plans = array();
    for ($i = 0 ; $i < count($food_plans) ; $i++)
    {
        $title_food_plans[$i] = $food_plans [$i]['title'];
    }
    return $title_food_plans;
}

function give_title_sport_plans ($pdo)
{
    $id_admin = $_COOKIE['id'];
    $sql = "SELECT title FROM gym.sport_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $sport_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    $title_sport_plans = array();
    for ($i = 0 ; $i < count($sport_plans) ; $i++)
    {
        $title_sport_plans[$i] = $sport_plans [$i]['title'];
    }
    return $title_sport_plans;
}

function change_food_plan_user ( $pdo , $title , $history , $id_user , $id_admin)
{
    $sql = "SELECT title , id FROM gym.food_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $food_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = 0;
    for ( $i = 0 ; $i < count($food_plans) ; $i++)
    {
        if ( $food_plans[$i]['title'] == $title )
        {
            $id = $food_plans[$i]['id'];
        }
    }
    $sql = "UPDATE gym.users_info_$id_admin SET foodplan = '$id' , history_foodplan = '$history' WHERE id = $id_user";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_sport_plan_user ( $pdo , $title , $history , $id_user , $id_admin)
{
    $sql = "SELECT title , id FROM gym.sport_plans_$id_admin";
    $statment = $pdo -> query ($sql);
    $sport_plans = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = 0;
    for ( $i = 0 ; $i < count($sport_plans) ; $i++)
    {
        if ( $sport_plans[$i]['title'] == $title )
        {
            $id = $sport_plans[$i]['id'];
        }
    }
    $sql = "UPDATE gym.users_info_$id_admin SET sportplan = '$id' , history_sportplan = '$history' WHERE id = $id_user";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_cookie ()
{
    setcookie( 'id' , "" , time() - 1000);
    setcookie( 'fname' , "" , time() - 1000);
    setcookie( 'lname' , "" , time() - 1000);
    setcookie( 'phone' , "" , time() - 1000);
    setcookie( 'username' , "" , time() - 1000);
    setcookie( 'text' , "" , time() - 1000);
}

function search_users ( $text , $users )
{
    $users_temp = array();
    foreach ( $users as $key )
    {
        $name = $key['fname']." ".$key['lname'];
        for ($i = 0 ; $i < strlen($name) - strlen($text) + 1 ; $i++)
        {
            for ( $j = 0 ; $j < strlen($text) ; $j++ )
            {
                if ( $text[$j] != $name[$i + $j] )
                {
                    break;
                }
                if ( $j == strlen($text) - 1 && $text[$j] == $name[$i + $j] )
                {
                    array_push( $users_temp , $key );
                }
            }
        }
    }
    if ( $text == null)
    {
        $users_temp = $users;
    }
    return $users_temp;
}

function search_sport_plans ( $text , $sport_plans )
{
    $sport_plans_temp = array();
    foreach ( $sport_plans as $key )
    {
        $title = $key['title'];
        for ($i = 0 ; $i < strlen($title) - strlen($text) + 1 ; $i++)
        {
            for ( $j = 0 ; $j < strlen($text) ; $j++ )
            {
                if ( $text[$j] != $title[$i + $j] )
                {
                    break;
                }
                if ( $j == strlen($text) - 1 && $text[$j] == $title[$i + $j] )
                {
                    array_push( $sport_plans_temp , $key );
                }
            }
        }
    }
    if ( $text == null)
    {
        $sport_plans_temp = $sport_plans;
    }
    return $sport_plans_temp;
}

function search_food_plans ( $text , $food_plans )
{
    $food_plans_temp = array();
    foreach ( $food_plans as $key )
    {
        $title = $key['title'];
        for ($i = 0 ; $i < strlen($title) - strlen($text) + 1 ; $i++)
        {
            for ( $j = 0 ; $j < strlen($text) ; $j++ )
            {
                if ( $text[$j] != $title[$i + $j] )
                {
                    break;
                }
                if ( $j == strlen($text) - 1 && $text[$j] == $title[$i + $j] )
                {
                    array_push( $food_plans_temp , $key );
                }
            }
        }
    }
    if ( $text == null)
    {
        $food_plans_temp = $food_plans;
    }
    return $food_plans_temp;
}

function give_id_admin ($pdo , $username)
{
    $sql = "SELECT id FROM gym.admins_info WHERE username = '$username'";
    $statment = $pdo -> query ($sql);
    $id = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = $id [0]['id'];
    return $id;
}

function give_id_user ($pdo , $id_admin)
{
    $sql = "SELECT id FROM gym.users_info_$id_admin";
    $statment = $pdo -> query ($sql);
    $ids = $statment -> fetchall (PDO::FETCH_ASSOC);
    $id = $ids [count($ids) - 1]['id'];
    return $id;
}

function add_user_sport_plan ( $pdo , $id , $user )
{
    $id_admin = $_COOKIE['id'];
    $date = jdate('Y/m/d');
    $sql = "UPDATE gym.users_info_$id_admin SET sportplan = '$id' , history_sportplan = '$date' WHERE id = '$user'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function add_user_food_plan ( $pdo , $id , $user )
{
    $id_admin = $_COOKIE['id'];
    $date = jdate('Y/m/d');
    $sql = "UPDATE gym.users_info_$id_admin SET foodplan = '$id' , history_foodplan = '$date' WHERE id = '$user'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function save_images ( $pdo , $id , $id_admin , $image1 )
{
    $sql = "SELECT image , history_image FROM gym.users_info_$id_admin WHERE id = '$id'";
    $statment = $pdo -> query ($sql);
    $image = $statment -> fetchall (PDO::FETCH_ASSOC);
    $history = $image[0]['history_image'];
    $image = $image[0]['image'];
    if( $image1['tmp_name'] != NULL)
    {
        if ($image == null)
        {
            $file = $image1['tmp_name'];
            echo $image1['tmp_name'];
            $file_name = "user_".$id_admin."_".$id."_"."0"."img".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
            $image = "1";
        }
        else
        {
            $file = $image1['tmp_name'];
            $file_name = "user_".$id_admin."_".$id."_".$image."img".".jpg";
            move_uploaded_file( $file, "image/".$file_name );
            $image = (integer)$image;
            $image++;
            $image = "$image";
        }
        $date = jdate('Y/m/d');
        $history = $history."[".$date."]";
        $sql = "UPDATE gym.users_info_$id_admin SET image = '$image' , history_image = '$history' WHERE id = '$id'";
        $statment = $pdo -> prepare ($sql);
        $statment -> execute ();
    }
}

function delete_sport_plan_of_user ( $pdo , $id_admin , $id)
{
    $temp = "";
    $sql = "UPDATE gym.users_info_$id_admin SET sportplan = '$temp' , history_sportplan = '$temp' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_food_plan_of_user ( $pdo , $id_admin , $id)
{
    $temp = "";
    $sql = "UPDATE gym.users_info_$id_admin SET foodplan = '$temp' , history_foodplan = '$temp' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function delete_one_sport_plan ( $pdo , $id_admin , $id , $number1 , $number2 , $number3 )
{
    $sql = "SELECT sports FROM sport_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $sports = $statment -> fetchall (PDO::FETCH_ASSOC);
    $sports = $sports[0]['sports'];
    $test1 = 0;
    $test2 = 0;
    $test3 = 0;
    for ($i = 0 ; $i < strlen($sports) ; $i++)
    {
        if ( $sports[$i] == "{")
        {
            $test1++;
            $test2 = 0;
        }
        if ($sports[$i] == "(")
        {
            $test2++;
            $test3 = 0;
        }
        if ($sports[$i] == "[")
        {
            $test3++;
            if ("$test3" == $number3 && "$test2" == $number2 && "$test1" == $number1)
            {
                $temp = $i;
                while (true)
                {
                    $i++;
                    if ( $sports[$i] == "]")
                    {
                        $new_sports = substr ( $sports , 0 , $temp).substr($sports , $i + 1);
                        break;
                    }
                }
            }
        }
    }
    $sql = "UPDATE gym.sport_plans_$id_admin SET sports = '$new_sports' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_title_foodplan ( $pdo , $id_admin , $id , $new_title , $number)
{
    $sql = "SELECT level_foods FROM food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $foodplans = $statment -> fetchall (PDO::FETCH_ASSOC);
    $foodplans = $foodplans[0]['level_foods'];
    $test = 0;
    for ($i = 0 ; $i < strlen($foodplans) ; $i++)
    {
        if ( $foodplans[$i] == "{")
        {
            $test++;
            if ("$test" == $number)
            {
                $test1 = $i;
                while (true)
                {
                    $i++;
                    if ($foodplans[$i] == "}")
                    {
                        $new_level_foods = substr ( $foodplans , 0 , $test1 + 1).$new_title.substr($foodplans , $i);
                        break;
                    }
                }
            }
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET level_foods = '$new_level_foods' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_medical_plan ( $pdo , $id_admin , $id , $title , $text , $number)
{
    $sql = "SELECT level_medicals , medicals FROM food_plans_$id_admin WHERE id = $id";
    $statment = $pdo -> query ($sql);
    $medicalplan = $statment -> fetchall (PDO::FETCH_ASSOC);
    $medicals = $medicalplan[0]['medicals'];
    $level_medicals = $medicalplan[0]['level_medicals'];
    $test = 0;
    for ($i = 0 ; $i < strlen($medicals) ; $i++)
    {
        if ( $medicals[$i] == "{")
        {
            $test++;
            if ("$test" == $number)
            {
                $test1 = $i;
                while (true)
                {
                    $i++;
                    if ($medicals[$i] == "}")
                    {
                        $new_medicals = substr ( $medicals , 0 , $test1 + 1).$text.substr($medicals , $i);
                        break;
                    }
                }
            }
        }
    }
    $test = 0;
    for ($i = 0 ; $i < strlen($level_medicals) ; $i++)
    {
        if ( $level_medicals[$i] == "{")
        {
            $test++;
            if ("$test" == $number)
            {
                $test1 = $i;
                while (true)
                {
                    $i++;
                    if ($level_medicals[$i] == "}")
                    {
                        $new_level_medicals = substr ( $level_medicals , 0 , $test1 + 1).$title.substr($level_medicals , $i);
                        break;
                    }
                }
            }
        }
    }
    $sql = "UPDATE gym.food_plans_$id_admin SET level_medicals = '$new_level_medicals' , medicals = '$new_medicals' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_title_sportplan ( $pdo , $title , $id)
{
    $id_admin = $_COOKIE['id'];
    $sql = "UPDATE gym.sport_plans_$id_admin SET title = '$title' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}

function change_title_foodplan_1 ( $pdo , $title , $id )
{
    $id_admin = $_COOKIE['id'];
    $sql = "UPDATE gym.food_plans_$id_admin SET title = '$title' WHERE id = '$id'";
    $statment = $pdo -> prepare ($sql);
    $statment -> execute ();
}









