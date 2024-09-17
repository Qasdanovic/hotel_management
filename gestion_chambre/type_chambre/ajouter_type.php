<?php

include "../../connect.php" ;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["type"]) or empty($_POST["description"]))
    {
        header("Location:ajouter_type.php?alert=404") ;
    }
    else {
        $state = $connect -> prepare("INSERT INTO type_chambre VALUES(
        ?,?,?,?)") ;

        $state -> execute([
            null,
            $_POST["type"],
            $_POST["description"],
            "room_photos/" . $_POST["file"]
        ]);
        header("Location:ajouter_type.php?alert=200") ;
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
            <a href="list_types.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> annulé </a>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Add New type : </h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="list_types.php" class="btn btn-success w-50"><i class="bi bi-list-ul"></i> list des types</a>
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
        <form method="POST">
            <div class="form-group">
                <label for="type">Room Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Enter room type">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter room description">
            </div>
            <div class="form-group">
                <label for="description">type photo :</label>
                <input type="file" class="form-control"name="file" placeholder="Enter room picture ...">
            </div>
            <button type="submit" class="btn btn-primary">add type</button>
        </form>
        
    </div>
</body>
</html>