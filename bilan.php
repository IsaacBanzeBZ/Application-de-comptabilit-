<?php
session_start();
include_once 'reports_functions.php';
$dataBilan = getBilan();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bilan Simplifié</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Bilan Simplifié</h1>
    <a href="export_pdf.php?type=bilan" class="btn btn-primary mb-3">Télécharger en PDF</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom du compte</th>
                <th>Type</th>
                <th>Total Débit</th>
                <th>Total Crédit</th>
                <th>Solde</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($dataBilan as $row) { ?>
            <tr>
                <td><?= $row['code'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= $row['total_debit'] ?></td>
                <td><?= $row['total_credit'] ?></td>
                <td><?= $row['solde'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
