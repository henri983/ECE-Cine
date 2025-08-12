<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';


$notifications = $pdo->prepare("
    SELECT * FROM notifications
    WHERE id_users = ? AND est_lu = 0
    ORDER BY date_notification DESC
");
$notifications->execute([$_SESSION['id_users']]);
$messages = $notifications->fetchAll();
?>

<ul class="notifications">
  <?php foreach ($messages as $note): ?>
    <li><?= htmlspecialchars($note['message']) ?> - <?= $note['date_notification'] ?></li>
  <?php endforeach; ?>
</ul>