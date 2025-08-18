<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: /ECE-Cine/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_film'], $_POST['contenu'])) {
    $id_film = (int) $_POST['id_film'];
    $contenu = trim($_POST['contenu']);
    $id_users = $_SESSION['id_users'];

    if ($contenu !== '') {
        // Insérer le commentaire
        $stmt = $pdo->prepare("
            INSERT INTO commentaires (id_film, id_users, contenu, created_at)
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$id_film, $id_users, htmlspecialchars($contenu)]);

        // Récupérer le titre du film pour la notif
        $filmStmt = $pdo->prepare("SELECT titre FROM film WHERE id = ?");
        $filmStmt->execute([$id_film]);
        $film = $filmStmt->fetch();

        if ($film) {
            //  Ajouter une notification
            $notif = $pdo->prepare("INSERT INTO notifications (id_users, message) VALUES (?, ?)");
            $notif->execute([
                $id_users,
                "Vous avez commenté le film : " . htmlspecialchars($film['titre'])
            ]);
        }
    }
}

// Retour à la page du film
header("Location: /ECE-Cine/parcourir.php?id=" . $id_film);
exit;
