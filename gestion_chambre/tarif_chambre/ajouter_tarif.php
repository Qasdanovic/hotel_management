<?php

include "../../connect.php" ;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["prix_base_nuit"]) or empty($_POST["prix_base_passage"])
     or empty($_POST["n_prix_nuit"]) or empty($_POST["n_prix_passage"]))
    {
        header("Location:ajouter_tarif.php?alert=404") ;
    } else {

        $state = $connect -> prepare("INSERT INTO tarif_chambre 
        VALUES(?,?,?,?,?)") ;

        $state -> execute([
            null ,
            $_POST["prix_base_nuit"] ,
            $_POST["prix_base_passage"] ,
            $_POST["n_prix_nuit"] ,
            $_POST["n_prix_passage"]
        ]) ;
        header("Location:ajouter_tarif.php?alert=200") ;
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
            <a href="list_tarifs.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour </a>
        </div>
    </div>
        <div class="row">
            <div class="col-md-8">
                <h2>Add New Tariff</h2>
            </div>
            <div class="col-md-4">
                <a href="list_tarifs.php" class="btn btn-success"><h3><i class="bi bi-list-ul"></i> afficher list des tarifs :</h3></a>
            </div>
        </div>
        <?php
            if (isset($_GET["alert"])){
                if ($_GET["alert"] == 404){
                    echo "<div class='alert alert-danger m-2'>veuillez saisir tout les champs</div>" ;
                }
                else if($_GET["alert"] == 200){
                    echo "<div class='alert alert-success m-2'>nouveau tarif est ajouter avec success</div>" ;
                }
            }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="prix_base_nuit">Prix Base Nuit</label>
                <input type="number" class="form-control" id="prix_base_nuit" name="prix_base_nuit" placeholder="Enter base price per night...">
            </div>
            <div class="form-group">
                <label for="prix_base_passage">Prix Base Passage</label>
                <input type="number" class="form-control" id="prix_base_passage" name="prix_base_passage" placeholder="Enter base price per passage...">
            </div>
            <div class="form-group">
                <label for="n_prix_nuit">New Prix Nuit</label>
                <input type="number" class="form-control" id="n_prix_nuit" name="n_prix_nuit" placeholder="Enter new price per night...">
            </div>
            <div class="form-group">
                <label for="n_prix_passage">New Prix Passage</label>
                <input type="number" class="form-control" id="n_prix_passage" name="n_prix_passage" placeholder="Enter new price per passage...">
            </div>
            <button type="submit" class="btn btn-primary">Add Tariff</button>
        </form>
    </div>
</body>
</html>