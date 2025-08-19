<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcourir</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>
    <div class="container my-5">
        <h2 class="mb-4">Tous les films</h2>
        <?php
        //Recupere tous les films
        $stmt = $pdo->query("SELECT * FROm film ORDER BY titre ASC");
        $films = $stmt->fetchAll();
        ?>

        <?php if ($films): ?>
            <div class="row">
                <?php foreach ($films as $film): ?>
                    <div class="col-md-3">
                        <div class="card-mb-4 h-100 shadow-sm">
                          <?php if (!empty($film['url_affiche'])): ?>
                            <img src="<?= htmlspecialchars($film['url_affiche']) ?>" class="card-img-top" alt="Affiche du film">
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center p-5">Aucune affiche</div>
                        <?php endif; ?>
                        <div class="card-body d-flex">
                            <h5 class="card-title"><?= htmlspecialchars($film['titre']) ?></h5>
                            <p class="card-text mb-2">
                                <strong>Réalisateur :</strong> <?= htmlspecialchars($film['realisateur']) ?>
                            </p>
                            <a href="<?= BASE_URL ?>dashboard/etudiant/film.php?id=<?= $film['id'] ?>" class="btn btn-primary mt-auto">Voir le film</a>      
                        </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p class="text-muted">Aucun films trouvé</p>
                <?php endif; ?>
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>