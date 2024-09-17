<?php
include "../connect.php" ;

$id = $_GET["id"] ;

$state = $connect -> prepare("DELETE FROM users_app WHERE Id_user=?") ;
$state -> execute([$id]) ;

header("location:http://localhost/php/compte/afficher_comptes.php?alert=200") ;


?>