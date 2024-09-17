<?php
session_start() ;
try {
    $connect = new PDO("mysql: host=localhost; dbname=hotel_db", "root", "") ;

} catch (PDOException $err){
    echo $err -> getMessage() ;
}

// if (!$_SESSION["type"] || !$_SESSION["name"]) {
//     header("location:http://localhost/php/login.php") ;
// }



?>