<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';



if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des films partagés</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php require __DIR__ . '/../includes/header.php';?>
<h2>Validation des films partagés</h2>
<?php if(empty($films)): ?>
<p>Aucun film en attente de validation.</p>
<?php else: ?>
<ul class="list-group">
    <?php foreach($films as $film): ?>
        <li class="list-group-item">
            <strong>
                <?= htmlspecialchars($film['titre']) ?> (<?= htmlspecialchars($film['annee']) ?>)
                par <?= htmlspecialchars($film['realisateurs']) ?> 
            </strong>
            <form method="post" class="d-inline float-end">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="film_id" value="<?=$film['id'] ?>">
                <button name="action" value="valider" class="btn btn-success btn-sm">Valider</button>
                <button name="action" value="refuser" class="btn btn-danger btn-sm">Refuser</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>