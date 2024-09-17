<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="http://localhost/php/manager.php"><i class="bi bi-database"></i> Application Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav" >
                <li class="nav-item">
                    <a class="nav-link text-light" href="http://localhost/php/reservation/afficher_reservation.php">Suivi des réservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="http://localhost/php/compte/afficher_comptes.php">Gestion des comptes utilisateurs</a>
                </li>
            </ul>
            <a class="nav-link btn btn-danger text-white" id="deco" href="http://localhost/php/deconnect.php">Déconnexion <i class="bi bi-box-arrow-right"></i></a>
        </div>
</nav>
<div><h4><i class="bi bi-person-circle"></i> <?= $_SESSION["type"] ?> : <b class="text-primary"><?= $_SESSION["name"] ?></b></h4></div>
