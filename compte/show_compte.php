<?php

include "../connect.php" ;
$id = $_GET["id"] ;
$data = $connect -> query("SELECT * FROM users_app WHERE Id_user=$id") ;
$data = $data -> fetch(PDO :: FETCH_OBJ) ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row my-3">
            <a href="http://localhost/php/compte/afficher_comptes.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour</a>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <center><h2>les informations de le <?= $data -> Type ?> : <span class="text-primary"><?= $data -> Prenom ?> <?= $data -> Nom ?></span> </h3></h2>
            </div>
        </div>
        <table class="table">
            <tr>
                <th class="col-5">Id_user</th>
                <td><?= $data -> Id_user ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?= $data -> Nom ?></td>
            </tr>
            <tr>
                <th>Prenom</th>
                <td><?= $data -> Prenom ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= $data -> Username ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?= $data -> Password ?></td>
            </tr>
            <tr>
                <th>Type</th>
                <td><?= $data -> Type ?></td>
            </tr>
            <tr>
                <th>Etat</th>
                <td><?= $data -> Etat ?></td>
            </tr>
        </table>
    </div>
</body>
</html>