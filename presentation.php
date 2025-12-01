<?php
// Charge l'en-tête HTML commun (template)
require_once __DIR__ . '/templates/header.php';
?>

<div class="container py-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2>Bienvenue sur le Dictionnaire Français — Chinois</h2>
      <p class="lead">Recherchez des mots français pour obtenir le caractère chinois, le pinyin, et des exemples d'usage — et l'inverse.</p>
      <a href="search.php" class="btn btn-primary btn-lg">Commencer</a>
    </div>
    <div class="col-md-6 text-center">
      <img src="assets/img/dico.jpg" alt="illustration" class="img-fluid" style="max-height:300px">
    </div>
  </div>
</div>

<?php
// Charge le pied de page HTML
require_once __DIR__ . '/templates/footer.php';
?>