<?php

include "../connect.php" ;

$data = $connect -> query("SELECT * FROM client") ;
$data = $data -> fetchAll(PDO :: FETCH_OBJ) ;

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
<?php include "../navbar.php" ; ?>
    <div class="container-fluid">
        <div class="row m-3">
            <div class='my-3 col-md-8'><h2><i class="bi bi-card-list"></i> la liste des clients : </h2></div>
            <div class="col-md-4">
                <a href="ajouter_client.php" class='btn btn-success col-md-6 mt-3'><i class="bi bi-person-plus-fill"></i> ajouter un client </a>
            </div>
        </div>

        <?php
                if (isset($_GET["alert"])){
                    if ($_GET["alert"] == 404){
                        echo "<div class='alert alert-danger'><b>Opération interdite :</b> Client déjà effectué des réservations </div>" ;
                    }
                    elseif ($_GET["alert"] == 200){
                        echo "<div class='alert alert-success'>le client est supprimer avec success</div>" ;
                    }
                }
        ?>

        <div class="row my-3">
            <div class="col-md-5">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>nom</b> de client : </label>
                <input type="search" name="" id="s_fullname" class="form-control" placeholder="search by full name...">
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <label for=""><i class="bi bi-search"></i> rechercher par <b>pays</b> de client : </label>
                <input type="search" name="" id="s_country" class="form-control" placeholder="search by country...">
            </div>
        </div>

      

        <table class='table table-bordered text-center my-3'>
            <thead  class="thead-dark">
                <tr>
                    <th>Id-client</th> <th>Nom-complet</th>
                    <th>Pays</th> <th>Ville</th>
                    <th>Telephone</th> <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $client){ ?>
                    <tr>
                        <td> <?= $client -> Id_Client ?> </td>
                        <td> <?= $client -> Nom_complet ?> </td>
                        <td> <?= $client -> Pays ?> </td>
                        <td> <?= $client -> Ville ?> </td>
                        <td> <?= $client -> Telephone ?> </td>
                        <td>
                            <a href="update_client.php?id=<?= $client -> Id_Client ?>" class='btn btn-primary mb-1 mx-2'>Update <i class="bi bi-arrow-counterclockwise"></i></a>
                            <a href="delete_client.php?id=<?= $client -> Id_Client ?>" class='btn btn-danger mx-2'>Delete <i class="bi bi-trash3"></i></a>
                            <a href="show_client.php?id=<?= $client -> Id_Client ?>" class='btn btn-warning mb-1 '>show info <i class="bi bi-info-circle"></i></a>
                            <a href="registre_client.php?id=<?= $client -> Id_Client ?>" class='btn btn-info mb-1 '>registre <i class="bi bi-info-circle"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    let s_fullname = document.getElementById("s_fullname")
    let s_country = document.getElementById("s_country")
    
    s_fullname.addEventListener("input", search_by_name)
    s_country.addEventListener("input", search_by_country)

    function search_by_name(){
        let tbody = document.querySelectorAll("tbody")
        tbody_content = tbody.textContent
        let trs = document.querySelectorAll("table tbody tr") ;
        trs.forEach(element => {
            if (!element.children[1].textContent.toLowerCase().includes(s_fullname.value.toLowerCase())){
                element.style.display = "none"
            }
            else{
                element.style.display = ""
            }

            if (s_fullname.value == ""){
                tbody.innerHTML = tbody_content
            }
        })
    }

    function search_by_country(){
        let tbody = document.querySelectorAll("tbody")
        tbody_content = tbody.textContent
        let trs = document.querySelectorAll("table tbody tr") ;
        trs.forEach(element => {
            if (!element.children[2].textContent.toLowerCase().includes(s_country.value.toLowerCase())){
                element.style.display = "none"
            }
            else{
                element.style.display = ""
            }

            if (s_country.value == ""){
                tbody.innerHTML = tbody_content
            }

        })
    }
</script>
</html>