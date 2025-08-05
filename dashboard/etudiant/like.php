<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || !isset($_POST['film_id'])) {
    header('Location: parcourir.php');
    exit;
}

$user_id = $_SESSION['id_utilisateur'];
$film_id = intval($_POST['film_id']);

// Vérifier si l'utilisateur a déjà liké
$stmt = $pdo->prepare("SELECT * FROM likes WHERE id_utilisateur = ? AND id_film = ?");
$stmt->execute([$user_id, $film_id]);

if ($stmt->rowCount() === 0) {
    // Ajouter le like
    $pdo->prepare("INSERT INTO likes (id_utilisateur, id_film) VALUES (?, ?)")->execute([$user_id, $film_id]);
    $pdo->prepare("UPDATE films SET nb_likes = nb_likes + 1 WHERE id = ?")->execute([$film_id]);
}

header("Location: parcourir.php");
exit;
?>