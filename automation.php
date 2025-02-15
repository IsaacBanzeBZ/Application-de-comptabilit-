<?php
// automation.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Automatisation et IA - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Automatisation et IA</h2>
        <p>Cette fonctionnalité est en cours de développement. À terme, elle comprendra :</p>
        <ul>
            <li>Génération automatique d'écritures récurrentes</li>
            <li>Rapprochement bancaire automatique</li>
            <li>Analyse prédictive des flux de trésorerie et des résultats comptables via l'IA</li>
        </ul>
        <p>Nous travaillons activement sur ces modules pour améliorer l'efficacité de la gestion comptable.</p>
    </div>
</body>
</html>
