<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';
include $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php';


// FORMULAIRE DE RECHERCHE

$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['titre']) || isset($_GET['annee']) || isset($_GET['realisateur']))) {
    $query = "SELECT * FROM film WHERE 1=1";
    $params = [];

    if (!empty($_GET['titre'])) {
        $query .= " AND titre LIKE ?";
        $params[] = "%" . $_GET['titre'] . "%";
    }
    if (!empty($_GET['annee'])) {
        $query .= " AND annee = ?";
        $params[] = $_GET['annee'];
    }
    if (!empty($_GET['realisateur'])) {
        $query .= " AND realisateur LIKE ?";
        $params[] = "%" . $_GET['realisateur'] . "%";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// AJOUT TRAILER (si admin/enseignant)

if (isset($_POST['add_trailer']) && !empty($_POST['film_id']) && !empty($_POST['trailer_url'])) {
    if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'enseignant'])) {
        $stmt = $pdo->prepare("UPDATE film SET trailer_url = ? WHERE id = ?");
        $stmt->execute([$_POST['trailer_url'], $_POST['film_id']]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de films | ECE Ciné</title>
    <link rel="stylesheet" href="/ECE-Cine/assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4">🔍 Rechercher un film</h1>

    <!-- Formulaire de recherche -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="titre" class="form-control" placeholder="Titre du film" value="<?= htmlspecialchars($_GET['titre'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <input type="number" name="annee" class="form-control" placeholder="Année" value="<?= htmlspecialchars($_GET['annee'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <input type="text" name="realisateur" class="form-control" placeholder="Réalisateur" value="<?= htmlspecialchars($_GET['realisateur'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>

    <?php if ($results): ?>
        <h3>🎬 Résultats de recherche</h3>
        <div class="row">
            <?php foreach ($results as $film): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($film['url_affiche'])): ?>
                            <img src="<?= htmlspecialchars($film['url_affiche']) ?>" class="card-img-top" alt="Affiche">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($film['titre']) ?></h5>
                            <p class="card-text"><strong>Réalisateur :</strong> <?= htmlspecialchars($film['realisateur']) ?></p>
                            <p class="card-text"><strong>Année :</strong> <?= htmlspecialchars($film['annee'] ?? 'Non précisée') ?></p>

                            <!-- Boutons -->
                            <a href="/ECE-Cine/dashboard/etudiant/parcourir.php?id=<?= $film['id'] ?>" class="btn btn-sm btn-info">Voir détails</a>

                            <?php if (isset($_SESSION['id_users'])): ?>
                                <form method="post" action="/ECE-Cine/like_film.php" class="d-inline">
                                    <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">👍 Like</button>
                                </form>
                            <?php endif; ?>

                            <!-- Ajout trailer (admin / enseignant) -->
                            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'enseignant'])): ?>
                                <form method="post" class="mt-2">
                                    <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                                    <input type="url" name="trailer_url" placeholder="Lien trailer YouTube" class="form-control form-control-sm mb-2" required>
                                    <button type="submit" name="add_trailer" class="btn btn-sm btn-warning">🎥 Ajouter trailer</button>
                                </form>
                            <?php endif; ?>

                            <!-- Affichage trailer si dispo -->
                            <?php if (!empty($film['trailer_url'])): ?>
                                <div class="mt-2">
                                    <iframe width="100%" height="200" src="<?= htmlspecialchars($film['trailer_url']) ?>" frameborder="0" allowfullscreen></iframe>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
        <p class="text-muted">Aucun film trouvé pour votre recherche.</p>
    <?php endif; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
