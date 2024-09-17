<?php

include "../../connect.php" ;

$data = $connect -> query("SELECT * FROM capacite_chambre") ;
$data = $data -> fetchAll(PDO :: FETCH_OBJ) ;

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
<?php include "../../navbar.php" ; ?>
<div class="container mt-5">
    <div class="row my-4 py-1">
        <div class="col-md-9">
            <h2>list des Capacités : </h2>
        </div>
        <div class="col-md-3">
            <a href="ajouter_capacite.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> ajouter new capacite : </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 404){
                        echo "<div class='alert alert-danger'><b>Opération interdite :</b> Capacité déjà liée à une chambre. </div>" ;
                    }
                    elseif ($_GET["alert"] == 200){
                        echo "<div class='alert alert-success'>le capacite est supprimer avec success</div>" ;
                    }
                }
            ?>
        </div>
    </div>
        <table class="table table-bordered text-center">
            <thead  class="thead-dark">
                <tr>
                    <th>Id_capacite</th>
                    <th>Titre_capacite</th>
                    <th>Numero_capacite</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($data as $capacite) {
                ?>
                    <tr>
                        <td><?= $capacite -> Id_capacite ?></td>
                        <td><?= $capacite -> Titre_capacite ?></td>
                        <td><?= $capacite -> Numero_capacite ?></td>
                        <td>
                            <a href="update_capacite.php?id=<?= $capacite -> Id_capacite ?>" class='btn btn-primary'>Update <i class="bi bi-arrow-counterclockwise"></i></a>
                            <a href="delete_capaciite.php?id=<?= $capacite -> Id_capacite ?>" class='btn btn-danger mx-2'>Delete <i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>