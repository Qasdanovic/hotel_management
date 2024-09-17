<?php

include "../../connect.php" ;

$id = $_GET["id"] ;

$ch_info = $connect -> query("SELECT * FROM chambre WHERE Id_chambre=$id") ;
$ch_info = $ch_info -> fetch(PDO :: FETCH_OBJ) ;

// echo "<pre>";
// print_r($ch_info) ;
// echo "</pre>" ;

$tarif = $connect -> query("SELECT * FROM tarif_chambre") ;
$capacite = $connect -> query("SELECT * FROM capacite_chambre") ;
$type = $connect -> query("SELECT * FROM type_chambre") ;

$tarif = $tarif -> fetchAll(PDO :: FETCH_OBJ) ;
$capacite = $capacite -> fetchAll(PDO :: FETCH_OBJ) ;
$type = $type-> fetchAll(PDO :: FETCH_OBJ) ;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["Numero_chambre"]) or empty($_POST["type"]) or empty($_POST["capacite"]) or empty($_POST["Nbr_lits_chambre"])
     or empty($_POST["Etage_chambre"]) or empty($_POST["Nombre_adultes_enfants_ch"]) or empty($_POST["tarif"])) {

        header("Location:update_chambre.php?alert=404&id=$id") ;
    }
    else {

        if (empty($_POST["img"])){
            $query = $connect -> prepare("UPDATE chambre SET 
                                            Numero_chambre=?,Nombre_adultes_enfants_ch=?,Renfort_chambre=?,
                                            Etage_chambre=?,Nbr_lits_chambre=?,Id_type=?,Id_capacite=?,Id_tarif=?
                                            WHERE Id_chambre=?") ;

            $query -> execute([
                $_POST["Numero_chambre"] ,
                $_POST["Nombre_adultes_enfants_ch"] ,
                $_POST["renfort"] ,
                $_POST["Etage_chambre"] ,
                $_POST["Nbr_lits_chambre"] ,
                $_POST["type"] ,
                $_POST["capacite"] ,
                $_POST["tarif"] ,
                $id
            ]) ;
        } else {
            $query = $connect -> prepare("UPDATE chambre SET 
                                        Numero_chambre=?,Nombre_adultes_enfants_ch=?,Renfort_chambre=?,
                                        Etage_chambre=?,Nbr_lits_chambre=?,Id_type=?,Id_capacite=?,Id_tarif=?,Photo=? 
                                        WHERE Id_chambre=?") ;

                                        $query -> execute([
                                            $_POST["Numero_chambre"] ,
                                            $_POST["Nombre_adultes_enfants_ch"] ,
                                            $_POST["renfort"] ,
                                            $_POST["Etage_chambre"] ,
                                            $_POST["Nbr_lits_chambre"] ,
                                            $_POST["type"] ,
                                            $_POST["capacite"] ,
                                            $_POST["tarif"] ,
                                            $_POST["img"] ,
                                            $id
                                            ]) ;
        }

        $query = $connect -> prepare("UPDATE chambre SET 
        Numero_chambre=?,Nombre_adultes_enfants_ch=?,Renfort_chambre=?,
        Etage_chambre=?,Nbr_lits_chambre=?,Id_type=?,Id_capacite=?,Id_tarif=?
        WHERE Id_chambre=?") ;

        $query -> execute([
            $_POST["Numero_chambre"] ,
            $_POST["Nombre_adultes_enfants_ch"] ,
            $_POST["renfort"] ,
            $_POST["Etage_chambre"] ,
            $_POST["Nbr_lits_chambre"] ,
            $_POST["type"] ,
            $_POST["capacite"] ,
            $_POST["tarif"] ,
            $id
        ]) ;

        header("Location:afficher_chambres.php?alert=202&id=$id") ;
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
    <div class="row">
            <div class="col-md-8">
                <h2><a href="afficher_chambres.php" class="btn btn-danger mr-5"><i class="bi bi-arrow-return-left"></i> annulee</a>  Modification de chambre : </h2>
            </div>
    </div>
    
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Numero_chambre">Numero Chambre</label>
                <input type="text" class="form-control" id="Numero_chambre" name="Numero_chambre" value="<?= $ch_info -> Numero_chambre ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="Nombre_adultes_enfants_ch">Nombre Adultes Enfants</label>
                <input type="number" class="form-control" id="Nombre_adultes_enfants_ch" name="Nombre_adultes_enfants_ch" value="<?= $ch_info -> Nombre_adultes_enfants_ch ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Renfort_chambre">Renfort Chambre</label>
                <select class="form-control" id="Renfort_chambre" name="renfort">
                    <option value="">---selectionnez un choix---</option>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="Etage_chambre">Etage Chambre</label>
                <input type="text" class="form-control" id="Etage_chambre" name="Etage_chambre" value="<?= $ch_info -> Etage_chambre ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Nbr_lits_chambre">Nombre de Lits</label>
                <input type="number" class="form-control" id="Nbr_lits_chambre" name="Nbr_lits_chambre" value="<?= $ch_info -> Nbr_lits_chambre ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="Id_type">Type : </label>
                <select type="text" class="form-control" id="Id_type" name="type" >
                <option value="">---selectionnez un choix---</option>
                    <?php foreach($type as $ty){ ?>
                        <option value="<?= $ty -> Id_type ?>"><?= $ty -> Type_chambre ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Id_capacite">Capacite : </label>
                <select type="text" class="form-control" id="Id_capacite" name="capacite" >
                    <option value="">---selectionnez un choix---</option>
                    <?php foreach($capacite as $c){ ?>
                        <option value="<?= $c -> Id_capacite ?>"><?= $c -> Titre_capacite ?> for <?= $c -> Numero_capacite?> personnes</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="Id_tarif">Tarif : </label>
                <select type="text" class="form-control" id="Id_tarif" name="tarif" >
                    <option value="">---selectionnez un choix---</option>
                    <?php foreach($tarif as $t) : ?>
                        <option value="<?= $t -> Id_tarif ?>">Base Night: <?= $t -> Prix_base_nuit ?> - Base Passage: <?= $t -> Prix_base_passage ?> - New Night: <?= $t -> N_Prix_nuit ?> - New Passage: <?= $t -> N_Prix_passage ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-8">
                <label for="Id_tarif">Photo : </label>
                <input type="file" class="form-control" >
            </div>
        </div>
        <button type="submit" class="btn btn-primary my-4">modifier le chambre</button>
    </form>
</div>
</body>
<script>
    let type_select = document.querySelectorAll("select[name='type'] option") ;
    let type = "<?= $ch_info -> Id_type ?>" ;

    type_select.forEach(element => {
        if (element.getAttribute("value") == type){
            element.selected = true ;
        }
    })

    let capacite_select = document.querySelectorAll("select[name='capacite'] option") ;
    let capacite = "<?= $ch_info -> Id_capacite ?>" ;

    capacite_select.forEach(element => {
        if (element.getAttribute("value") == capacite){
            element.selected = true ;
        }
    })

    let tarif_select = document.querySelectorAll("select[name='tarif'] option") ;
    let tarif = "<?= $ch_info -> Id_tarif ?>" ;

    tarif_select.forEach(element => {
        if (element.getAttribute("value") == tarif){
            element.selected = true ;
        }
    })

    let renfort_select = document.querySelectorAll("select[name='renfort'] option") ;
    renfort = "<?= $ch_info -> Renfort_chambre ?>" ;

    renfort_select.forEach(ele => {
        if (ele.getAttribute("value") == renfort){
            ele.selected = true ;
        }
    })
</script>
</html>