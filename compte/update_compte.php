<?php

$id = $_GET["id"] ;

include "../connect.php" ;

$query = $connect -> prepare("SELECT * FROM users_app WHERE Id_user=?") ;
$query -> execute([$id]) ;

$data = $query -> fetch(PDO :: FETCH_OBJ) ;


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if( empty($_POST["nom"]) or empty($_POST["prenom"]) or empty($_POST["type"]) or 
        empty($_POST["username"]) or empty($_POST["password"]) or empty($_POST["etat"]) ) {
            header("location:update_compte.php?alert=404") ;
    } else {

        $requete = $connect -> prepare("UPDATE users_app SET  
                                        Nom=?,Prenom=?,Username=?,Password=?,Type=?,Etat=? 
                                        WHERE Id_user=?") ;

        $requete -> execute([
            $_POST["nom"] ,
            $_POST["prenom"] ,
            $_POST["username"] ,
            $_POST["password"] ,
            $_POST["type"] ,
            $_POST["etat"] ,
            $id
        ]) ;
        header("location:afficher_comptes.php?alert=202") ;
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
            <h2>Modifier un compte : </h2>
        </div>
    </div>
        <?php
            if (isset($_GET["alert"]) and $_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les informations !</div>" ;
                unset($_GET["alert"]) ;
            } else if(isset($_GET["alert"]) and $_GET["alert"] == 200){
                echo "<div class='alert alert-success'>le compte est modifier avec success !</div>" ;
                unset($_GET["alert"]) ;
            }
        ?>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= $data -> Nom ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $data -> Prenom ?>">
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
                    <input type="text" class="form-control" id="username" name="username" value="<?= $data -> Username ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Mot de passe</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?= $data -> Password ?>">
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
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
<script>
    let type = "<?= $data -> Type ?>" ;
    let etat = "<?= $data -> Etat ?>" ;

    let select_type = document.querySelectorAll("#type option")
    let select_etat = document.querySelectorAll("#etat option")

    select_type.forEach(op => {
        if (op.getAttribute("value") == type){
            op.selected = true
        }
    })

    select_etat.forEach(op => {
        if (op.getAttribute("value") == etat){
            op.selected = true
        }
    })
</script>
</html>