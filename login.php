<?php
include "connect.php" ;

$compte = $connect -> query("SELECT * FROM users_app") ;
$compte = $compte -> fetchAll(PDO :: FETCH_OBJ) ;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["username"]) or empty($_POST["password"])){
        header("location:login.php?alert=404") ;
    }
    else {

        foreach($compte as $user){
            if ($user -> Username == $_POST["username"] && $user -> Password == $_POST["password"]){
                if ($user -> Type == "Réceptionniste" && $user -> Etat == "Activé"){
                    $_SESSION["name"] = $user -> Prenom . " " . $user -> Nom ;
                    $_SESSION["type"] = "receptionniste" ;
                    $_SESSION["etat"] = $user -> Etat ;
                    header("Location:http://localhost/php/receptionniste.php") ;
                }
                
                else if ($user -> Type == "Réceptionniste" && $user -> Etat == "Bloqué"){
                    $_SESSION["name"] = $user -> Prenom . " " . $user -> Nom  ;
                    $_SESSION["type"] = "receptionniste" ;
                    $_SESSION["etat"] = $user -> Etat ;
                    header("Location:http://localhost/php/bloque.php") ;
                }

                elseif ($user -> Type == "Manager" && $user -> Etat == "Activé"){
                    $_SESSION["name"] = $user -> Prenom . " " . $user -> Nom  ;
                    $_SESSION["type"] = "manager" ;
                    $_SESSION["etat"] = $user -> Etat ;
                    header("Location:http://localhost/php/manager.php") ;
                }
            }
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
            <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 404){
                        echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
                    }
                    else if($_GET["alert"] == 505){
                        echo "<div class='alert alert-danger'>Mot de passe ou log in est incorrecte</div>" ;
                    }
                }
            ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="bi bi-database"></i> DataBase Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>