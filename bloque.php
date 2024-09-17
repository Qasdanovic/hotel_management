<?php
session_start() ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "bootstrap.php" ?>
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
    <div class="container mt-4">
        <div class="row mb-5">
            <div class="col-md-9"></div>
            <div class="col-md-2">
                <a href="deconnect.php" class="btn btn-danger"><i class="bi bi-box-arrow-left"></i> Deconnection</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <center><h1>WELCOME MR <b class="text-primary"><?= $_SESSION["name"] ?></b></h1></center>
            </div>
        </div>
        <div class="row mt-5">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-header"><h1><i class="bi bi-exclamation-triangle"></i> ALERT </h1></div>
                        <div>VOTRE COMPTE EST BLOQUÉ A L'INSTANT  </div>
                    </div>
                <div class="col-md-3"></div>
                </div>
        </div>
    </div>
</body>
</html>