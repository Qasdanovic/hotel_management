<?php

include "../connect.php" ;

$id = $_GET["id"] ;

$state = $connect ->query("SELECT * FROM reservation WHERE Id_client = $id") ;

if ($state -> rowCount() == 0){
    $requete = $connect -> query("DELETE FROM client WHERE Id_client = $id") ;
    header("location:afficher_clients.php?alert=200") ;
} else {
    header("location:afficher_clients.php?alert=404") ;
}

?>