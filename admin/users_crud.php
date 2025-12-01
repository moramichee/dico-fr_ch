<?php
require_once __DIR__ . '/../functions.php';
require_admin(); 

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:n,:e,:p)');
    $stmt->execute([':n'=>$nom, ':e'=>$email, ':p'=>$password]);

    header("Location: users_crud.php");
    exit;
}

if ($action === 'delete' && !empty($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM utilisateurs WHERE id=:id');
    $stmt->execute([':id'=>(int)$_GET['id']]);
    header("Location: users_crud.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM utilisateurs ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin - Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
<h3>Gestion des utilisateurs</h3>

<a href="?action=create_form" class="btn btn-success mb-3">Ajouter utilisateur</a>

<table class="table table-bordered">
<tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr>
<?php foreach($users as $u): ?>
<tr>
   <td><?= $u['id'] ?></td>
   <td><?= e($u['nom']) ?></td>
   <td><?= e($u['email']) ?></td>
   <td>
      <a class="btn btn-danger btn-sm" href="?action=delete&id=<?= $u['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
   </td>
</tr>
<?php endforeach; ?>
</table>

<?php if ($action === 'create_form'): ?>
<h4>Créer un nouvel utilisateur</h4>
<form method="post" action="?action=create">
  <input name="nom" class="form-control mb-2" placeholder="Nom" required>
  <input name="email" class="form-control mb-2" placeholder="Email" required>
  <input name="password" type="password" class="form-control mb-2" placeholder="Mot de passe" required>
  <button class="btn btn-success">Créer</button>
</form>
<?php endif; ?>

<div class="mb-3">
    <a href="dashboard.php" class="btn btn-outline-secondary">
        ← Retour au Dashboard
    </a>
</div>

</div>
</body>
</html>
