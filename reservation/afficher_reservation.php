<?php
include "../connect.php" ;


$data = $connect -> query("SELECT * FROM reservation INNER JOIN chambre 
                            ON reservation.Id_chambre = chambre.Id_chambre 
                            INNER JOIN client ON client.Id_client = reservation.Id_client") ;

$data = $data -> fetchAll(PDO :: FETCH_OBJ) ;

$client = $connect -> query("SELECT * FROM reservation INNER JOIN client 
                    ON client.Id_client = reservation.Id_client
                    ") ;

$client = $client ->fetchAll(PDO :: FETCH_OBJ) ;

// echo "<pre>";
// print_r($client) ;
// echo "</pre>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arrivee = $_POST["arrivee"];
    $depart = $_POST["depart"];

    if (!empty($arrivee) && !empty($depart)) {
        $stmt = $connect->prepare("SELECT * FROM reservation INNER JOIN chambre 
                                   ON reservation.Id_chambre = chambre.Id_chambre 
                                   INNER JOIN client ON client.Id_client = reservation.Id_client
                                   WHERE Date_arrivee BETWEEN ? AND ? AND Date_depart BETWEEN ? AND ?");
        $stmt->execute([$arrivee, $depart, $arrivee, $depart]);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        $data = $connect -> query("SELECT * FROM reservation INNER JOIN chambre 
                            ON reservation.Id_chambre = chambre.Id_chambre 
                            INNER JOIN client ON client.Id_client = reservation.Id_client") ;

        $data = $data -> fetchAll(PDO :: FETCH_OBJ) ;
    }
}

if (isset($_POST["annulle"])){
    $data = $connect -> query("SELECT * FROM reservation INNER JOIN chambre 
                            ON reservation.Id_chambre = chambre.Id_chambre 
                            INNER JOIN client ON client.Id_client = reservation.Id_client") ;

    $data = $data -> fetchAll(PDO :: FETCH_OBJ) ;


}

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
    </style>
    <?php
        include "../bootstrap.php" ;
    ?>
    <style>
        #btn{
            margin-top : 30px !important ;
        }
    </style>
    <title>Document</title>
</head>
<body>
<?php
    
    if ($_SESSION["type"] == "manager"){
        include "../nav.php" ;
    } elseif($_SESSION["type"] == "receptionniste"){
        include "../navbar.php" ;
    }

?>
    <div class="container-fluid mt-4">
        <div class="row mb-3">
            <div class="col-md-10 d-flex"><h3 class="mx-3">la liste des reservations : </h3></div>
            <?php
                if($_SESSION["type"] == "receptionniste"){ ?>
                    <div class="col-md-2"><a href="reservation1.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> ajouter un reservation</a></div>
                <?php } ?>
        </div>
        <?php
        if (isset($_GET["alert"])){
                if ($_GET["alert"] == 404){
                    echo "<div class='alert alert-danger'>veuillez saisir tout les champs</div>" ;
                }
                else if($_GET["alert"] == 200){
                    echo "<div class='alert alert-success'>le reservation est modifier avec success</div>" ;
                }
                elseif($_GET["alert"] == 202){
                    echo "<div class='alert alert-success'>le reservation est supprimer avec success</div>" ;
                }
                
            }
        ?>

        <div class="row border border-dark m-3">
            <div class="col-md-4 my-3">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>l'etat</b> de reservation : </label>
                <select id="etat" class="form-control">
                    <option value="">--- choisir un etat de reservation :  ---</option>
                    <option value="Planifiee">Planifiee</option>
                    <option value="En cours">En cours</option>
                    <option value="Terminee">Terminee</option>
                </select>
            </div>
            <div class="col-md-4 my-3">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>client</b> :</label>
                <select name="clients" id="select_client" class="form-control">
                    <option value="">--- selectionnez un client : ---</option>
                    <?php foreach($client as $c) : ?>
                        <option value="<?= $c -> Id_client ?>"><?= $c -> Nom_complet ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-4 my-3">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>chambre</b> :</label>
                <select name="clients" id="select_chambre" class="form-control">
                    <option value="">--- selectionnez un chambre : ---</option>
                    <?php foreach($data as $ch) : ?>
                        <option value="<?= $ch -> Id_chambre ?>"><?= $ch -> Numero_chambre ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            
        </div>

        <form method="post">
            <div class="row p-2 m-3 border border-dark">
                <div class="col-md-12">
                    <label for=""><h5><b>rechercher par la date :</b></h5></label>
                </div>
                <div class="col-md-4">
                    <label for="">date arrivee :</label>
                    <input type="date" class="form-control" name="arrivee">
                </div>
                <div class="col-md-4">
                    <label for="">date depart :</label>
                    <input type="date" class="form-control" name="depart">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" id="btn" name="search">search</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger" id="btn" name="annulle">annulé la recherche</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered text-center mb-5">
            <thead class="thead-dark">
                <th class="col-1">Code de réservation</th>
                <th class="col-1">Date de réservation</th>
                <th class="col-1">Date d’arrivée</th>
                <th class="col-1">Date de départ</th>
                <th class="col-1">Nombre des jours</th>
                <th class="col-1">etat de reservation</th>
                <th class="col-1">Nom de client</th>
                <th class="col-1">Téléphone</th>
                <th class="col-1">Numéro de la chambre</th>
                <th class="col-1">Montant total</th>
                <th>Actions</th>
            </thead>
            <tbody id="tbody">
                <?php foreach($data as $res) : ?>
                    <tr id="<?= $res -> Etat ?>" name="<?= $res -> Id_client ?>" class="<?= $res -> Id_chambre ?>">
                        <td><?= $res -> Code_reservation ?></td>
                        <td><?= $res -> Date_heure_reservation ?></td>
                        <td><?= $res -> Date_arrivee ?></td>
                        <td><?= $res -> Date_depart ?></td>
                        <td><?= $res -> Nbr_jours ?></td>
                        <td><?= $res -> Etat ?></td>
                        <td><?= $res -> Nom_complet ?></td>
                        <td><?= $res -> Telephone ?></td>
                        <td><?= $res -> Numero_chambre ?></td>
                        <td><?= $res -> Montant_total ?></td>
                        <td>
                            
                                <?php if($_SESSION["type"] == "receptionniste"){ ?>
                                        <a href="update_reservation.php?id=<?= $res -> Id_reservation ?>" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i></a>
                                        <a href="delete_reservation.php?id=<?= $res -> Id_reservation ?>" confirm="are you sure" class="btn btn-danger"><i class="bi bi-trash3"></i></a>
                                        <a href="show_reservation.php?id=<?= $res -> Id_reservation ?>" class="btn btn-warning"><i class="bi bi-info-circle"></i></a>
                                <?php }else { ?>
                                    <a href="show_reservation.php?id=<?= $res -> Id_reservation ?>" class="btn btn-warning"><i class="bi bi-info-circle">info de reservation</i></a>
                                <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
<script>

let tbody = document.getElementById("tbody");
let tbodyContent = tbody.innerHTML;

let rows = document.querySelectorAll("#tbody tr");

let select_etat = document.querySelector("select[id='etat']");

select_etat.addEventListener("change", etat);

function etat() {
    let selectedValue = select_etat.value;

    if (selectedValue === "") {
        tbody.innerHTML = tbodyContent;
        rows = document.querySelectorAll("#tbody tr");
    } else {
        rows.forEach(row => {
            if (row.getAttribute("id") === selectedValue) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
}

let select_client = document.querySelector("select[id='select_client']");

select_client.addEventListener("change", search_client);

function search_client() {
    let selectedValue = select_client.value;

    if (selectedValue === "") {
        tbody.innerHTML = tbodyContent;
        rows = document.querySelectorAll("#tbody tr");
    } else {
        rows.forEach(row => {
            if (row.getAttribute("name") === selectedValue) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
}


let select_chambre = document.querySelector("select[id='select_chambre']");

select_chambre.addEventListener("change", search_chambre);

function search_chambre() {
    let selectedValue = select_chambre.value;

    if (selectedValue === "") {
        tbody.innerHTML = tbodyContent;
        rows = document.querySelectorAll("#tbody tr");
    } else {
        rows.forEach(row => {
            if (row.getAttribute("class") === selectedValue) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
}

</script>
</html>