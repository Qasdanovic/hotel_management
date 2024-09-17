<?php
include "connect.php" ;

$client = $connect -> query("SELECT * FROM client") ;
$chambre = $connect -> query("SELECT * FROM chambre") ;
$reservation = $connect -> query("SELECT * FROM reservation") ;
$capacite = $connect -> query("SELECT * FROM capacite_chambre") ;
$type = $connect -> query("SELECT * FROM type_chambre") ;
$tarif = $connect -> query("SELECT * FROM tarif_chambre") ;




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "bootstrap.php" ; ?>
    <style>
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
    <title>Document</title>
</head>
<body>
    <?php
    
        if ($_SESSION["type"] == "manager"){
            include "nav.php" ;
        } elseif($_SESSION["type"] == "receptionniste"){
            include "navbar.php" ;
        }
    
    ?>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <center><h1 style="text-transform: uppercase;"><i class="bi bi-person-circle"></i> BONJOUR MONSIEUR <b class="text-primary"><?= $_SESSION["name"] ?></b></h1></center>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-green">
                    <div class="card-header"><h5><i class="bi bi-building"></i> CHAMBRES</h5></div>
                    <div><?= $chambre -> rowCount() ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-red">
                    <div class="card-header"><h5><i class="bi bi-people"></i> CLIENTS</h5></div>
                    <div><?= $client -> rowCount() ?></div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-primary">
                    <div class="card-header"><h5><i class="bi bi-stickies"></i> RESERVATIONS</h5></div>
                    <div><?= $reservation -> rowCount() ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-warning">
                    <div class="card-header"><h5><i class="bi bi-capslock"></i> CAPACITES DES CHAMBRES</div>
                    <div><?= $capacite -> rowCount() ?></div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-info">
                    <div class="card-header"><h5>TYPES DES CHAMBRES</h5></div>
                    <div><?= $type -> rowCount() ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-secondary">
                    <div class="card-header"><h5><i class="bi bi-wallet2"></i> TARIFS DES CHAMBRES</h5></div>
                    <div><?= $tarif -> rowCount() ?></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>