<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

// Vérification de la connexion à la base de données
$user_id = $_SESSION['id_users'] ?? null;

// Récupérer tous les films, triés par genre puis titre
$stmt = $pdo->query("
    SELECT f.*, 
        (SELECT COUNT(*) FROM likes l WHERE l.id_film = f.id) AS nb_likes
    FROM film f
    ORDER BY f.genre ASC, f.titre ASC
");
$films = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> ECE Ciné </title>
     <link rel="stylesheet" href="../../assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php';
?>

<div class="container mt-4">
    <h2>🎥 Tous les films partagés</h2>

    <?php
    $currentGenre = null;
    foreach ($films as $film):
        if ($film['genre'] !== $currentGenre):
            $currentGenre = $film['genre'];
            echo "<h3 class='mt-4'>" . htmlspecialchars($currentGenre) . "</h3>";
        endif;
    ?>
        <div class="row mb-4">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($film['url_affiche']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($film['titre']) ?>">
            </div>
            <div class="col-md-8">
                <h4><?= htmlspecialchars($film['titre']) ?></h4>
                <p><strong>Réalisateur</strong> : <?= htmlspecialchars($film['realisateur']) ?></p>
                <p><strong>Année</strong> : <?= htmlspecialchars($film['annee_sortie']) ?></p>
                <p><strong>Synopsis</strong> : <?= htmlspecialchars($film['synopsis']) ?></p>

                <?php if (!empty($film['trailer'])): ?>
                    <div class="ratio ratio-16x9 mb-2">
                        <iframe src="<?= htmlspecialchars($film['trailer']) ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>

                <p><strong>Likes</strong> : <?= $film['nb_likes'] ?></p>

                <?php if ($user_id): ?>
                    <form method="post" action="like.php">
                        <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                        <button type="submit" class="btn btn-outline-primary">👍 Liker</button>
                    </form>
                <?php else: ?>
                    <p><em>Connectez-vous pour liker ce film.</em></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>