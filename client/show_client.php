<?php

include "../connect.php" ;
$id = $_GET["id"] ;
$client = $connect -> query("SELECT * FROM client WHERE Id_Client=$id") ;
$client = $client -> fetch(PDO :: FETCH_OBJ) ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../bootstrap.php" ;
    ?>
    <title>Afficher client</title>
    <link rel="stylesheet" href="bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-3 mt-4">
                <a href="afficher_clients.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
            <div class="col-9">
                <h1 class="align-self-center m-3 text-info">Details De <span class="text-primary"><?=$client->Nom_complet?></span></h1> 
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
            <th>Id</th>
            <td><?=$client->Id_Client?></td>
            </tr>
            <tr>
                <th>Nom complet</th>
                <td><?=$client->Nom_complet?></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><?=$client->Sexe?></td>
            </tr>
            <tr>
                <th>Date Naissance</th>
                <td><?=$client->Date_naissance?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?=$client->Age?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?=$client->Pays?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?=$client->Ville?></td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td><?=$client->Adresse?></td>
            </tr>
            <tr>
                <th>Telephone</th>
                <td><?=$client->Telephone?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?=$client->Email?></td>
            </tr>
            <tr>
                <th>Autre details</th>
                <td><?=$client->Autres_details?></td>
            </tr>
        </table>
    </div>
</body>
</html>