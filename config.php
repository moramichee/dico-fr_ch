<?php
// config.php
session_start();

/*
|--------------------------------------------------------------------------
| CONFIG BASE DE DONNÉES
|--------------------------------------------------------------------------
| Vous pouvez activer le mode DEBUG pour afficher les erreurs
| en cas de problème de connexion.
*/
define('DEBUG_DB', true); // mettre false en production

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'dictionnaire_fr_ch1');
define('DB_USER', 'root');
define('DB_PASS', '');

// Options PDO sécurisées
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

// Tentative de connexion
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        $options
    );
} catch (PDOException $e) {

    // Affiche l'erreur exacte seulement en mode DEBUG
    if (DEBUG_DB === true) {
        die("Erreur de connexion PDO : " . $e->getMessage());
    }

    // Message neutre en production
    die("Erreur de connexion à la base de données.");
}

/*
|--------------------------------------------------------------------------
| Fonction utilitaire : sécurisation HTML
|--------------------------------------------------------------------------
*/
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
