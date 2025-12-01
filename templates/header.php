<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/custom.css" rel="stylesheet">
<!-- jQuery depuis CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Ton script principal -->
<script src="assets/js/main.js"></script>

<title><?= $title ?? "Dictionnaire FR - CH" ?></title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
      <!-- Logo + nom du dictionnaire -->
      <a class="navbar-brand d-flex align-items-center" href="/">
          <img src="assets/img/dico.jpg" alt="Logo Dico" style="height:40px; margin-right:10px;">
          Dico FR↔ZH
      </a>
      
      <!-- Bouton toggle pour mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link" href="Dicophp/../search.php">Rechercher</a></li>
              <li class="nav-item"><a class="nav-link" href="Dicophp/../bibliography.php">Bibliographie</a></li>
              <li class="nav-item"><a class="nav-link" href="Dicophp/../Contact.php">Contact</a></li>
          </ul>
      </div>
  </div>
</nav>


<div class="container py-4">
