<?php

include "connect.php" ;

$manager = $connect -> query("SELECT * FROM users_app WHERE Type = 'Manager'") ;
$receptionniste = $connect -> query("SELECT * FROM users_app WHERE Type = 'Réceptionniste'") ;
$client = $connect -> query("SELECT * FROM client") ;
$reservation = $connect -> query("SELECT * FROM reservation") ;
$active = $connect -> query("SELECT * FROM users_app WHERE Etat='Activé'") ;
$bloque = $connect -> query("SELECT * FROM users_app WHERE Etat='Bloqué'") ;

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
    <?php include "bootstrap.php" ?>
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
        <div class="row">
            <div class="col-md-12">
                <center><h1><i class="bi bi-person-circle"></i> WELCOME MR <b class="text-primary"><?= $_SESSION["name"] ?></b></h1></center>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-header">RESERVATIONS</div>
                        <div><?= $reservation -> rowCount() ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-header">CLIENTS</div>
                        <div><?= $client -> rowCount() ?></div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card bg-primary">
                        <div class="card-header">MANAGERS</div>
                        <div><?= $manager -> rowCount() ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-header">RECEPTIONNISTE</div>
                        <div><?= $receptionniste -> rowCount() ?></div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-header">COMPTE ACTIVE</div>
                        <div><?= $active -> rowCount() ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-secondary">
                        <div class="card-header">COMPTES BLOQUE</div>
                        <div><?= $bloque -> rowCount() ?></div>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>