<?php
include "../connect.php";
$id = $_GET["id"];
$query = $connect->query("SELECT * FROM client
                            INNER JOIN reservation ON
                            client.Id_client = reservation.Id_client
                            INNER JOIN chambre ON 
                            reservation.Id_chambre = chambre.Id_chambre
                            WHERE client.Id_Client=$id");
$clients = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "../bootstrap.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Afficher client</title>
    <style>
        .black-hr {
            border-top: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-2 mt-4">
                <a href="afficher_clients.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
            <div class="col-8">
                <h1 class="align-self-center my-3 mx-2 text-info">Le registre De client :
                    <?php if ($query->rowCount() > 0) : ?>
                        <span class='text-primary'><?= $clients[0]->Nom_complet ?></span>
                    <?php endif; ?>
                </h1> 
            </div>
            <div class="col-2">
                <?php if ($query->rowCount() > 0) : ?>
                    <button id="download-pdf" class="btn btn-primary my-4">Download PDF</button>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($query->rowCount() > 0) : ?>
            <div class="pdf-content">
                <?php foreach ($clients as $client) : ?>
                    <div>
                        <h5 class="my-3">Registre du client : <b><?= $client->Nom_complet ?> </b></h5>
                        <h5 class="my-3">Période de : <b><?= $client->Date_arrivee ?></b> Au <b><?= $client->Date_depart ?></b></h5>
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-4">Id</th>
                                <td><?= $client->Id_Client ?></td>
                            </tr>
                            <tr>
                                <th>Nom complet</th>
                                <td><?= $client->Nom_complet ?></td>
                            </tr>
                            <tr>
                                <th>Sexe</th>
                                <td><?= $client->Sexe ?></td>
                            </tr>
                            <tr>
                                <th>Age</th>
                                <td><?= $client->Age ?></td>
                            </tr>
                            <tr>
                                <th>Date d’arrivée</th>
                                <td><?= $client->Date_arrivee ?></td>
                            </tr>
                            <tr>
                                <th>Date de départ</th>
                                <td><?= $client->Date_depart ?></td>
                            </tr>
                            <tr>
                                <th>Numero de Chambre</th>
                                <td><?= $client->Numero_chambre ?></td>
                            </tr>
                            <tr>
                                <th>Prix</th>
                                <td><?= $client->Montant_total ?></td>
                            </tr>
                        </table>
                        <hr class="black-hr">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <center><h3 style="margin-top: 20% !important;"><i class="bi bi-exclamation-triangle"></i> Le client n'a pas encore fait un réservation</h3></center>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            var element = document.querySelector('.pdf-content');
            var contentHeight = getContentHeight();

            var opt = {
                margin: 0.2,
                filename: 'registre_client.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait',
                    // Set the height of the PDF page to match the content height
                    height: contentHeight / 72 + 1 // Convert pixels to inches (1 inch = 72 pixels)
                }
            };

            html2pdf().from(element).set(opt).save();
        });

        function getContentHeight() {
            var contentElement = document.querySelector('.pdf-content');
            var contentHeight = contentElement.offsetHeight; // Get the total height of content in pixels
            return contentHeight;
        }
    </script>
</body>
</html>
