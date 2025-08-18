<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit;
}

// Récupérer toutes les notifications
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE id_users = ? ORDER BY date_notification DESC");
$stmt->execute([$_SESSION['id_users']]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Marquer comme lues
$pdo->prepare("UPDATE notifications SET est_lu = 1 WHERE id_users = ?")->execute([$_SESSION['id_users']]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Notifications</title>
    <link rel="stylesheet" href="../../assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>

<div class="container my-5">
    <h2>🔔 Mes Notifications</h2>
    <?php if ($notifications): ?>
        <ul class="list-group">
            <?php foreach ($notifications as $note): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($note['message']) ?></span>
                    <small class="text-muted"><?= $note['date_notification'] ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Vous n’avez aucune notification.</p>
    <?php endif; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
