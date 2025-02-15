<?php
// navbar.php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">ComptaApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="nouvelle_ecriture.php">Nouvelle Écriture</a></li>
        <li class="nav-item"><a class="nav-link" href="rapport.php">Rapport</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_accounts.php">Plan Comptable</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_journals.php">Journal</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_invoices.php">Facture</a></li>
        <!-- Ajout d'un onglet Menu -->
        <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>
