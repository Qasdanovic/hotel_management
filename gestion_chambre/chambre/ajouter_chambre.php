<?php

include "../../connect.php" ;

$tarif = $connect -> query("SELECT * FROM tarif_chambre") ;
$capacite = $connect -> query("SELECT * FROM capacite_chambre") ;
$type = $connect -> query("SELECT * FROM type_chambre") ;

$tarif = $tarif -> fetchAll(PDO :: FETCH_OBJ) ;
$capacite = $capacite -> fetchAll(PDO :: FETCH_OBJ) ;
$type = $type-> fetchAll(PDO :: FETCH_OBJ) ;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["Numero_chambre"]) or empty($_POST["Id_type"]) or empty($_POST["Id_capacite"]) or empty($_POST["Nbr_lits_chambre"])
     or empty($_POST["Etage_chambre"]) or empty($_POST["Nombre_adultes_enfants_ch"]) or empty($_POST["Id_tarif"])) {

        header("Location:ajouter_chambre.php?alert=404") ;
    }
    else {

        $statement = $connect -> prepare("INSERT INTO chambre VALUES(
        ?,?,?,?,?,?,?,?,?,?)") ;

        $data = [
            null ,
            $_POST["Numero_chambre"] ,
            $_POST["Nombre_adultes_enfants_ch"] ,
            $_POST["Renfort_chambre"] ,
            $_POST["Etage_chambre"] ,
            $_POST["Nbr_lits_chambre"] ,
            $_POST["Id_type"] ,
            $_POST["Id_capacite"] ,
            $_POST["Id_tarif"] ,
            "room_photos/" . $_POST["photo"] ,
        ] ;

        $statement -> execute($data) ;

        header("Location:ajouter_chambre.php?alert=200") ;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    include "../../bootstrap.php" ;
    ?>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-3">
        <div class="col-md-3">
            <a href="afficher_chambres.php" class="btn btn-danger"><i class="bi bi-arrow-90deg-left"></i> annulé </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h2>ajouter nouveau chambre : </h2>
        </div>
        <div class="col-md-4">
            <a href="afficher_chambres.php" class="btn btn-success"><i class="bi bi-list-ul"></i> afficher la liste des chambres :</a>
        </div>
    </div>
    
    <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            else if($_GET["alert"] == 200){
                echo "<div class='alert alert-success'>nouveau chambre est ajouter avec success</div>" ;
            }
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Numero_chambre">Numero Chambre</label>
                <input type="text" class="form-control" id="Numero_chambre" name="Numero_chambre" >
            </div>
            <div class="form-group col-md-6">
                <label for="Nombre_adultes_enfants_ch">Nombre Adultes Enfants</label>
                <input type="number" class="form-control" id="Nombre_adultes_enfants_ch" name="Nombre_adultes_enfants_ch" >
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Renfort_chambre">Renfort Chambre</label>
                <select class="form-control" id="Renfort_chambre" name="Renfort_chambre" >
                    <option value="">---selectionnez un choix---</option>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="Etage_chambre">Etage Chambre</label>
                <input type="text" class="form-control" id="Etage_chambre" name="Etage_chambre" >
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Nbr_lits_chambre">Nombre de Lits</label>
                <input type="number" class="form-control" id="Nbr_lits_chambre" name="Nbr_lits_chambre" >
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="photo">chambre photo : </label>
                <input type="file" class="form-control" id="photo" name="photo" >
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Id_type">Type : </label>
                <select type="text" class="form-control" id="Id_type" name="Id_type" >
                <option value="">---selectionnez un choix---</option>
                    <?php foreach($type as $ty){ ?>
                        <option value="<?= $ty -> Id_type ?>"><?= $ty -> Type_chambre ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Id_capacite">Capacite : </label>
                <select type="text" class="form-control" id="Id_capacite" name="Id_capacite" >
                    <option value="">---selectionnez un choix---</option>
                    <?php foreach($capacite as $c){ ?>
                        <option value="<?= $c -> Id_capacite ?>"><?= $c -> Titre_capacite ?> for <?= $c -> Numero_capacite?> personnes</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="Id_tarif">Tarif : </label>
                <select type="text" class="form-control" id="Id_tarif" name="Id_tarif" >
                    <option value="">---selectionnez un choix---</option>
                    <?php foreach($tarif as $t) : ?>
                        <option value="<?= $t -> Id_tarif ?>">Base Night: <?= $t -> Prix_base_nuit ?> - Base Passage: <?= $t -> Prix_base_passage ?> - New Night: <?= $t -> N_Prix_nuit ?> - New Passage: <?= $t -> N_Prix_passage ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary my-4">Add new chambre</button>
    </form>
</div>
</body>
</html>