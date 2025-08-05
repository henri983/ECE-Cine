<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';

// dashboard/etudiant/share.php

// autorisation de l'afficharge 
if (isset($_POST['Ajouter'])) {
    require_once '../includes/db.php';
  if (!empty($_FILES['affiche']['name'])){
    print_r($_FILES);
    $file_name = $_FILES['affiche']['name'];
    $file_tmp = $_FILES['affiche']['tmp_name'];
    $file_size = $_FILES['affiche']['size'];
    $target_dir = 'assets/uploads/${file_name}';

    // verfication de l'extension du fichier
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    //validation de l'extension
    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        // Vérification de la taille du fichier
        if ($file_size < 5000000) { // 5MB max
            // Déplacer le fichier vers le dossier uploads
            move_uploaded_file($file_tmp, $target_dir);
        } else {
            echo "<div class='alert alert-danger'>Le fichier est trop volumineux. Taille maximale : 5MB.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Extension de fichier non autorisée. Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.</div>";
        exit;
    }
  }
 
    $titre = $_POST['titre'];
    $realisateurs = $_POST['realisateurs'];
    $theme = $_POST['theme'];
    $affiche = $_FILES['affiche']['name'];
    $trailer = $_POST['trailer'];
     

    // Déplacer le fichier d'affiche vers le dossier souhaité
    move_uploaded_file($_FILES['affiche']['tmp_name'], '../assets/uploads/' . $affiche);

    // Insertion du film dans la base de données
    $stmt = $pdo->prepare("INSERT INTO films (titre, realisateurs, theme, affiche, trailer, valide) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->execute([$titre, $realisateurs, $theme, '../assets/uploads/' . $affiche, $trailer]);

    echo "<div class='alert alert-success'>Film ajouté avec succès !</div>";
}
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

<form action="" method="post">
<div class="container mt-4">
    <h2>Partagez un film</h2>
    <div class="mb-3">
        <label for="titre" class="form-label">Titre du film</label>
        <input type="text" class="form-control" id="titre" name="titre" required>
    </div>
    <div class="mb-3">
        <label for="realisateurs" class="form-label">Réalisateur(s)</label>
        <input type="text" class="form-control" id="realisateurs" name="realisateurs" required>
    </div>
    <div class="mb-3">
        <label for="theme" class="form-label">Thème</label>
        <input type="text" class="form-control" id="theme" name="theme" required>
    </div>
    <div class="mb-3">
        <label for="affiche" class="form-label">Inserer l'affiche</label>
        <input type="file" class="form-control" id="affiche" name="affiche" required>
        <input type="submit" value="Ajouter" name="Ajouter" class="btn btn-primary mt-2">
    </div>
    <div class="mb-3">
        <label for="trailer" class="form-label">Trailer (URL)</label>
        <input type="url" class="form-control" id="trailer" name="trailer">
    </div>
    <button type="submit" class="btn btn-primary">Partager</button>
</form>

 <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
