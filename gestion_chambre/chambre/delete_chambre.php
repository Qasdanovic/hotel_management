<?php

include "../../connect.php" ;

$id = $_GET["id"] ;

$data = $connect -> prepare("SELECT * FROM reservation INNER JOIN chambre 
                            ON reservation.Id_chambre = chambre.Id_chambre
                            WHERE reservation.Id_chambre = ?") ;

$data -> execute([$id]) ;

if ($data -> rowCount() == 0){
    $state = $connect -> prepare("DELETE FROM chambre WHERE Id_chambre=?") ;
    $state -> execute([$id]) ;
    header("Location:afficher_chambres.php?delet=oui") ;
} else {
    header("Location:afficher_chambres.php?delet=non") ;
}

?>