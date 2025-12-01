<?php
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages de contact</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <h2 class="mb-4">📬 Messages de contact</h2>

    <?php
    // Marquer comme lu/non lu
    if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
        $id = (int)$_GET['toggle'];
        $stmt = $pdo->prepare("UPDATE contact SET lu = NOT lu WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header('Location: admin_contact.php');
        exit;
    }

    // Supprimer un message
    if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM contact WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header('Location: admin_contact.php');
        exit;
    }

    // Récupérer tous les messages
    $stmt = $pdo->query("SELECT * FROM contact ORDER BY date_envoi DESC");
    $messages = $stmt->fetchAll();

    if (empty($messages)):
    ?>
        <div class="alert alert-info">Aucun message reçu pour le moment.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr class="<?= !$msg['lu'] ? 'table-warning' : '' ?>">
                            <td class="text-center"><?= (int)$msg['id'] ?></td>
                            <td><?= htmlspecialchars($msg['nom']) ?></td>
                            <td><?= htmlspecialchars($msg['email']) ?></td>
                            <td><?= htmlspecialchars($msg['sujet']) ?></td>
                            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                            <td class="text-center"><?= htmlspecialchars($msg['date_envoi']) ?></td>
                            <td class="text-center">
                                <span class="badge <?= $msg['lu'] ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= $msg['lu'] ? 'Lu' : 'Non lu' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="?toggle=<?= $msg['id'] ?>" class="btn btn-sm <?= $msg['lu'] ? 'btn-secondary' : 'btn-warning' ?>">
                                    <?= $msg['lu'] ? 'Marquer non lu' : 'Marquer lu' ?>
                                </a>
                                <a href="?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce message ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-outline-secondary">
                    ← Retour au Dashboard
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>


<!-- Bootstrap JS Bundle avec Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
