<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

// Empêche tout affichage parasite
ob_clean();

// Vérification stricte
$id_mot = filter_input(INPUT_POST, 'id_mot', FILTER_VALIDATE_INT);
$note   = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_INT);
$type   = ($_POST['type'] ?? 'fr') === 'ch' ? 'ch' : 'fr';

// Vérification des valeurs reçues
if (!$id_mot || !$note || $note < 1 || $note > 5) {
    echo json_encode([
        'success' => false,
        'message' => 'Données invalides.'
    ]);
    exit;
}

try {
    // Vérifie que la table existe et que la connexion est active
    $pdo->query("SELECT 1");

    // Insertion
    $stmt = $pdo->prepare("
        INSERT INTO notes (id_mot, type, note)
        VALUES (:id_mot, :type, :note)
    ");

    $stmt->execute([
        ':id_mot' => $id_mot,
        ':type'   => $type,
        ':note'   => $note
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Note enregistrée.'
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur : ' . $e->getMessage()
    ]);
}

exit;
?>
