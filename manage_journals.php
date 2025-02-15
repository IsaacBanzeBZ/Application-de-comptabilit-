<?php
// manage_journals.php
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

    // Vérifier si le journal existe déjà
    $check = $conn->query("SELECT * FROM journals WHERE name='$name'");
    if ($check->num_rows > 0) {
        $error = "Ce journal existe déjà.";
    } else {
        $sql = "INSERT INTO journals (name) VALUES ('$name')";
        if ($conn->query($sql) === TRUE) {
            $success = "Journal ajouté avec succès.";
        } else {
            $error = "Erreur: " . $conn->error;
        }
    }
}

// Récupération des journaux
$result = $conn->query("SELECT * FROM journals ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journaux Comptables - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Journaux Comptables</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="manage_journals.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="Nom du journal" required>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du journal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($journal = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $journal['id']; ?></td>
                        <td><?php echo $journal['name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
