<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

// Récupère l'ID du film depuis l'URL
if (!isset($_GET['id'])) {
    echo "Film non spécifié.";
    exit;
}

$id_film = (int)$_GET['id'];

// Récupération des infos du film
$stmt = $pdo->prepare("SELECT * FROM film WHERE id = ?");
$stmt->execute([$id_film]);
$film = $stmt->fetch();

if (!$film) {
    echo "Film introuvable.";
    exit;
}

// Récupération du nombre de likes
$stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE id_film = ?");
$stmt->execute([$id_film]);
$nb_likes = $stmt->fetchColumn();

// Vérifie si l'utilisateur a liké
$hasLiked = false;
if (isset($_SESSION['id_users'])) {
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE id_film = ? AND id_users = ?");
    $stmt->execute([$id_film, $_SESSION['id_users']]);
    $hasLiked = $stmt->fetch() !== false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['titre']) ?>ECE Ciné</title>
    <link rel="stylesheet" href="/ECE-Cine/assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($film['url_affiche'])): ?>
                <img src="<?= htmlspecialchars($film['url_affiche']) ?>" class="img-fluid" alt="Affiche du film">
            <?php else: ?>
                <div class="bg-secondary text-white text-center p-5">Aucune affiche</div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($film['titre']) ?></h2>
            <p><strong>Réalisateur :</strong> <?= htmlspecialchars($film['realisateur']) ?></p>
            
            <?php if (isset($_SESSION['id_users'])): ?>
                <form method="post" action="/ECE-Cine/like_film.php" class="mb-3">
                    <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                    <button type="submit" class="btn btn-<?= $hasLiked ? 'danger' : 'success' ?>">
                        <?= $hasLiked ? 'Retirer Like' : 'Like' ?>
                    </button>
                    <span class="ms-2">👍 <?= $nb_likes ?></span>
                </form>
            <?php else: ?>
                <p><a href="/ECE-Cine/login.php">Connectez-vous</a> pour liker.</p>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <h4 class="mt-4">Commentaires</h4>

    <?php
    $stmt = $pdo->prepare("
        SELECT c.contenu, c.created_at, u.username 
        FROM commentaires c 
        JOIN users u ON c.id_users = u.id 
        WHERE c.id_film = ? 
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$id_film]);
    $commentaires = $stmt->fetchAll();
    ?>

    <?php if ($commentaires): ?>
        <?php foreach ($commentaires as $comment): ?>
            <div class="border p-2 mb-2">
                <strong><?= htmlspecialchars($comment['username']) ?></strong>
                <small class="text-muted"><?= $comment['created_at'] ?></small>
                <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun commentaire pour ce film.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['id_users'])): ?>
        <form method="post" action="/ECE-Cine/commentaire.php" class="mt-4">
            <input type="hidden" name="id_film" value="<?= $id_film ?>">
            <div class="mb-3">
                <textarea name="contenu" class="form-control" rows="3" required placeholder="Votre commentaire..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    <?php else: ?>
        <p><a href="/ECE-Cine/login.php">Connectez-vous</a> pour commenter.</p>
    <?php endif; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
