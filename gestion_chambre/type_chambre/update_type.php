<?php

include "../../connect.php" ;

$id = $_GET["id"] ;

$data = $connect -> query("SELECT * FROM type_chambre where Id_type=$id") ;

$data = $data -> fetch(PDO :: FETCH_OBJ) ;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["type"]) or empty($_POST["description"]))
    {
        header("Location:ajouter_type.php?alert=404") ;
    }
    else {
        $state = $connect -> prepare("UPDATE type_chambre SET Type_chambre=? ,
        Description_type=? ,Photo_type=? WHERE Id_type=?
        ") ;

        $state -> execute([
            $_POST["type"],
            $_POST["description"],
            "room_photos/" . $_POST["file"],
            $id
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
    <div class="row mb-4 mt-3">
        <div class="col-md-3">
            <a href="list_types.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> annulé </a>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Update the type : </h2>
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
                echo "<div class='alert alert-success'>the type is updqted successfully</div>" ;
            }
        }
        
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="type">Room Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Enter room type"  value="<?= $data -> Type_chambre ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter room description" value="<?= $data -> Description_type ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="file" class="form-control"  name="file" placeholder="Enter room description">
            </div>
            <button type="submit" class="btn btn-primary">Update type</button>
        </form>
        
    </div>
</body>
</html>