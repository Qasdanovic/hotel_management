<?php

include "../../connect.php" ;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["titre_capacite"]) or empty($_POST["numero_capacite"]))
    {
        header("Location:ajouter_capacite.php?alert=404") ;
    }
    else {
        $state = $connect -> prepare("INSERT INTO capacite_chambre VALUES
        (?,?,?)") ;

        $state -> execute([
            null,
            $_POST["titre_capacite"],
            $_POST["numero_capacite"],
        ]);
        header("Location:ajouter_capacite.php?alert=200") ;
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
        <div class="col-md-4">
            <a href="list_capacite.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour </a>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Add New Capacity</h2>
            </div>
            <div class="col-md-6">
                <a href="list_capacite.php" class="btn btn-success"><i class="bi bi-list-ul"></i> list capacity chambre </a>
            </div>
        </div>
        <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            else if($_GET["alert"] == 200){
                echo "<div class='alert alert-success'>nouveau type est ajouter avec success</div>" ;
            }
        }
        
        ?>
        <form  method="POST">
            <div class="form-group">
                <label for="titre_capacite">Capacity Title</label>
                <input type="text" class="form-control" id="titre_capacite" name="titre_capacite" placeholder="Enter capacity title...">
            </div>
            <div class="form-group">
                <label for="numero_capacite">Capacity Number</label>
                <input type="number" class="form-control" id="numero_capacite" name="numero_capacite" placeholder="Enter capacity number...">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Capacity</button>
        </form>
    </div>
</body>
</html>