<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="http://localhost/php/receptionniste.php"><i class="bi bi-database"></i> Hotel Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/gestion_chambre/chambre/afficher_chambres.php">Chambre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/client/afficher_clients.php">Client</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/reservation/afficher_reservation.php">Reservation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/gestion_chambre/tarif_chambre/list_tarifs.php">Tarif Chambre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/gestion_chambre/type_chambre/list_types.php">Type Chambre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="http://localhost/php/gestion_chambre/capacite_chambre/list_capacite.php">Capacite Chambre</a>
            </li>
            <li class="nav-item" style="margin-left : 70px ;">
                <a class="nav-link btn btn-danger text-white" id="deco" href="http://localhost/php/deconnect.php">Déconnexion <i class="bi bi-box-arrow-right"></i></a>
            </li>
        </ul>
    </div>
</nav>
<div class="mt-2 mx-4"><h4><i class="bi bi-person-circle"></i> <?= $_SESSION["type"] ?> : <b class="text-primary"><?= $_SESSION["name"] ?></b></h4></div>

