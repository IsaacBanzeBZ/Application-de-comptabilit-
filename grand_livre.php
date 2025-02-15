<?php
session_start();
include_once 'reports_functions.php';
$grandLivre = getGrandLivre();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Grand Livre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Grand Livre</h1>
    <a href="export_pdf.php?type=grandlivre" class="btn btn-primary mb-3">Télécharger en PDF</a>
    
    <?php foreach ($grandLivre as $compte) { ?>
    <div class="card mb-4">
        <div class="card-header">
            <strong>Compte : <?= $compte['account']['code'] ?> - <?= $compte['account']['name'] ?></strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered mb-3">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Libellé</th>
                        <th>Débit</th>
                        <th>Crédit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($compte['entries'] as $entry) { ?>
                    <tr>
                        <td><?= $entry['date'] ?></td>
                        <td><?= $entry['label'] ?></td>
                        <td><?= $entry['debit'] ?></td>
                        <td><?= $entry['credit'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <p><strong>Total Débit : </strong><?= $compte['total_debit'] ?> | 
               <strong>Total Crédit : </strong><?= $compte['total_credit'] ?> |
               <strong>Solde : </strong><?= $compte['solde'] ?>
            </p>
        </div>
    </div>
    <?php } ?>
</div>
</body>
</html>
