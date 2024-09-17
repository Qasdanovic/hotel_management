<?php
include "../../connect.php" ;

$id = $_GET["id"] ;

$state = $connect -> query("SELECT * FROM chambre 
                            INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                            INNER JOIN capacite_chambre ON chambre.Id_capacite = capacite_chambre.Id_capacite 
                            INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif 
                            WHERE chambre.Id_chambre=$id 
                            ") ;
$data = $state -> fetch(PDO :: FETCH_OBJ) ;

// echo "<pre>";
// print_r($data) ;
// echo "</pre>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        img{
            width: 400px;
        }
    </style>
    <?php
        include "../../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row m-4">
            <div class="col-md-3">
                <a href="afficher_chambres.php" class="btn btn-danger">retour <i class="bi bi-arrow-return-left"></i></a>
            </div>
            <div class="col-md-8">
                <h3>les informations de chambre numero : <b><?= $data -> Numero_chambre ?></b></h3>
            </div>
    </div>
        <div class="row">
            <table class="table ">
                <tr>
                    <th>Id chambre</th>
                    <td><?= $data -> Id_chambre ?></td>
                </tr>

                <tr>
                    <th>Numero chambre</th>
                    <td><?= $data -> Numero_chambre ?></td>
                </tr>

                <tr>
                    <th>Nombre des adultes et enfants</th>
                    <td><?= $data -> Nombre_adultes_enfants_ch ?></td>
                </tr>
                <tr>
                    <th>Renfort chambre</th>
                    <td>
                        <?php
                            if ($data -> Renfort_chambre == 0){
                                echo "Non" ;
                            } else if ($data -> Renfort_chambre == 1){
                                echo "Oui" ;
                            }
                        ?>
                    </td>
                </tr>


                <tr>
                    <th>Etage chambre</th>
                    <td><?= $data -> Etage_chambre ?></td>
                </tr>

                <tr>
                    <th>Nombre des lits chambre</th>
                    <td><?= $data -> Nbr_lits_chambre ?></td>
                </tr>

                <tr>
                    <th>Photo de chambre :</th>
                    <td>
                        <img src="../<?= $data -> Photo ?>" alt="">
                    </td>
                </tr>

                <tr>
                    <th>Type de chambre</th>
                    <td><?= $data -> Type_chambre ?></td>
                </tr>

                <tr>
                    <th>Description type</th>
                    <td><?= $data -> Description_type ?></td>
                </tr>

                <tr>
                    <th>Titre de capacite</th>
                    <td><?= $data -> Titre_capacite ?></td>
                </tr>

                <tr>
                    <th>Numero de capacite</th>
                    <td><?= $data -> Numero_capacite ?></td>
                </tr>
                <tr>
                    <th>Prix_base_nuit</th>
                    <td><?= $data -> Prix_base_nuit ?></td>
                </tr>
                <tr>
                    <th>Prix_base_passage</th>
                    <td><?= $data -> Prix_base_passage ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>