<?php

include "../connect.php" ;

$state = $connect -> query("SELECT * FROM users_app") ;
$data = $state -> fetchAll(PDO :: FETCH_OBJ) ;

// print_r($data) ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
                .navbar-nav {
            justify-content: center;
            width: 100%;
            margin-left : -200px ;
        }
        .navbar-brand {
            flex-grow: 1;
        }
        #deco {
            margin: auto;
        }
        .card {
            padding: 20px;
            color: white;
            font-size: 1.5rem;
            text-align: center;
        }
        .card-header {
            font-size: 1rem;
        }
        .bg-green {
            background-color: #28a745;
        }
        .bg-red {
            background-color: #dc3545;
        }
        .bg-blue {
            background-color: #17a2b8;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
    </style>
    </style>
    <?php
    include "../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
<?php include "../nav.php" ; ?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8"><h2>la list des comptes :</h2></div>
        <div class="col-md-4">
            <a class="btn-success btn" href="ajouter_compte.php"><i class="bi bi-plus-circle"></i> ajouter un compte</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 200){
                        echo "<div class='alert alert-success'><i class='bi bi-file-check'></i> le compte est supprimer avec success</div>" ;
                    }
                    else if ($_GET["alert"] == 202){
                        echo "<div class='alert alert-success'><i class='bi bi-file-check'></i> le compte est modifier avec success</div>" ;
                    }
                }
            ?>
        </div>
    </div>
        
        <table class="table table-bordered border-dark text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">État</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Type</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($data as $user) : ?>
                    <tr>
                        <td><?= $user -> Etat ?></td>
                        <td><?= $user -> Nom ?></td>
                        <td><?= $user -> Prenom ?></td>
                        <td><?= $user -> Type ?></td>
                        <td>
                            <a href="update_compte.php?id=<?= $user -> Id_user ?>" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i></a>
                            <a href="delete_compte.php?id=<?= $user -> Id_user ?>" class="btn btn-danger"><i class="bi bi-trash3"></i></a>
                            <a href="show_compte.php?id=<?= $user -> Id_user ?>" class="btn btn-warning"><i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>