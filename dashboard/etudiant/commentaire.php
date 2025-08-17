<?php
// ici on traite les nouveaux commentaires
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

if (!isset($_POST['id_film'], $_POST['contenu'], $_SESSION['id_users'])) {
    header('Location: index.php');
    exit;
}

$id_film = (int)$_POST['id_film'];
$contenu = trim($_POST['contenu']);
$id_user = $_SESSION['id_users'];

if ($contenu !== '') {
    $stmt = $pdo->prepare("INSERT INTO commentaires (id_film, id_users, contenu) VALUES (?, ?, ?)");
    $stmt->execute([$id_film, $id_user, $contenu]);
}

header("Location: film_details.php?id=$id_film");
exit;
?>
