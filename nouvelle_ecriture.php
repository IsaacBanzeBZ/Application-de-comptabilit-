<?php
session_start();
require 'compta_functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nouvelle Écriture - Comptabilité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
    h1 {
        text-align: center;
        background-color: #0d6efd;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-style: italic;
        font-size: large;
    }

    .title2 {
        background-color: rgb(95, 115, 145);
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-style: italic;
        font-size: medium;
        display: inline-block;
        text-align: center;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h1>NOUVELLE ECRITURE COMPTABLE</h1>

        <!-- Formulaire pour enregistrer un apport -->
        <h2 class="title2">Enregistrer un Apport des Associés</h2>
        <form method="POST" action="nouvelle_ecriture.php">
            <div class="mb-3">
                <label class="form-label">Associé</label>
                <input type="text" name="associe" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type d'apport</label>
                <select name="type" class="form-select" required>
                    <option value="natures">Nature</option>
                    <option value="numeraire">Numeraire</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Valeur (USD)</label>
                <input type="number" step="0.01" name="valeur" class="form-control" required>
            </div>
            <button type="submit" name="enregistrer_apport"
                class="bg-primary text-white p-2 rounded-3 fst-italic fs-10 ">Enregistrer Apport</button>
        </form>

        <hr>

        <!-- Formulaire pour enregistrer un frais de constitution -->
        <h2 class="title2">Enregistrer un Frais de Constitution</h2>
        <form method="POST" action="nouvelle_ecriture.php">
            <div class="mb-3">
                <label class="form-label">Associé</label>
                <input type="text" name="associe_frais" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Montant (USD)</label>
                <input type="number" step="0.01" name="montant_frais" class="form-control" required>
            </div>
            <button type="submit" name="enregistrer_frais"
                class="bg-primary text-white p-2 rounded-3 fst-italic fs-10 ">Enregistrer Frais</button>
        </form>
    </div>

    <?php
// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enregistrer_apport'])) {
        enregistrerApport($_POST['associe'], $_POST['type'], $_POST['valeur']);
        echo "<script>alert('Apport enregistré avec succès');</script>";
    }
    if (isset($_POST['enregistrer_frais'])) {
        enregistrerFrais($_POST['associe_frais'], $_POST['montant_frais']);
        echo "<script>alert('Frais enregistré avec succès');</script>";
    }
}
?>
</body>

</html>