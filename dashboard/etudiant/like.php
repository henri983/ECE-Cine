<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

// Vérification de la session et des données
if (!isset($_SESSION['id_users']) || !isset($_POST['film_id'])) {
    http_response_code(400);
    echo 'Erreur de session ou de données';
    exit;
}

$id_user = $_SESSION['id_users'];
$id_film = (int)$_POST['film_id'];

// Vérifier si le film existe
$stmt = $pdo->prepare("SELECT titre FROM film WHERE id = ?");
$stmt->execute([$id_film]);
$film = $stmt->fetch();

if (!$film) {
    echo "Film introuvable.";
    exit;
}

// Vérifier si déjà liké
$stmt = $pdo->prepare("SELECT * FROM likes WHERE id_users = ? AND id_film = ?");
$stmt->execute([$id_user, $id_film]);

if ($stmt->fetch()) {
    // Supprimer le like
    $pdo->prepare("DELETE FROM likes WHERE id_users = ? AND id_film = ?")
        ->execute([$id_user, $id_film]);

    echo 'unliked';
} else {
    // Ajouter un like
    $pdo->prepare("INSERT INTO likes (id_users, id_film) VALUES (?, ?)")
        ->execute([$id_user, $id_film]);

    // Ajouter une notification
    $notif = $pdo->prepare("INSERT INTO notifications (id_users, message) VALUES (?, ?)");
    $notif->execute([$id_user, "Vous avez liké le film : " . htmlspecialchars($film['titre'])]);

    echo 'liked';
}

// Redirection vers la page de détails du film
header("Location: parcourir.php?id=" . $id_film);
exit;
?>
