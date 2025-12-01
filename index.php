<?php
// index.php
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bienvenue - Dictionnaire FR ⇄ CH</title>

  <!-- Redirection automatique en 3 secondes -->
  <meta http-equiv="refresh" content="3;url=presentation.php">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Style minimal pour écran de bienvenue -->
  <style>
      body {
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
          background: #f8f9fa;
      }
      .welcome-box {
          text-align: center;
          animation: fadein 1s ease;
      }
      h1{
        color:red;
      }
      @keyframes fadein {
          from { opacity: 0; }
          to { opacity: 1; }
      }
  </style>
</head>

<body>
  <div class="welcome-box">
      <img src="assets/img/dico.jpg" alt="logo" style="max-width:150px;margin-bottom:20px">
      <h1 class="fw-bold">Bienvenue</h1>
      <p class="lead">Dictionnaire Français ↔ Chinois</p>
      <p><small>...</small></p>
  </div>

</body>

</html>
