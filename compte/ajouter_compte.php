<?php

include "../connect.php" ;

if (isset($_POST["send"])){
    if( empty($_POST["nom"]) or empty($_POST["prenom"]) or empty($_POST["type"]) or 
        empty($_POST["username"]) or empty($_POST["password"]) or empty($_POST["etat"]) ) {
            header("location:ajouter_compte.php?alert=404") ;
    } else {

        $requete = $connect -> prepare("INSERT INTO users_app VALUES(?,?,?,?,?,?,?)") ;

        $requete -> execute([
            null ,
            $_POST["nom"] ,
            $_POST["prenom"] ,
            $_POST["username"] ,
            $_POST["password"] ,
            $_POST["type"] ,
            $_POST["etat"]
        ]) ;

        header("location:ajouter_compte.php?alert=200") ;
    }
}

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
    <div class="row m-3">
        <div class="col-md-2"><a href="afficher_comptes.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> retour</a></div>
        <div class="col-md-7">
            <h2>ajouter un compte : </h2>
        </div>
    </div>
        <?php
            if (isset($_GET["alert"]) and $_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les informations !</div>" ;
                unset($_GET["alert"]) ;
            } else if(isset($_GET["alert"]) and $_GET["alert"] == 200){
                echo "<div class='alert alert-success'>le compte est ajouter avec success !</div>" ;
                unset($_GET["alert"]) ;
            }
        ?>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom">
                </div>
                <div class="form-group col-md-6">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type">
                    <option value="">--- saisie un type de compte ---</option>
                        <option value="Manager">Manager</option>
                        <option value="Réceptionniste">Réceptionniste</option>
                        <option value="Caissier">Caissier</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group col-md-6">
                    <label for="etat">État</label>
                    <select class="form-control" id="etat" name="etat">
                        <option value="">--- saisie un etat de compte ---</option>
                        <option value="Activé">Activé</option>
                        <option value="Bloqué">Bloqué</option>
                    </select>
                </div>
            </div>
            <button name="send" class="btn btn-primary">Ajouter un compte</button>
        </form>
    </div>
</body>
</html>