<?php
require_once __DIR__ . '/../functions.php';
require_admin();

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $mot = trim($_POST['mot']);
    $traduction_ch = trim($_POST['traduction_ch']);
    $pinyin = trim($_POST['pinyin']);
    $exemple_fr = trim($_POST['exemple_fr']);
    $exemple_ch = trim($_POST['exemple_ch']);

    $stmt = $pdo->prepare('INSERT INTO mots_fr (mot, traduction_ch, pinyin, exemple_ch, exemple_fr) VALUES (:mot,:traduction_ch,:pinyin,:exemple_ch,:exemple_fr)');
    $stmt->execute([
        ':mot'=>$mot,':traduction_ch'=>$traduction_ch,':pinyin'=>$pinyin,':exemple_ch'=>$exemple_ch,':exemple_fr'=>$exemple_fr
    ]);
    header('Location: /admin/mots_fr_crud.php'); exit;
}

if ($action === 'delete' && !empty($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM mots_fr WHERE id = :id');
    $stmt->execute([':id' => (int)$_GET['id']]);
    header('Location: /admin/mots_fr_crud.php'); exit;
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $stmt = $pdo->prepare('UPDATE mots_fr SET mot=:mot,traduction_ch=:traduction_ch,pinyin=:pinyin,exemple_fr=:exemple_fr,exemple_ch=:exemple_ch WHERE id=:id');
    $stmt->execute([
        ':mot'=>$_POST['mot'],':traduction_ch'=>$_POST['traduction_ch'],':pinyin'=>$_POST['pinyin'],':exemple_fr'=>$_POST['exemple_fr'],':exemple_ch'=>$_POST['exemple_ch'],':id'=>$id
    ]);
    header('Location: /admin/mots_fr_crud.php'); exit;
}

$stmt = $pdo->query('SELECT * FROM mots_fr ORDER BY id DESC LIMIT 200');
$list = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Mots FR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <h3>Mots FR → CH</h3>
  <a href="?action=create_form" class="btn btn-success mb-3">Ajouter un mot</a>
  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Mot</th><th>Traduction</th><th>Pinyin</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($list as $r): ?>
        <tr>
          <td><?= (int)$r['id'] ?></td>
          <td><?= e($r['mot']) ?></td>
          <td><?= e($r['traduction_ch']) ?></td>
          <td><?= e($r['pinyin']) ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="?action=edit_form&id=<?= (int)$r['id'] ?>">Éditer</a>
            <a class="btn btn-sm btn-danger" href="?action=delete&id=<?= (int)$r['id'] ?>" onclick="return confirm('Supprimer ?')">Suppr</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php if ($action === 'create_form'): ?>
  <h4>Ajouter un mot</h4>
  <form method="post" action="?action=create">
    <input name="mot" class="form-control mb-2" placeholder="mot (fr)" required>
    <input name="traduction_ch" class="form-control mb-2" placeholder="traduction (ch)" required>
    <input name="pinyin" class="form-control mb-2" placeholder="pinyin">
    <textarea name="exemple_fr" class="form-control mb-2" placeholder="exemple en français"></textarea>
    <textarea name="exemple_ch" class="form-control mb-2" placeholder="exemple en chinois"></textarea>
    <button class="btn btn-success">Ajouter</button>
  </form>
<?php endif; ?>

<?php if ($action === 'edit_form' && !empty($_GET['id'])):
    $stmt = $pdo->prepare('SELECT * FROM mots_fr WHERE id = :id'); $stmt->execute([':id'=> (int)$_GET['id']]); $row = $stmt->fetch();
?>
  <h4>Éditer</h4>
  <form method="post" action="?action=edit">
    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
    <input name="mot" class="form-control mb-2" value="<?= e($row['mot']) ?>" required>
    <input name="traduction_ch" class="form-control mb-2" value="<?= e($row['traduction_ch']) ?>" required>
    <input name="pinyin" class="form-control mb-2" value="<?= e($row['pinyin']) ?>">
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
