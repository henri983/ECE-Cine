<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';
// dashboard/etudiant/like.php


if (!isset($_SESSION['id_users']) || !isset($_POST['film_id'])) {
    http_response_code(400);
    echo 'Erreur de session ou de données';
    exit;
}

$id_user = $_SESSION['id_users'];
$id_film = (int)$_POST['film_id'];
// ici on verifie si le film est deja liké
$stmt->prepare("SELECT * FROM likes WHERE id_users = ? AND id_film = ?");
$stmt->execute([$id_user, $id_film]);
if ($stmt->fetch()) {
   //ici on annule le like
   $pdo->prepare("DELETE FROM likes WHERE id_users = ? AND id_film = ?")->execute([$id_user, $id_film]);
   echo'unliked';

}else{
    //ici on like le film
    $pdo->prepare("INSERT INTO likes (id_users, id_film) VALUES (?, ?)")->execute([$id_user, $id_film]);
    echo'liked';
}


header("Location: parcourir.php");
exit;
?>