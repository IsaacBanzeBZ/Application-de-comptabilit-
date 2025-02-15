<?php
// manage_accounts.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $conn->real_escape_string($_POST['code']);
    $name = $conn->real_escape_string($_POST['name']);
    $type = $_POST['type'];

    // Vérifier si le compte existe déjà
    $check = $conn->query("SELECT * FROM accounts WHERE code='$code'");
    if ($check->num_rows > 0) {
        $error = "Ce compte existe déjà.";
    } else {
        $sql = "INSERT INTO accounts (code, name, type) VALUES ('$code', '$name', '$type')";
        if ($conn->query($sql) === TRUE) {
            $success = "Compte ajouté avec succès.";
        } else {
            $error = "Erreur: " . $conn->error;
        }
    }
}

// Récupération des comptes
$result = $conn->query("SELECT * FROM accounts ORDER BY code ASC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plan Comptable - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Plan Comptable</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="manage_accounts.php" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="code" class="form-control" placeholder="Code" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Nom du compte" required>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select" required>
                        <option value="">Type</option>
                        <option value="Actif">Actif</option>
                        <option value="Passif">Passif</option>
                        <option value="Charge">Charge</option>
                        <option value="Produit">Produit</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($account = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $account['code']; ?></td>
                        <td><?php echo $account['name']; ?></td>
                        <td><?php echo $account['type']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
