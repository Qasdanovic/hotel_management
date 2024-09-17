<?php
include "../../connect.php" ;

$data = $connect -> query("SELECT * FROM type_chambre") ;

$result = $data -> fetchAll(PDO :: FETCH_OBJ) ;

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
    <style>
            img {
                max-width: 100%;
                max-height: 100%;
                height: auto;
                width: auto;
        }
    </style>
</head>
<body>
<?php include "../../navbar.php" ; ?>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-10">
                <h1>la liste des types : </h1>
            </div>
            <div class="col-md-2">
                <a href="ajouter_type.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> ajouter nouveau type</a>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 404){
                        echo "<div class='alert alert-danger'><b>Opération interdite :</b> type déjà liée à une chambre. </div>" ;
                    }
                    elseif ($_GET["alert"] == 200){
                        echo "<div class='alert alert-success'>le type est supprimer avec success</div>" ;
                    }
                }
            ?>
        </div>
    </div>
        <table class="table table-bordered text-center">
            <thead  class="thead-dark">
                <th>Id type</th>
                <th>Type_chambre</th>
                <th>Description_Type</th>
                <th>photo</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    foreach($result as $room){
                ?>
                    <tr>
                        <td> <?= $room -> Id_type ?> </td>
                        <td> <?= $room -> Type_chambre ?> </td>
                        <td> <?= $room -> Description_type ?> </td>
                        <td>
                            <img src="../<?= $room -> Photo_type ?>" alt="" style="width:120px;">
                        </td>
                        <td>
                            <a href="update_type.php?id=<?= $room -> Id_type ?>" class='btn btn-primary mb-1 mx-2'>Update <i class="bi bi-arrow-counterclockwise"></i></a>
                            <a href="delete_type.php?id=<?= $room -> Id_type ?>" class='btn btn-danger mx-2'>Delete <i class="bi bi-trash3"></i></a>
                            <a href="show_type.php?id=<?= $room -> Id_type ?>" class='btn btn-warning mx-2'>show info <i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>