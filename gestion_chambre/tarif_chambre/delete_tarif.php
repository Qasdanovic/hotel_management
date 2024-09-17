<?php
include "../../connect.php" ;
$id = $_GET["id"] ;

$data = $connect -> query("SELECT * FROM chambre WHERE Id_tarif=$id") ;
// echo $data -> rowCount() ;

if ($data -> rowCount() == 0){
    $state = $connect -> prepare("DELETE FROM tarif_chambre WHERE Id_tarif=?") ;
    $state -> execute([$id]) ;
    header("Location:list_tarifs.php?alert=200") ;
} else {
    header("Location:list_tarifs.php?alert=404") ;
}

// $data = $data -> fetch(PDO :: FETCH_OBJ) ;

// echo "<pre>" ;
// print_r($data) ;
// echo "</pre>" ;

?>