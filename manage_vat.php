<?php
// manage_vat.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $rate = floatval($_POST['rate']);

    // Vérifier si le taux existe déjà
    $check = $conn->query("SELECT * FROM vat_rates WHERE name='$name'");
    if ($check->num_rows > 0) {
        $error = "Ce taux de TVA existe déjà.";
    } else {
        $sql = "INSERT INTO vat_rates (name, rate) VALUES ('$name', '$rate')";
        if ($conn->query($sql) === TRUE) {
            $success = "Taux de TVA ajouté avec succès.";
        } else {
            $error = "Erreur: " . $conn->error;
        }
    }
}

// Récupérer les taux de TVA
$result = $conn->query("SELECT * FROM vat_rates ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion TVA - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Gestion des Taux de TVA</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="manage_vat.php" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Nom (ex: TVA standard)" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="rate" class="form-control" placeholder="Taux (%)" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Taux (%)</th>
                    <th>Actif</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($vat = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $vat['id']; ?></td>
                        <td><?php echo $vat['name']; ?></td>
                        <td><?php echo $vat['rate']; ?></td>
                        <td><?php echo $vat['is_active'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
