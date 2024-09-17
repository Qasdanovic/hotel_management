<?php
include "../connect.php" ;

$id = $_GET["id"] ;

$state = $connect -> query("SELECT * FROM client") ;
$data = $state -> fetchAll(PDO :: FETCH_OBJ) ;

$ch = $connect -> query("SELECT * FROM chambre INNER JOIN type_chambre
                        ON chambre.Id_type = type_chambre.Id_type 
                        INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
                        ") ;
$ch = $ch -> fetchAll(PDO :: FETCH_OBJ) ;

$type = $connect -> query("SELECT * FROM type_chambre") ;
$type = $type -> fetchAll(PDO :: FETCH_OBJ) ;

$reserve = $connect -> query("SELECT * FROM reservation
                            INNER JOIN chambre ON 
                            reservation.Id_chambre = chambre.Id_chambre
                            INNER JOIN type_chambre ON 
                            type_chambre.Id_type = chambre.Id_type
                            WHERE Id_reservation = $id") ;
$reserve = $reserve -> fetch(PDO :: FETCH_OBJ) ;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date1=date_create($_POST["dateDepart"]);
    $date2=date_create($_POST["dateArrivee"]);
    $diff=date_diff($date2,$date1);
    $diff = intval($diff->format("%R%a")) ;

    if (empty($_POST["codeReservation"]) or empty($_POST["dateArrivee"]) or empty($_POST["dateDepart"])
        or empty($_POST["nbrAdultesEnfants"]) or empty($_POST["id_client"]) or empty($_POST["idChambre"])
        or $diff < 0 )
    {
        header("location:update_reservation.php?alert=404") ;
    }
    else {

        $id_chambre = $_POST["idChambre"] ;
        $st = $connect -> query("SELECT * FROM chambre INNER JOIN tarif_chambre 
                                ON chambre.Id_tarif = tarif_chambre.Id_tarif 
                                WHERE Id_chambre=$id_chambre") ;

        $dt = $st -> fetch(PDO :: FETCH_OBJ) ;

        // echo "<pre>";
        // print_r($dt) ;
        // echo "</pre>";

     
        function etat($dateArrivee, $dateDepart, $currentDate) {
            if ($dateArrivee > $currentDate && $dateDepart > $currentDate) {
                return "Planifiee"; 
            } elseif ($dateArrivee <= $currentDate && $dateDepart >= $currentDate) {
                return "En cours"; 
            } elseif ($dateArrivee < $currentDate && $dateDepart < $currentDate) {
                return "Terminee"; 
            }
        }

        $dateArrivee = strtotime($_POST["dateArrivee"]);
        $dateDepart = strtotime($_POST["dateDepart"]);
        $currentDate = time();

        $montant = $diff * $dt -> Prix_base_nuit ;
        

        $state = $connect -> prepare("UPDATE reservation SET  
        Code_reservation=?,Date_heure_reservation=?,Date_arrivee=?,
        Date_depart=?,Nbr_jours=?,Nbr_adultes_enfants=?,Montant_total=?,
        Etat=?,Id_client=?,Id_chambre=? WHERE Id_reservation=?") ;

        $etat = etat($dateArrivee, $dateDepart, $currentDate) ;

        $data = [
            $_POST["codeReservation"] ,
            date("Y-m-d h-i-s") ,
            $_POST["dateArrivee"] ,
            $_POST["dateDepart"] ,
            $diff ,
            $_POST["nbrAdultesEnfants"] ,
            $montant ,
            $etat ,
            $_POST["id_client"] ,
            $_POST["idChambre"] ,
            $id
        ] ;

        $state -> execute($data) ;

        header("location:afficher_reservation.php?alert=200") ;
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
<div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-8">
                <h2><a href="afficher_reservation.php" class="btn btn-danger mr-5"><i class="bi bi-arrow-return-left"></i> annulee</a> Modifictaion de reservation : </h2>
            </div>
            <div class="col-md-4">
                <a href="afficher_reservation.php" class="btn btn-success"><i class="bi bi-list"></i> Modification de reservation</a>
            </div>
        </div>
        <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            else if($_GET["alert"] == 200){
                echo "<div class='alert alert-success'>le reservation est modifierer avec success</div>" ;
            }
        }
    ?>
        <form method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="codeReservation">Code de réservation :</label>
                        <input type="text" class="form-control" id="codeReservation" name="codeReservation" value="<?= $reserve -> Code_reservation ?>">
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateArrivee">Date d'arrivée :</label>
                        <input type="date" class="form-control" id="dateArrivee" name="dateArrivee" value="<?= $reserve -> Date_arrivee ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateDepart">Date de départ :</label>
                        <input type="date" class="form-control" id="dateDepart" name="dateDepart" value="<?= $reserve -> Date_depart ?>">
                    </div>
                </div> 
            </div>
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nbrAdultesEnfants">Nombre d'adultes et enfants :</label>
                        <input type="number" class="form-control" id="nbrAdultesEnfants" name="nbrAdultesEnfants" min="1" value="<?= $reserve -> Nbr_adultes_enfants ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_chambre">type de chambre :</label>
                        <select type="number" class="form-control" id="type_chambre" name="type_chambre">
                            <option value="">--- selectionnez un type de chambre ---</option>
                            <?php foreach($type as $t) : ?>
                                <option value="<?= $t -> Type_chambre ?>"><?= $t -> Type_chambre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="idClient">ID du client :</label>
                        <select name="id_client" id="id_client" class="form-control">
                            <option value="">--- choisir un client : ---</option>
                            <?php
                                foreach ($data as $client) :
                            ?>
                            <option value="<?= $client -> Id_Client ?>"><?= $client -> Id_Client ?> - <?= $client -> Nom_complet ?></option>
                            <?php endforeach ; ?>
                        </select>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="idChambre">ID de la chambre :</label>
                            <select type="text" class="form-control" id="idChambre" name="idChambre">
                                <option value="">--- selectionner un chambre : ---</option>
                                <?php foreach($ch as $chambre) : ?>
                                    <option value="<?= $chambre -> Id_chambre ?>" id="<?= $chambre -> Nombre_adultes_enfants_ch ?>" class="<?= $chambre -> Type_chambre ?>">type chambre : <?= $chambre -> Type_chambre ?> pour <?= $chambre -> Nombre_adultes_enfants_ch?> personnes | Prix base nuit : <?= $chambre -> Prix_base_nuit ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary">Modifier la reservation </button>
        </form>
    </div>
</body>
<script>
    let type = "<?= $reserve -> Type_chambre ?>" ;

    let select_type = document.querySelectorAll("select[id='type_chambre'] option")

    select_type.forEach(ele => {
        if (ele.getAttribute("value") == type){
            ele.selected = true ;
        }
    })

    let id_client = "<?= $reserve -> Id_client ?>" 

    select_client = document.querySelectorAll("select[id='id_client'] option")

    select_client.forEach(ele => {
        if (ele.getAttribute("value") == id_client){
            ele.selected = true ;
        }
    })

    let id_chambre = "<?= $reserve -> Id_chambre ?>"
    select_chambre = document.querySelectorAll("select[id='idChambre'] option")

    select_chambre.forEach(ele => {
        if (ele.getAttribute("value") == id_chambre){
            ele.selected = true ;
        }
    })
</script>
</html>