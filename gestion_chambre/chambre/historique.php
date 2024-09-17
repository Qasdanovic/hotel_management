<?php
include "../../connect.php" ;
$id = $_GET["id"] ;
$dat = $connect -> query("SELECT * FROM reservation
                            INNER JOIN chambre ON chambre.Id_chambre = reservation.Id_chambre
                            INNER JOIN client ON reservation.Id_client = client.Id_client
                            WHERE reservation.Id_chambre = $id;
                            ") ;

$datas = $dat -> fetchAll(PDO :: FETCH_OBJ) ;
// echo "<pre>" ;
// print_r($datas) ;
// echo "</pre>" ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../../bootstrap.php" ;
    ?>
    <style>
        center{
            margin-top: 200px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row my-3">
            <div class="col-md-3">
                <a href="http://localhost/php/gestion_chambre/chambre/afficher_chambres.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour</a>
            </div>
            <div class="col-md-9">
                <h2><i class="bi bi-hourglass"></i> L'historique de ce chambre </h2>
            </div>
        </div>
        <?php
        if ($dat -> rowCount() == 0){ ?>
            <center><h2><i class="bi bi-exclamation-triangle"></i> pas de historique dans ce chambre à l'instant</h2></center>
        <?php } else {
                    foreach($datas as $data) : ?>
                        <table class="table mb-5 table-dark">
                            <tr>
                                <th class="col-5">Date de réservation</th>
                                <td><?= $data -> Date_heure_reservation ?></td>
                            </tr>
                            <tr>
                                <th>Nom complet de Client</th>
                                <td><?= $data -> Nom_complet ?></td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td><?= $data -> Telephone ?></td>
                            </tr>
                            <tr>
                                <th>Date d’arrivée</th>
                                <td><?= $data -> Date_arrivee ?></td>
                            </tr>
                            <tr>
                                <th> Date de départ</th>
                                <td><?= $data -> Date_depart ?></td>
                            </tr>
                            <tr>
                                <th>Prix</th>
                                <td><?= $data -> Montant_total ?></td>
                            </tr>
                        </table>
                    <?php endforeach ;
                }?>
    </div>
</body>
</html>