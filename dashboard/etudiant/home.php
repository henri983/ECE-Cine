<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';

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

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>


<div class="container mt-4">
    <h2> Bienvenue sur ECE Ciné </h2>
    <p>ECE Ciné est un site web communautaire réservé aux membres de l’École ECE.
    Il permet à chacun de partager ses films préférés, de découvrir ceux des autres et d’interagir avec la communauté grâce à un système de like et de notifications.</p>

    <h2 class="mt-5">🎬 Sélection de la semaine</h2>

    <?php
    // Récupérer les 10 films les plus likés et validés
    $stmt = $pdo->prepare("SELECT * FROM film WHERE valide = 1 ORDER BY nb_likes DESC LIMIT 10");
    $stmt->execute();
    $films = $stmt->fetchAll();

    if (count($films) > 0): ?>
        <div id="carouselFilms" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($films as $index => $film): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($film['affiche']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($film['titre']) ?>">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                            <h5><?= htmlspecialchars($film['titre']) ?></h5>
                            <p>Réalisateur(s) : <?= htmlspecialchars($film['realisateurs']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFilms" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselFilms" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    <?php else: ?>
        <p>Aucun film à afficher pour le moment.</p>
    <?php endif; ?>
</div>



<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
