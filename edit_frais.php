<?php
session_start();
include_once __DIR__ . '/db.php';
include 'compta_functions.php';

if (!isset($_GET['id'])) {
    header('Location: rapport.php');
    exit();
}

$id = intval($_GET['id']);

// Récupérer le frais à modifier
$stmt = $conn->prepare("SELECT * FROM frais_constitution WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$frais = $result->fetch_assoc();
$stmt->close();

if (!$frais) {
    echo "Frais introuvable.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $associe = $_POST['associe'];
    $montant = $_POST['montant'];
    
    $stmt = $conn->prepare("UPDATE frais_constitution SET associe = ?, montant = ? WHERE id = ?");
    $stmt->bind_param("sdi", $associe, $montant, $id);
    $stmt->execute();
    $stmt->close();
    
    header('Location: rapport.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Frais</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Modifier le Frais de Constitution</h1>
    <form method="POST" action="edit_frais.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label class="form-label">Associé</label>
            <input type="text" name="associe" class="form-control" value="<?php echo $frais['associe']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Montant (USD)</label>
            <input type="number" step="0.01" name="montant" class="form-control" value="<?php echo $frais['montant']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="rapport.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
