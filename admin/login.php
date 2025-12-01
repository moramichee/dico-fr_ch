<?php
require_once __DIR__ . '/../config.php';

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $err = 'Email ou mot de passe invalide.';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title">Connexion Admin</h4>
          <?php if ($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Mot de passe</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Se connecter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
