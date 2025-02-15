<?php
// index.php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application de Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <!-- Section Hero -->
    <div class="hero">
        <h1>Bienvenue dans notre Application de Gestion</h1>
        <p>Gérez vos finances efficacement avec notre solution intuitive.</p>
        <p class="navigation">Veillez svp utiliser les onglets ci-dessus pour naviguer dans notre application.</p>

    </div>

    <!-- Citations Inspirantes -->
    <div class="container">
        <div class="quote">
            "Un budget vous dit où va votre argent, au lieu de se demander où il est passé, car celui qui ne suit pas
            ses comptes finit par suivre ses dettes."
        </div>
    </div>

    <!-- Sections en 3 colonnes -->
    <div class="container features">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box feature1">
                    <h3>Nouvelle écriture</h3>
                    <p>Structurez vos comptes pour une meilleure vision financière.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box feature2">
                    <h3>Rapports Détaillés</h3>
                    <p>Analysez vos finances avec des détails et rapports précis.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box feature3">
                    <h3>Budgétisation</h3>
                    <p>Planifiez vos budgets pour un avenir financier solide.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 - Tout droit reserver | application de Comptabilité | Propulsé par Vincent</p>
    </div>

</body>

</html>