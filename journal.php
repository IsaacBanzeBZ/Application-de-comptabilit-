<?php
session_start();
include_once 'reports_functions.php';
$journalEntries = getJournal();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal Comptable</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Journal Comptable</h1>
    <a href="export_pdf.php?type=journal" class="btn btn-primary mb-3">Télécharger en PDF</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Journal ID</th>
                <th>Compte</th>
                <th>Libellé</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($journalEntries as $entry) { ?>
            <tr>
                <td><?= $entry['date'] ?></td>
                <td><?= $entry['journal_id'] ?></td>
                <td><?= $entry['account_code'] . ' - ' . $entry['account_name'] ?></td>
                <td><?= $entry['label'] ?></td>
                <td><?= $entry['debit'] ?></td>
                <td><?= $entry['credit'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
