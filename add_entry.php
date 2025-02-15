<?php
// add_entry.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $journal_id = $_POST['journal_id'];
    $account_id = $_POST['account_id'];
    $piece = $conn->real_escape_string($_POST['piece']);
    $label = $conn->real_escape_string($_POST['label']);
    $debit = $_POST['debit'] ? floatval($_POST['debit']) : 0;
    $credit = $_POST['credit'] ? floatval($_POST['credit']) : 0;

    // Vérification : le débit ou le crédit doit être non nul
    if ($debit == 0 && $credit == 0) {
        $error = "Le débit ou le crédit doit être différent de zéro.";
    } else {
        $sql = "INSERT INTO entries (date, journal_id, account_id, piece, label, debit, credit) 
                VALUES ('$date', '$journal_id', '$account_id', '$piece', '$label', '$debit', '$credit')";
        if ($conn->query($sql) === TRUE) {
            $success = "Écriture ajoutée avec succès.";
        } else {
            $error = "Erreur: " . $conn->error;
        }
    }
}

// Récupération des journaux et comptes
$journals = $conn->query("SELECT * FROM journals");
$accounts = $conn->query("SELECT * FROM accounts");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Écriture - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Ajouter une Écriture Comptable</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="add_entry.php">
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Journal</label>
                <select name="journal_id" class="form-select" required>
                    <option value="">Sélectionnez un journal</option>
                    <?php while ($j = $journals->fetch_assoc()): ?>
                        <option value="<?php echo $j['id']; ?>"><?php echo $j['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Compte</label>
                <select name="account_id" class="form-select" required>
                    <option value="">Sélectionnez un compte</option>
                    <?php while ($a = $accounts->fetch_assoc()): ?>
                        <option value="<?php echo $a['id']; ?>"><?php echo $a['code'] . ' - ' . $a['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pièce</label>
                <input type="text" name="piece" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Libellé</label>
                <input type="text" name="label" class="form-control" required>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Débit</label>
                    <input type="number" step="0.01" name="debit" class="form-control" value="0">
                </div>
                <div class="col">
                    <label class="form-label">Crédit</label>
                    <input type="number" step="0.01" name="credit" class="form-control" value="0">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer l'écriture</button>
        </form>
    </div>
</body>
</html>
