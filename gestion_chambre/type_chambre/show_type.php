<?php
include "../../connect.php" ;
$id = $_GET["id"] ;

$type_data = $connect -> query("SELECT * FROM type_chambre WHERE Id_type=$id") ;
$type_data = $type_data -> fetch(PDO :: FETCH_OBJ) ;

$numero_data = $connect -> query("SELECT Numero_chambre FROM chambre INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type WHERE chambre.Id_type=$id") ;
$numero_data = $numero_data -> fetchAll(PDO :: FETCH_OBJ) ;

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
    <div class="container">
    <div class="row mb-4 mt-3">
        <div class="col-md-3">
            <a href="list_types.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour </a>
        </div>
    </div>
        <div class="row m-4">
            <div class="col-md-8">
                <h4>le registre de type chambre :<b><?= $type_data -> Type_chambre ?></b></h4>
            </div>
            <div class="col-md-4">
                <a href="list_types.php" class="btn btn-success"><i class="bi bi-list-ul"></i> list des types</a>
            </div>
        </div>
        <table class="table-striped table table-bordered">
            <tr>
                <th>Id type</th>
                <td><?= $type_data -> Id_type ?></td>
            </tr>
            <tr>
                <th>Type_chambre</th>
                <td><?= $type_data -> Type_chambre ?></td>
            </tr>
            <tr>
                <th>Description_Type</th>
                <td><?= $type_data -> Description_type ?></td>
            </tr>
            <tr>
                <th>photo</th>
                <td>
                    <img src="../<?= $type_data -> Photo_type ?>" alt="">
                </td>
            </tr>
            <tr>
                <th>La liste des chambres ayant ce type </th>
                <td>
                    <?php
                    if (count($numero_data) == 0){
                        echo "<p class='text-danger'>pas de chambre a l'instant avec ce type</p>" ;
                    }
                    else{
                        foreach($numero_data as $nbr) :
                            echo $nbr -> Numero_chambre . "," ;
                        endforeach ;
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>