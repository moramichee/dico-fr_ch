<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/templates/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation simple
    if ($nom && $email && $sujet && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO contact (nom, email, sujet, message)
                VALUES (:nom, :email, :sujet, :message)
            ");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':sujet' => $sujet,
                ':message' => $message
            ]);
            $success = "Merci ! Votre message a été enregistré.";
        } catch (Exception $e) {
            $error = "Erreur lors de l'enregistrement du message : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez remplir tous les champs correctement et avec un email valide.";
    }
}
?>

<div class="container py-4">
    <h2>Contact & Suggestions</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="post" class="mt-3">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet</label>
            <input type="text" name="sujet" id="sujet" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php
require_once __DIR__ . '/templates/footer.php';
?>
