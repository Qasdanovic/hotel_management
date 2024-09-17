<?php
session_start() ;
include "../connect.php" ;


$state = $connect -> query("SELECT * FROM client") ;
$data = $state -> fetchAll(PDO :: FETCH_OBJ) ;

// echo "<pre>";
// print_r($ch) ;
// echo "</pre>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date1=date_create($_GET["depart"]);
    $date2=date_create($_GET["arrivee"]);
    $diff=date_diff($date2,$date1);
    $diff = intval($diff->format("%R%a")) ;

    if (empty($_POST["codeReservation"]) or empty($_POST["id_client"]) or $diff < 0 )
    {
        header("location:ajouter_reservation.php?alert=404") ;
    }
    else {

        $id_chambre = $_GET["id"] ;
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

        $dateArrivee = strtotime($_GET["depart"]);
        $dateDepart = strtotime($_GET["arrivee"]);
        $currentDate = time();

        $montant = $diff * $dt -> Prix_base_nuit ;
        

        $state = $connect -> prepare("INSERT INTO reservation 
                                    VALUES(?,?,?,?,?,?,?,?,?,?,?)") ;

        $etat = etat($dateArrivee, $dateDepart, $currentDate) ;

        $data = [
            null ,
            $_POST["codeReservation"] ,
            date("Y-m-d h-i-s") ,
            $_GET["arrivee"] ,
            $_GET["depart"] ,
            $diff ,
            $_GET["nbr"] ,
            $montant ,
            $etat ,
            $_POST["id_client"] ,
            $_GET["id"]
        ] ;

        try{
            $state -> execute($data) ;
        } catch(PDOException $err){
            echo $err -> getMessage() ;
        }


        header("location:ajouter_reservation.php?alert=200") ;
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
            <div class="col-md-8 d-flex">
                <a href="afficher_reservation.php" class="btn btn-danger mr-5"><i class="bi bi-arrow-return-left"> retour</i></a><h2> Completer les donner de réservation : </h2>
            </div>
        </div>
        <?php
        if (isset($_GET["alert"])){
            if ($_GET["alert"] == 404){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
            }
            else if($_GET["alert"] == 200){
                echo "<div class='alert alert-success'>nouveau reservation est ajouter avec success</div>" ;
            }
        }
    ?>
        <form method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="codeReservation">Code de réservation :</label>
                        <input type="text" class="form-control" id="codeReservation" name="codeReservation">
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="idClient">ID du client :</label>
                        <select name="id_client" id="" class="form-control">
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
            <button type="submit" class="btn btn-primary">ajouter new reservation </button>
        </form>
    </div>
</body>
</html>