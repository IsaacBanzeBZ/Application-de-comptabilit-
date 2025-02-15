<?php
// report_trial_balance.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Requête pour récupérer la balance comptable par compte
$sql = "SELECT a.code, a.name, a.type, 
        SUM(e.debit) AS total_debit, 
        SUM(e.credit) AS total_credit 
        FROM accounts a 
        LEFT JOIN entries e ON a.id = e.account_id 
        GROUP BY a.id 
        ORDER BY a.code ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport - Balance Comptable</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Rapport : Balance Comptable</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom du Compte</th>
                    <th>Type</th>
                    <th>Total Débit</th>
                    <th>Total Crédit</th>
                    <th>Solde</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):
                    $solde = $row['total_debit'] - $row['total_credit'];
                ?>
                    <tr>
                    <td><?php echo $row['code']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>

                    <td><?php echo number_format($row['total_debit'] ?? 0, 2, ',', ' '); ?></td>
                    <td><?php echo number_format($row['total_credit'] ?? 0, 2, ',', ' '); ?></td>
                    <td><?php echo number_format($solde ?? 0, 2, ',', ' '); ?></td>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
