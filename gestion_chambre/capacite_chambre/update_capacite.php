<?php

include "../../connect.php" ;

$id = $_GET["id"] ;

$data = $connect -> prepare("SELECT * FROM capacite_chambre WHERE Id_capacite=?") ;
$data -> execute([$id]) ;
$data = $data -> fetch(PDO :: FETCH_OBJ) ;



if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["titre_capacite"]) or empty($_POST["numero_capacite"]))
    {
        header("Location:update_capacite.php?alert=404") ;
    }
    else {
        $state = $connect -> prepare("UPDATE capacite_chambre SET 
        Titre_capacite=?, Numero_capacite=? WHERE Id_capacite=$id") ;

        $state -> execute([
            $_POST["titre_capacite"] ,
            $_POST["numero_capacite"]
        ]);
        header("Location:list_capacite.php?alert=200") ;
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
        <div class="row">
            <div class="col-md-4">
                <a href="list_capacite.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> annulé </a>
            </div>
            <div class="col-md-8">
                <h2>Update Capacity : </h2>
            </div>
        </div>
        <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            else if($_GET["alert"] == 200){
                echo "<div class='alert alert-success'>chambre capacite est modifier avec success</div>" ;
            }
        }
        
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="titre_capacite">Capacity Title</label>
                <input type="text" class="form-control" id="titre_capacite" name="titre_capacite" placeholder="Enter capacity title..." value="<?= $data -> Titre_capacite ?>">
            </div>
            <div class="form-group">
                <label for="numero_capacite">Capacity Number</label>
                <input type="number" class="form-control" id="numero_capacite" name="numero_capacite" placeholder="Enter capacity number..." value="<?= $data -> Numero_capacite ?>">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Update Capacity</button>
        </form>
    </div>
</body>
</html>