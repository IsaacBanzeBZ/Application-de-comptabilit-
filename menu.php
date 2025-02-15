<?php
// menu.php
session_start();
include 'navbar.php'; // Inclut la navbar, qui sert de menu principal
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-4">

  <h1>Menu Principal</h1>
  <p>Bienvenue dans le menu de ComptaApp. Vous pouvez naviguer en utilisant les onglets ci-dessus :</p>
  <ul>
    <li><strong>Nouvelle Écriture</strong> : Saisir de nouvelles écritures comptables.</li>
    <li><strong>Rapport</strong> : Consulter les états comptables (rapport, bilan, etc.).</li>
    <li><strong>Plan Comptable</strong> : Visualiser et gérer le plan comptable complet.</li>
    <li><strong>Journal</strong> : Consulter le journal comptable détaillé.</li>
  </ul>
  <p>Ce menu est disponible en permanence et vous guide vers toutes les fonctionnalités de l'application.</p>
</div>
