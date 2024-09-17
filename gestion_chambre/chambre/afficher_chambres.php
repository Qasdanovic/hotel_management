<?php

include "../../connect.php" ;

$state = $connect -> query("SELECT * FROM chambre") ;
$data = $state -> fetchAll(PDO :: FETCH_OBJ) ;

$tarif = $connect -> query("SELECT * FROM tarif_chambre") ;
$capacite = $connect -> query("SELECT * FROM capacite_chambre") ;
$type = $connect -> query("SELECT * FROM type_chambre") ;

// echo $type -> rowCount() ;

$tarif = $tarif -> fetchAll(PDO :: FETCH_ASSOC) ;
$capacite = $capacite -> fetchAll(PDO :: FETCH_ASSOC) ;
$type = $type-> fetchAll(PDO :: FETCH_ASSOC) ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "../../bootstrap.php" ;
    ?>
    <title>Document</title>
</head>
<body>
<?php include "../../navbar.php" ; ?>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-9">
            <h2 class="mb-4 mx-5">list des chambres : </h2>
        </div>
            <div class="col-md-3">
                <a href="ajouter_chambre.php" class="btn btn-success text-end"><i class="bi bi-plus-circle"></i> ajouter nouveau chambre :</a>
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
                else if($_GET["alert"] == 202){
                    echo "<div class='alert alert-success'>le chambre est modifier avec success</div>" ;
                }
            }

            if (isset($_GET["delet"])){
                if ($_GET["delet"] == "oui"){
                    echo "<div class='alert alert-success'>le chambre est supprimer avec success</div>" ;
                }
                elseif($_GET["delet"] == "non"){
                    echo "<div class='alert alert-danger'><b>Opération interdite :</b> chambre déjà un objet de réservation.</div>" ;
                }
            }
    ?>
        <div class="row p-2 m-3 border border-dark">
            <div class="col-md-4">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>numero de chambre :</b></label>
                <input type="text" class="form-control mb-3" id="numero">
            </div>
            <div class="col-md-4">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>type de chambre :</b></label>
                <input type="text" class="form-control mb-3" id="type">
            </div>
            <div class="col-md-4">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>capacite de chambre :</b></label>
                <input type="text" class="form-control mb-3" id="capacite">
            </div>
        </div>
        <div class="row p-2 m-3 border border-dark">
            <div class="col-md-12">
                <label for=""><h5><b>rechercher par le prix :</b></h5></label>
            </div>
            <div class="col-md-6">
                <label for="">Minimum Prix :</label>
                <input type="number" class="form-control" id="min" value="0">
            </div>
            <div class="col-md-6">
                <label for="">Maximum Prix :</label>
                <input type="number" class="form-control" id="max" value="0">
            </div>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th class="col-1">Numéro Chambre</th>
                    <th class="col-1">Type de chambre</th>
                    <th class="col-1">prix de Nuit</th>
                    <th class="col-1">Prix de passage</th>
                    <th>Capacité de chambre</th>
                    <th>Nombre de Lits</th>
                    <th>Étage</th>
                    <th class="col-1">Nbr Adultes/Enfants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach ($data as $row ) { ?>
                    <tr>
                        <td> <?=$row->Numero_chambre ?> </td>
                        <td> <?php
                                foreach($type as $t ) :
                                    if ($t["Id_type"] == $row->Id_type){
                                        echo $t["Type_chambre"] ;
                                    }
                                endforeach ;
                            ?>
                        </td>
                        <td> <?php
                            foreach($tarif as $tar ) :
                                if ($tar["Id_tarif"] == $row->Id_tarif){
                                    echo $tar["Prix_base_nuit"] ;                                   
                                }
                            endforeach ; ?>
                        </td>

                        <td> <?php
                            foreach($tarif as $tar ) :
                                if ($tar["Id_tarif"] == $row->Id_tarif){
                                    echo $tar["Prix_base_passage"] ;                                   
                                }
                            endforeach ; ?> 
                        </td>
                        <td><?php
                                foreach($capacite as $c ) :
                                    if ($c["Id_capacite"] == $row->Id_capacite){
                                        echo $c["Titre_capacite"] . " for " . $c["Numero_capacite"] . " personnes";
                                    }
                                endforeach ;
                            ?>
                        </td>
                        <td> <?=$row->Nbr_lits_chambre ?> </td>
                        <td> <?=$row->Etage_chambre ?> </td>
                        <td> <?=$row->Nombre_adultes_enfants_ch ?> </td>
                        <td>
                            <a href="update_chambre.php?id=<?= $row -> Id_chambre ?>" class='btn btn-primary'><i class="bi bi-arrow-repeat"></i></a>
                            <a href="delete_chambre.php?id=<?= $row -> Id_chambre ?>" class='btn btn-danger'><i class="bi bi-trash3"></i></a>
                            <a href="show_chambre.php?id=<?= $row -> Id_chambre ?>" class='btn btn-warning'><i class="bi bi-info-circle"></i></i></a>
                            <a href="historique.php?id=<?= $row -> Id_chambre ?>" class='btn btn-info'><i class="bi bi-hourglass"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    let numero = document.getElementById("numero") ;
    let tbody = document.getElementById("tbody") ;
    tbody_content = tbody.innerHTML
    
    numero.addEventListener("input", function(){
        let trows = document.querySelectorAll("tbody tr")

        trows.forEach(element => {
            if (element.children[0].textContent.includes(numero.value)){
                element.style.display = "" ;
            }
            else{
                element.style.display = "none"
            }

            if (numero.value == ""){
                tbody.innerHTML = tbody_content
            }
        })
    })


    let type = document.getElementById("type") ;
    tbody_content = tbody.innerHTML
    
    type.addEventListener("input", function(){
        let trows = document.querySelectorAll("tbody tr")

        trows.forEach(element => {
            if (element.children[1].textContent.toLowerCase().includes(type.value.toLowerCase())){
                element.style.display = "" ;
            }
            else{
                element.style.display = "none"
            }

            if (type.value == ""){
                tbody.innerHTML = tbody_content
            }
        })
    })


    let capacite = document.getElementById("capacite") ;
    tbody_content = tbody.innerHTML
    
    capacite.addEventListener("input", function(){
        let trows = document.querySelectorAll("tbody tr")

        trows.forEach(element => {
            if (element.children[4].textContent.toLowerCase().includes(capacite.value.toLowerCase())){
                element.style.display = "" ;
            }
            else{
                element.style.display = "none"
            }

            if (capacite.value == ""){
                tbody.innerHTML = tbody_content
            }
        })
    })


    let min = document.getElementById("min");
    let max = document.getElementById("max");

    min.addEventListener("input", prix);
    max.addEventListener("input", prix);

    function prix() {
        let trows = document.querySelectorAll("tbody tr");
        let minValue = parseFloat(min.value) || 0;
        let maxValue = parseFloat(max.value) || Number.MAX_VALUE;

        trows.forEach(element => {
            let price = parseFloat(element.children[2].textContent);

            if (price >= minValue && price <= maxValue) {
                element.style.display = "";
            } else {
                element.style.display = "none";
            }
        });

        if (min.value === "" && max.value === "") {
            tbody.innerHTML = tbodyContent;
            trows = document.querySelectorAll("tbody tr"); 
        }
    }

    
</script>
</html>