<?php
// add_invoice.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecte des données de la facture
    $invoice_number = $conn->real_escape_string($_POST['invoice_number']);
    $date = $_POST['date'];
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $vat_rate_id = intval($_POST['vat_rate_id']);

    // Récupération du taux de TVA sélectionné
    $vat_rate_query = $conn->query("SELECT rate FROM vat_rates WHERE id = $vat_rate_id");
    if ($vat_rate_query->num_rows > 0) {
        $vat_rate = $vat_rate_query->fetch_assoc()['rate'];
    } else {
        $vat_rate = 0;
    }

    // Traitement des articles de la facture
    $items = [];
    $total_amount = 0;
    for ($i = 1; $i <= 3; $i++) {
        $description = trim($_POST["description$i"]);
        $quantity = floatval($_POST["quantity$i"]);
        $unit_price = floatval($_POST["unit_price$i"]);
        if ($description != '' && $quantity > 0 && $unit_price > 0) {
            $item_total = $quantity * $unit_price;
            $total_amount += $item_total;
            $items[] = [
                'description' => $conn->real_escape_string($description),
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'total' => $item_total
            ];
        }
    }

    // Calcul du montant de TVA et du total général
    $vat_amount = $total_amount * $vat_rate / 100;
    $grand_total = $total_amount + $vat_amount;

    // Insertion de la facture
    $sql_invoice = "INSERT INTO invoices (invoice_number, date, client_name, total_amount, vat_amount, status) 
                    VALUES ('$invoice_number', '$date', '$client_name', '$grand_total', '$vat_amount', 'pending')";
    if ($conn->query($sql_invoice) === TRUE) {
        $invoice_id = $conn->insert_id;
        // Insertion des articles
        foreach ($items as $item) {
            $sql_item = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total)
                         VALUES ($invoice_id, '{$item['description']}', {$item['quantity']}, {$item['unit_price']}, {$item['total']})";
            $conn->query($sql_item);
        }
        $success = "Facture ajoutée avec succès. Montant total: $grand_total (TVA: $vat_amount)";
    } else {
        $error = "Erreur lors de l'ajout de la facture: " . $conn->error;
    }
}

// Récupérer les taux de TVA actifs pour le formulaire
$vat_rates_result = $conn->query("SELECT * FROM vat_rates WHERE is_active = 1 ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Facture - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Ajouter une Facture</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="add_invoice.php">
            <div class="mb-3">
                <label class="form-label">Numéro de Facture</label>
                <input type="text" name="invoice_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom du Client</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Taux de TVA</label>
                <select name="vat_rate_id" class="form-select" required>
                    <option value="">Sélectionnez un taux de TVA</option>
                    <?php while ($vat = $vat_rates_result->fetch_assoc()): ?>
                        <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name'] . ' (' . $vat['rate'] . '%)'; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <h4>Articles de la Facture</h4>
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="row g-3 mb-2">
                    <div class="col-md-5">
                        <input type="text" name="description<?php echo $i; ?>" class="form-control" placeholder="Description">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="quantity<?php echo $i; ?>" class="form-control" placeholder="Quantité" min="0" step="1">
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="unit_price<?php echo $i; ?>" class="form-control" placeholder="Prix Unitaire">
                    </div>
                </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary mt-3">Enregistrer la Facture</button>
        </form>
    </div>
</body>
</html>
