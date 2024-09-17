<?php
include "../connect.php" ;


$type = $connect -> query("SELECT * FROM type_chambre") ;
$type = $type -> fetchAll(PDO :: FETCH_OBJ) ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date1 = date_create($_POST["dateDepart"]);
    $date2 = date_create($_POST["dateArrivee"]);
    $diff = date_diff($date2, $date1);
    $diff = intval($diff->format("%R%a"));

    if (empty($_POST["dateArrivee"]) || empty($_POST["dateDepart"]) || empty($_POST["nbr_adults_enfants"]) || empty($_POST["type_chambre"])) {
        header("Location:http://localhost/php/reservation/reservation1.php?alert=404");
        exit();
    }

    else if ($diff < 0) {
        header("Location:http://localhost/php/reservation/reservation1.php?alert=505");
        exit();
    }

    else if ($diff > 0) {
        $datas = $connect->prepare("
            SELECT * 
            FROM chambre 
            INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
            WHERE chambre.Id_chambre NOT IN (
                SELECT reservation.Id_chambre 
                FROM reservation 
                WHERE ? BETWEEN reservation.Date_arrivee AND reservation.Date_depart
                OR ? BETWEEN reservation.Date_arrivee AND reservation.Date_depart
                OR reservation.Date_arrivee BETWEEN ? AND ?
                OR reservation.Date_depart BETWEEN ? AND ?
            )
            AND chambre.Nombre_adultes_enfants_ch >= ? 
            AND type_chambre.Type_chambre = ?
        ");

        $arrivee = $_POST['dateArrivee'];
        $depart = $_POST['dateDepart'];
        $nbr_adu = $_POST['nbr_adults_enfants'];
        $type_chambre = $_POST['type_chambre'];
        $params = [$arrivee, $depart, $arrivee, $depart, $arrivee, $depart, $nbr_adu, $type_chambre];
        $datas->execute($params);

        $data = $datas->fetchAll(PDO::FETCH_OBJ);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        img{
            width: 400px;
        }
    </style>
    <?php
     include "../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-8 d-flex">
                <a href="afficher_reservation.php" class="btn btn-danger mr-5"><i class="bi bi-arrow-return-left"> retour</i></a><h2> Ajouter une nouvelle réservation</h2>
            </div>
        </div>
        <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            elseif ($_GET["alert"] == 505 and !isset($datas)){
                echo "<div class='alert alert-danger'>les date que vous tapez est pas logique</div>" ;
            }
        }
    ?>
        <form method="post">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateArrivee">Date d'arrivée :</label>
                        <input type="date" class="form-control" id="dateArrivee" name="dateArrivee">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateDepart">Date de départ :</label>
                        <input type="date" class="form-control" id="dateDepart" name="dateDepart">
                    </div>
                </div> 

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="dateArrivee">nombre d'adultes et enfants :</label>
                        <input type="number" class="form-control" name="nbr_adults_enfants">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="dateDepart">type de chambre :</label>
                        <select class="form-control" name="type_chambre">
                            <option value="">--- Selectionner un type ---</option>
                            <?php foreach($type as $t) : ?>
                                <option value="<?= $t -> Type_chambre ?>"><?= $t -> Type_chambre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-2">
                    <button type="submit" style="margin-top: 30px !important;" class="mt-4 btn btn-primary">chercher </button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 mt-5">
                <?php
                    if (isset($datas) and $datas -> rowCount() > 0){ ?>
                        <table class="table ">
                            <tr>
                                <th>Numero chambre</th>
                                <th>Photo de chambre</th>
                                <th>type de chambre</th>
                                <th>nombre adultes et enfantes</th>
                                <th>action</th>
                            </tr>
                            <?php foreach($data as $room) : ?>
                                <tr>
                                    <td><?= $room -> Numero_chambre ?></td>
                                    <td><img src="../gestion_chambre/<?= $room -> Photo ?>" ></td>
                                    <td><?= $room -> Type_chambre ?></td>
                                    <td><?= $room -> Nombre_adultes_enfants_ch ?></td>
                                    <td><a class="btn btn-primary" href="ajouter_reservation.php?id=<?= $room -> Id_chambre ?>&arrivee=<?= $arrivee?>&depart=<?=$depart?>&nbr=<?=$nbr_adu?>&type=<?=$type?>">reserver</a></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    <?php }
                    elseif (isset($datas) and $datas -> rowCount() == 0){
                        echo "<center class='mt-5 text-danger'><h3><i class='bi bi-exclamation-triangle'></i> pas de chambre avec les donner qui vous avez donner !</h3></center>" ;
                    }
                ?>
                </div>
            </div>
        </form>
    </div>
</body>