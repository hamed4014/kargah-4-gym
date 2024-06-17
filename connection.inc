<?php

$host = 'localhost';
$db = 'gym';
$user_t = 'root';
$password = '24081381';
function connect ( $db , $user_t , $password , $host )
{
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
    try {
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        return $pdo = new PDO ($dsn , $user_t , $password , $options);
    }
    catch ( PDOException $e ){
        echo $e -> getMessage();
    }
}
return connect( $db , $user_t , $password , $host );