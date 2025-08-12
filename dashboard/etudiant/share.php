<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';

if (isset($_POST['Ajouter'])) {
    if (!empty($_FILES['affiche']['name'])) {
        $file_name = $_FILES['affiche']['name'];
        $file_tmp = $_FILES['affiche']['tmp_name'];
        $file_size = $_FILES['affiche']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $target_dir = '../../assets/uploads/' . uniqid() . '_' . basename($file_name);

        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            if ($file_size < 5000000) {
                move_uploaded_file($file_tmp, $target_dir);
            } else {
                echo "<div class='alert alert-danger'>Le fichier est trop volumineux. Taille maximale : 5MB.</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-danger'>Extension de fichier non autorisée. Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.</div>";
            exit;
        }
    } else {
        $target_dir = null;
    }

    $titre = $_POST['titre'];
    $realisateur = $_POST['realisateur'];
    $annee_sortie = $_POST['annee_sortie'];
    $genre = $_POST['genre'];
    $synopsis = $_POST['synopsis'];
    $trailer = $_POST['trailer'];
    $id_users = $_SESSION['id_users'];

    $stmt = $pdo->prepare("INSERT INTO film (titre, realisateur, annee_sortie, genre, synopsis, url_affiche, trailer, date_ajout, id_users) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->execute([$titre, $realisateur, $annee_sortie, $genre, $synopsis, $target_dir, $trailer, $id_users]);

    echo "<div class='alert alert-success'>Film ajouté avec succès !</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ECE Ciné</title>
    <link rel="stylesheet" href="../../assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>

<form action="" method="post" enctype="multipart/form-data">
<div class="container mt-4">
    <h2>Partagez un film</h2>
    <div class="mb-3">
        <label for="titre" class="form-label">Titre du film</label>
        <input type="text" class="form-control" id="titre" name="titre" required>
    </div>
    <div class="mb-3">
        <label for="realisateur" class="form-label">Réalisateur</label>
        <input type="text" class="form-control" id="realisateur" name="realisateur" required>
    </div>
    <div class="mb-3">
        <label for="annee_sortie" class="form-label">Année de sortie</label>
        <input type="text" class="form-control" id="annee_sortie" name="annee_sortie" required>
    </div>
    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" class="form-control" id="genre" name="genre" required>
    </div>
    <div class="mb-3">
        <label for="synopsis" class="form-label">Synopsis</label>
        <textarea class="form-control" id="synopsis" name="synopsis" required></textarea>
    </div>
    <div class="mb-3">
        <label for="affiche" class="form-label">Insérer l'affiche</label>
        <input type="file" class="form-control" id="affiche" name="affiche" required>
    </div>
    <div class="mb-3">
        <label for="trailer" class="form-label">Trailer (URL)</label>
        <input type="url" class="form-control" id="trailer" name="trailer">
    </div>
    <button type="submit" name="Ajouter" class="btn btn-primary">Partager</button>
</div>
</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
