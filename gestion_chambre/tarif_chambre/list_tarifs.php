<?php
include "../../connect.php" ;

$state = $connect -> query("SELECT * FROM tarif_chambre") ;
$data = $state -> fetchAll(PDO :: FETCH_OBJ) ;


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
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>list Tariffs :</h4>
        </div>
        <div class="col-md-4">
            <a href="ajouter_tarif.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> add new tarif</a>
        </div>
    </div>
    <?php
            if (isset($_GET["alert"])){
                if ($_GET["alert"] === "no"){
                    echo "<div class='alert alert-danger m-2'>veuillez saisir tout les champs</div>" ;
                }
                else if($_GET["alert"] === "yes"){
                    echo "<div class='alert alert-success m-2'>le tarif est modifier avec success</div>" ;
                }
            }
        ?>
        <div class="row">
        <div class="col-md-12">
            <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 404){
                        echo "<div class='alert alert-danger'><b>Opération interdite :</b> tarif déjà liée à une chambre. </div>" ;
                    }
                    elseif ($_GET["alert"] == 200){
                        echo "<div class='alert alert-success'>le Tarif est supprimer avec success</div>" ;
                    }
                }
            ?>
        </div>
    </div>
        <table class="table table-bordered text-center">
            <thead  class="thead-dark">
                <tr>
                    <th>Id_tarif</th>
                    <th>Prix_base_nuit</th>
                    <th>Prix_base_passage</th>
                    <th>N_Prix_nuit</th>
                    <th>N_Prix_passage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $tarif){
                ?>
                <tr>
                    <td><?= $tarif -> Id_tarif ?></td>
                    <td><?= $tarif -> Prix_base_nuit ?></td>
                    <td><?= $tarif -> Prix_base_passage ?></td>
                    <td><?= $tarif -> N_Prix_nuit ?></td>
                    <td><?= $tarif -> N_Prix_passage ?></td>
                    <td>
                        <a href="update_tarif.php?id=<?= $tarif -> Id_tarif ?>" class='btn btn-primary'>Update <i class="bi bi-arrow-counterclockwise"></i></a>
                        <a href="delete_tarif.php?id=<?= $tarif -> Id_tarif ?>" class='btn btn-danger mx-2'>Delete <i class="bi bi-trash3"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</body>
</html>