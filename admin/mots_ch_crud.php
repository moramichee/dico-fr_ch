<?php
require_once __DIR__ . '/../functions.php';
require_admin();

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $caractere = trim($_POST['caractere']);
    $pinyin = trim($_POST['pinyin']);
    $traduction_fr = trim($_POST['traduction_fr']);
    $exemple_fr = trim($_POST['exemple_fr']);
    $exemple_ch = trim($_POST['exemple_ch']);

    $stmt = $pdo->prepare('INSERT INTO mots_ch (caractere, pinyin, traduction_fr, exemple_fr, exemple_ch)
                           VALUES (:c, :p, :t, :ef, :ec)');
    $stmt->execute([
        ':c' => $caractere,
        ':p' => $pinyin,
        ':t' => $traduction_fr,
        ':ef' => $exemple_fr,
        ':ec' => $exemple_ch
    ]);
    header('Location: mots_ch_crud.php');
    exit;
}

if ($action === 'delete' && !empty($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM mots_ch WHERE id = :id');
    $stmt->execute([':id' => (int)$_GET['id']]);
    header('Location: mots_ch_crud.php');
    exit;
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE mots_ch 
                           SET caractere=:c, pinyin=:p, traduction_fr=:t, exemple_fr=:ef, exemple_ch=:ec 
                           WHERE id=:id');

    $stmt->execute([
        ':c' => $_POST['caractere'],
        ':p' => $_POST['pinyin'],
        ':t' => $_POST['traduction_fr'],
        ':ef' => $_POST['exemple_fr'],
        ':ec' => $_POST['exemple_ch'],
        ':id' => (int)$_POST['id']
    ]);

    header('Location: mots_ch_crud.php');
    exit;
}

// Liste
$stmt = $pdo->query('SELECT * FROM mots_ch ORDER BY id DESC LIMIT 200');
$list = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Mots Chinois</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">

<h3>Mots CH → FR</h3>
<a href="?action=create_form" class="btn btn-success mb-3">Ajouter un mot</a>

<table class="table table-striped">
<thead>
<tr><th>ID</th><th>Caractère</th><th>Pinyin</th><th>Traduction FR</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach ($list as $r): ?>
<tr>
  <td><?= $r['id'] ?></td>
  <td><?= e($r['caractere']) ?></td>
  <td><?= e($r['pinyin']) ?></td>
  <td><?= e($r['traduction_fr']) ?></td>
  <td>
    <a class="btn btn-sm btn-primary" href="?action=edit_form&id=<?= $r['id'] ?>">Éditer</a>
    <a class="btn btn-sm btn-danger" href="?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Supprimer ?');">Suppr</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($action === 'create_form'): ?>
<h4>Ajouter un mot chinois</h4>
<form method="post" action="?action=create">
  <input name="caractere" class="form-control mb-2" placeholder="Caractère chinois" required>
  <input name="pinyin" class="form-control mb-2" placeholder="Pinyin">
  <input name="traduction_fr" class="form-control mb-2" placeholder="Signification FR" required>
  <textarea name="exemple_fr" class="form-control mb-2" placeholder="Exemple FR"></textarea>
  <textarea name="exemple_ch" class="form-control mb-2" placeholder="Exemple CH"></textarea>
  <button class="btn btn-success">Ajouter</button>
</form>
<?php endif; ?>

<?php if ($action === 'edit_form' && !empty($_GET['id'])):
    $stmt = $pdo->prepare('SELECT * FROM mots_ch WHERE id = :id');
    $stmt->execute([':id'=> (int)$_GET['id']]);
    $row = $stmt->fetch();
?>
<h4>Éditer un mot chinois</h4>
<form method="post" action="?action=edit">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <input name="caractere" class="form-control mb-2" value="<?= e($row['caractere']) ?>" required>
  <input name="pinyin" class="form-control mb-2" value="<?= e($row['pinyin']) ?>">
  <input name="traduction_fr" class="form-control mb-2" value="<?= e($row['traduction_fr']) ?>" required>
  <textarea name="exemple_fr" class="form-control mb-2"><?= e($row['exemple_fr']) ?></textarea>
  <textarea name="exemple_ch" class="form-control mb-2"><?= e($row['exemple_ch']) ?></textarea>
  <button class="btn btn-primary">Enregistrer</button>
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
