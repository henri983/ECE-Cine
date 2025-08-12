<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';
// dashboard/etudiant/like.php

if (!isset($_SESSION['id_users']) || !isset($_POST['film_id'])) {
    header('Location: home.php');
    exit;
}

$user_id = $_SESSION['id_users'];
$film_id = intval($_POST['film_id']);

// Vérifier si l'utilisateur a déjà liké
$stmt = $pdo->prepare("SELECT * FROM likes WHERE id_users = ? AND id_film = ?");
$stmt->execute([$user_id, $film_id]);

if ($stmt->rowCount() === 0) {
    // Ajouter le like
    $pdo->prepare("INSERT INTO likes (id_users, id_film) VALUES (?, ?)")->execute([$user_id, $film_id]);
}

header("Location: parcourir.php");
exit;
?>