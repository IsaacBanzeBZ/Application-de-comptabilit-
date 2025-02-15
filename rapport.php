<?php
session_start();
include 'compta_functions.php'; // contient tes fonctions calculerCapitalTotal(), genererEcritures(), etc.
global $conn;

// Récupérer les données
$capital_total = calculerCapitalTotal();
$ecritures = genererEcritures();

// On récupère aussi la liste des apports et des frais
$apportsResult = $conn->query("SELECT * FROM apports ORDER BY date_apport DESC");
$fraisResult = $conn->query("SELECT * FROM frais_constitution ORDER BY date_frais DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Comptable</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-actions {
            display: flex;
            gap: 0.5rem;
        }
        .sidebar {
            background: #1f2937; /* Couleur foncée pour la barre latérale */
            color: #fff;
            min-height: 100vh;
            padding: 1rem;
        }
        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            margin: 1rem 0;
        }
        .sidebar a:hover {
            color: #fff;
        }
        .content-wrapper {
            margin-left: 220px; /* Largeur approximative de la sidebar */
            padding: 1rem;
        }
        /* Exemple d'en-tête style nav bar en haut */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }
        .topbar h5 {
            margin: 0;
        }
    </style>
</head>
<body>

<!-- Barre latérale (sidebar) -->
<div class="sidebar position-fixed">
    <h3 class="text-white">ComptaApp</h3>
    <a href="index.php">Dashboard</a>
    <a href="nouvelle_ecriture.php">Nouvelle Écriture</a>
    <a href="rapport.php">Rapport / Journal</a>
    <a href="plan_comptable.php">Plan Comptable</a>
    <!-- ... autres liens -->
</div>

<!-- Contenu principal -->
<div class="content-wrapper">
    <!-- Top bar (optionnelle) -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5>Rapport Comptable</h5>
        <!-- Par exemple, l'utilisateur connecté -->
        <div>Connecté en tant que <strong><?php echo $_SESSION['user']['username'] ?? 'Invité'; ?></strong></div>
    </div>

    <div class="container-fluid mt-4">
        <!-- Affichage du capital total -->
        <div class="card mb-4">
            <div class="card-body">
                <h4>Capital Total : <?php echo number_format($capital_total, 2, ',', ' '); ?> USD</h4>
            </div>
        </div>

        <!-- Écritures Comptables Générées (liste textuelle) -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Écritures Comptables Générées</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach($ecritures as $ecriture) { ?>
                        <li class="list-group-item"><?php echo $ecriture; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <!-- Tableau des Apports -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Liste des Apports</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableApports" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Associé</th>
                                <th>Type</th>
                                <th>Valeur</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $apportsResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['associe']; ?></td>
                                <td><?php echo $row['type_apport']; ?></td>
                                <td><?php echo number_format($row['valeur'], 2, ',', ' '); ?></td>
                                <td><?php echo $row['date_apport']; ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="edit_apport.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="delete_apport.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet apport ?');">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau des Frais de Constitution -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Liste des Frais de Constitution</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableFrais" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Associé</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $fraisResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['associe']; ?></td>
                                <td><?php echo number_format($row['montant'], 2, ',', ' '); ?></td>
                                <td><?php echo $row['date_frais']; ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="edit_frais.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="delete_frais.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce frais ?');">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /container-fluid -->
</div><!-- /content-wrapper -->

<!-- Scripts JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function(){
    $('#tableApports').DataTable({
        // Options DataTables (langue, pagination, etc.)
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json' // version française
        }
    });
    $('#tableFrais').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
        }
    });
});
</script>
</body>
</html>
