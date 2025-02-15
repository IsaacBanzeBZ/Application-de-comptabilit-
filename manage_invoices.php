<?php
// manage_invoices.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$error = '';
$success = '';

// Mise à jour du statut de la facture (par exemple, marquer comme payée)
if (isset($_GET['mark_paid'])) {
    $invoice_id = intval($_GET['mark_paid']);
    $sql = "UPDATE invoices SET status='paid' WHERE id=$invoice_id";
    if ($conn->query($sql) === TRUE) {
        $success = "Facture marquée comme payée.";
    } else {
        $error = "Erreur lors de la mise à jour: " . $conn->error;
    }
}

// Récupérer la liste des factures
$result = $conn->query("SELECT * FROM invoices ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Factures - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Liste des Factures</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Montant Total</th>
                    <th>TVA</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($invoice = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $invoice['invoice_number']; ?></td>
                        <td><?php echo $invoice['date']; ?></td>
                        <td><?php echo $invoice['client_name']; ?></td>
                        <td><?php echo number_format($invoice['total_amount'], 2, ',', ' '); ?></td>
                        <td><?php echo number_format($invoice['vat_amount'], 2, ',', ' '); ?></td>
                        <td><?php echo ucfirst($invoice['status']); ?></td>
                        <td>
                            <?php if ($invoice['status'] != 'paid'): ?>
                                <a href="manage_invoices.php?mark_paid=<?php echo $invoice['id']; ?>" class="btn btn-success btn-sm">Marquer comme payée</a>
                            <?php else: ?>
                                <span class="badge bg-success">Payée</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
