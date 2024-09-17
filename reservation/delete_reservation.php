<?php

$id = $_GET["id"] ;

include "../connect.php" ;

$select = $connect -> query("SELECT * FROM reservation WHERE Id_reservation = $id") ;
$select = $select -> fetch(PDO :: FETCH_OBJ) ;


$id_chambre = $select -> Id_chambre ;


$state = $connect -> prepare("DELETE FROM reservation WHERE Id_reservation = ?") ;
$state -> execute([$id]) ;



header("location:afficher_reservation.php?alert=202") ;


?>