<?php
/**
 * Connexion à la base de données via PDO
 * Utilisation centralisée pour tout le site
 */

$DB_HOST = "localhost:3307";     // Hôte MySQL
$DB_NAME = "ece_cine";      // Nom de la base
$DB_USER = "root";          // Utilisateur MySQL
$DB_PASS = "";              // Mot de passe MySQL (vide par défaut sous XAMPP/MAMP)

try {
    // Création de la connexion PDO
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Erreurs en exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch par défaut en tableau associatif
            PDO::ATTR_EMULATE_PREPARES => false // Préparer les requêtes côté serveur
        ]
    );
} catch (PDOException $e) {
    // En cas d'erreur, on affiche un message et on arrête
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
 ?>