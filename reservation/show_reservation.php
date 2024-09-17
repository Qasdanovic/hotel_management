<?php
include "../connect.php" ;

$id = $_GET["id"] ;

$state = $connect -> prepare("SELECT * FROM reservation INNER JOIN chambre
                            ON reservation.Id_chambre = chambre.Id_chambre
                            INNER JOIN client ON client.Id_client = reservation.Id_client
                            INNER JOIN type_chambre ON chambre.Id_type = Type_chambre.Id_type
                            WHERE Id_reservation = ?") ;

$state -> execute([$id]) ;
$data = $state -> fetch(PDO :: FETCH_OBJ) ;

// echo "<pre>" ;
// print_r($data) ;
// echo "</pre>" ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../bootstrap.php" ;
    ?>
    <style>
        th{
            width : 35% ;
        }
        img{
            width: 400px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">

    <div class="row m-3">
        <div class="col-md-2">
            <a href="afficher_reservation.php" class="btn btn-danger"><i class="bi bi-arrow-return-left"></i> retour</a>
        </div>
        <div class="col-md-10">
            <h3>consultation de réservation de Mr <b class="text-primary"><?= $data -> Nom_complet ?></b></h3>
        </div>
        
    </div>
    
        <table class="table table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">Informations de reservation : </th>
            </tr>
            <tr>
                <th>Id_reservation</th>
                <td><?= $data -> Id_reservation ?></td>
            </tr>
            <tr>
                <th>Code_reservation</th>
                <td><?= $data -> Code_reservation ?></td>
            </tr>
            <tr>
                <th>Date_heure_reservation</th>
                <td><?= $data -> Date_heure_reservation ?></td>
            </tr>
            <tr>
                <th>Date_arrivee</th>
                <td><?= $data -> Date_arrivee ?></td>
            </tr>
            <tr>
                <th>Date_depart</th>
                <td><?= $data -> Date_depart ?></td>
            </tr>
            <tr>
                <th>Nbr_jours</th>
                <td><?= $data -> Nbr_jours ?></td>
            </tr>
            <tr>
                <th>Nbr_adultes_enfants</th>
                <td><?= $data -> Nbr_adultes_enfants ?></td>
            </tr>
            <tr>
                <th>Montant_total</th>
                <td><?= $data -> Montant_total ?></td>
            </tr>
            <tr>
                <th>Etat</th>
                <td><?= $data -> Etat ?></td>
            </tr>
        </table>
        <table class="table mt-3 table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">les informations de chambre : </th>
            </tr>
            <tr>
                <th>Id_chambre</th>
                <td><?= $data -> Id_chambre ?></td>
            </tr>
            <tr>
                <th>Numero_chambre</th>
                <td><?= $data -> Numero_chambre ?></td>
            </tr>
            <tr>
                <th>Nombre_adultes_enfants_ch</th>
                <td><?= $data -> Nombre_adultes_enfants_ch ?></td>
            </tr>
            <tr>
                <th>Renfort_chambre</th>
                <td><?= $data -> Renfort_chambre ?></td>
            </tr>
            <tr>
                <th>Etage_chambre</th>
                <td><?= $data -> Etage_chambre ?></td>
            </tr>
            <tr>
                <th>Nbr_lits_chambre</th>
                <td><?= $data -> Nbr_lits_chambre ?></td>
            </tr>
            <tr>
                <th>Type_chambre</th>
                <td><?= $data -> Type_chambre ?></td>
            </tr>
            <tr>
                <th>Description_type</th>
                <td><?= $data -> Description_type ?></td>
            </tr>
            <tr>
                <th>Chambre photo</th>
                <td>
                    <img src="../gestion_chambre/<?= $data -> Photo ?>" alt="">
                </td>
            </tr>
        </table>
        <table class="table mt-3 table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">les informations de client : </th>
            </tr>
            <tr>
                <th>Id_client</th>
                <td><?= $data -> Id_client ?></td>
            </tr>
            <tr>
                <th>Nom_complet</th>
                <td><?= $data -> Nom_complet ?></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><?= $data -> Sexe ?></td>
            </tr>
            <tr>
                <th>Date_naissance</th>
                <td><?= $data -> Date_naissance ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?= $data -> Age ?></td>
            </tr>
            <tr>
                <th>Pays</th>
                <td><?= $data -> Pays ?></td>
            </tr>
            <tr>
                <th>Ville</th>
                <td><?= $data -> Ville ?></td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td><?= $data -> Adresse ?></td>
            </tr>
            <tr>
                <th>Telephone</th>
                <td><?= $data -> Telephone ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $data -> Email ?></td>
            </tr>
        </table>
    </div>
</body>
</html>