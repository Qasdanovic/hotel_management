<?php

include "../../connect.php" ;

$id = $_GET["id"] ;


$st = $connect -> query("SELECT * FROM tarif_chambre WHERE Id_tarif=$id") ;

$data = $st -> fetch(PDO :: FETCH_OBJ) ;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["prix_base_nuit"]) or empty($_POST["prix_base_passage"])
     or empty($_POST["n_prix_nuit"]) or empty($_POST["n_prix_passage"]))
    {
        header("Location:update_tarif.php?alert=404&id=$id") ;
    } else {
        $state = $connect -> prepare("UPDATE tarif_chambre SET
        Prix_base_nuit=?, Prix_base_passage=?,N_Prix_nuit=?, N_Prix_passage=?
         WHERE Id_tarif = $id") ;

        $state -> execute([
            $_POST["prix_base_nuit"] ,
            $_POST["prix_base_passage"] ,
            $_POST["n_prix_nuit"] ,
            $_POST["n_prix_passage"] 
        ]) ;
        
        header("Location:list_tarifs.php?alert=yes") ;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-3">
            <a href="list_tarifs.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> annulé </a>
        </div>
    </div>
        <div class="row">
            <div class="col-md-8">
                <h2>Modifier le Tariff : </h2>
            </div>
            <div class="col-md-4">
                <a href="list_tarifs.php" class="btn btn-success"><h3><i class="bi bi-list-ul"></i> afficher list des tarifs :</h3></a>
            </div>
        </div>
        <?php
            if (isset($_GET["alert"])){
                if ($_GET["alert"] === "404"){
                    echo "<div class='alert alert-danger m-2'>veuillez saisir tout les champs</div>" ;
                }
            }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="prix_base_nuit">Prix Base Nuit</label>
                <input type="number" class="form-control" id="prix_base_nuit" name="prix_base_nuit" placeholder="Enter base price per night..." value="<?= $data -> Prix_base_nuit ?>">
            </div>
            <div class="form-group">
                <label for="prix_base_passage">Prix Base Passage</label>
                <input type="number" class="form-control" id="prix_base_passage" name="prix_base_passage" placeholder="Enter base price per passage..." value="<?= $data -> Prix_base_passage ?>">
            </div>
            <div class="form-group">
                <label for="n_prix_nuit">New Prix Nuit</label>
                <input type="number" class="form-control" id="n_prix_nuit" name="n_prix_nuit" placeholder="Enter new price per night..." value="<?= $data -> N_Prix_nuit ?>">
            </div>
            <div class="form-group">
                <label for="n_prix_passage">New Prix Passage</label>
                <input type="number" class="form-control" id="n_prix_passage" name="n_prix_passage" placeholder="Enter new price per passage..." value="<?= $data -> N_Prix_passage ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Tariff</button>
        </form>
    </div>
</body>
</html>