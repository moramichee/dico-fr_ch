<?php
require_once __DIR__ . '/../functions.php';
require_admin();

// Récupération des statistiques depuis la base de données
$stats = [];
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM mots_fr');
$stats['mots_fr'] = $stmt->fetch()['count'] ?? 0;

$stmt = $pdo->query('SELECT COUNT(*) AS count FROM mots_ch');
$stats['mots_ch'] = $stmt->fetch()['count'] ?? 0;

$stmt = $pdo->query('SELECT COUNT(*) AS count FROM utilisateurs');
$stats['users'] = $stmt->fetch()['count'] ?? 0;

// Nouveauté : compter les messages de contact
$stmt = $pdo->query('SELECT COUNT(*) AS count FROM contact');
$stats['messages'] = $stmt->fetch()['count'] ?? 0;
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Tableau de bord</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand">Admin</a>
    <div>
      <span class="me-3"><?= e($_SESSION['user_name']) ?></span>
      <a href="/admin/logout.php" class="btn btn-outline-danger btn-sm">Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <h3 class="mb-4">📊 Tableau de bord</h3>
  <div class="row g-4">
    
    <div class="col-md-3">
      <a href="mots_fr_crud.php" class="text-decoration-none">
        <div class="card shadow-sm h-100 border-start border-4 border-primary">
          <div class="card-body text-center">
            <h5 class="card-title">Mots FR → CH</h5>
            <p class="card-text">Gérer la liste des mots français vers chinois</p>
            <span class="btn btn-primary btn-sm">Accéder</span>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="mots_ch_crud.php" class="text-decoration-none">
        <div class="card shadow-sm h-100 border-start border-4 border-success">
          <div class="card-body text-center">
            <h5 class="card-title">Mots CH → FR</h5>
            <p class="card-text">Gérer la liste des mots chinois vers français</p>
            <span class="btn btn-success btn-sm">Accéder</span>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="admin_contact.php" class="text-decoration-none">
        <div class="card shadow-sm h-100 border-start border-4 border-warning">
          <div class="card-body text-center">
            <h5 class="card-title">Messages</h5>
            <p class="card-text">Consulter les messages de contact</p>
            <span class="btn btn-warning btn-sm">Accéder</span>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="users_crud.php" class="text-decoration-none">
        <div class="card shadow-sm h-100 border-start border-4 border-secondary">
          <div class="card-body text-center">
            <h5 class="card-title">Utilisateurs</h5>
            <p class="card-text">Gérer les comptes utilisateurs</p>
            <span class="btn btn-secondary btn-sm">Accéder</span>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>


  <!-- Barre de statistiques -->
  <div class="row mt-4 gy-3">
    <div class="col-md-3">
      <div class="admin-stat-box">
        <h4>Mots FR → CH</h4>
        <p><?= $stats['mots_fr'] ?></p>
        <small class="text-muted">Total de mots français</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="admin-stat-box">
        <h4>Mots CH → FR</h4>
        <p><?= $stats['mots_ch'] ?></p>
        <small class="text-muted">Total de mots chinois</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="admin-stat-box">
        <h4>Utilisateurs</h4>
        <p><?= $stats['users'] ?></p>
        <small class="text-muted">Total des comptes</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="admin-stat-box">
        <h4>Messages</h4>
        <p><?= $stats['messages'] ?></p>
        <small class="text-muted">Total messages reçus</small>
      </div>
    </div>
  </div>
</div>

<style>
.admin-stat-box {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    border-left: 5px solid #a31515;
    transition: 0.3s ease;
    text-align: center;
}
.admin-stat-box h4 {
    font-size: 1.2rem;
    margin-bottom: 8px;
    color: #a31515;
    font-weight: 600;
}
.admin-stat-box p {
    font-size: 2rem;
    margin: 0;
    font-weight: 700;
    color: #333;
}
.admin-stat-box small {
    color: #666;
}
</style>

</body>
</html>
