<?php
session_start();
include_once __DIR__ . '/db.php';
include 'compta_functions.php';

// Vérifier que l'ID est fourni
if (!isset($_GET['id'])) {
    header('Location: rapport.php');
    exit();
}

$id = intval($_GET['id']);

// Récupérer l'apport à modifier
$stmt = $conn->prepare("SELECT * FROM apports WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$apport = $result->fetch_assoc();
$stmt->close();

if (!$apport) {
    echo "Apport introuvable.";
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $associe = $_POST['associe'];
    $type = $_POST['type'];
    $valeur = $_POST['valeur'];
    
    $stmt = $conn->prepare("UPDATE apports SET associe = ?, type_apport = ?, valeur = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $associe, $type, $valeur, $id);
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
    <title>Modifier Apport</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h1>Modifier l'Apport</h1>
        <form method="POST" action="edit_apport.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">Associé</label>
                <input type="text" name="associe" class="form-control" value="<?php echo $apport['associe']; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type d'apport</label>
                <select name="type" class="form-select" required>
                    <option value="natures" <?php if($apport['type_apport'] == 'natures') echo 'selected'; ?>>Nature
                    </option>
                    <option value="numeraire" <?php if($apport['type_apport'] == 'numeraire') echo 'selected'; ?>>
                        Numéraire</option>
                </select>

            </div>
            <div class="mb-3">
                <label class="form-label">Valeur (USD)</label>
                <input type="number" step="0.01" name="valeur" class="form-control"
                    value="<?php echo $apport['valeur']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="rapport.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>

</html>