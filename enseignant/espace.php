<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';




if (!isset($_SESSION['id_users'])) {
    echo "Utilisateur non connecté. Redirection en cours...";
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id_users'];

// -------------------------------------------------------------------------------------------------------------------------
$id_user = $_SESSION['id_users'];
$message = '';
$error = '';

// Récupération infos utilisateur
$stmt = $pdo->prepare("SELECT nom, username, prenom, role, photo, fond_ecran FROM users WHERE id = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    // L'utilisateur n'existe pas ou la session est invalide
    session_destroy();
    header("Location: /ECE-Cine/login.php");
    exit;
}

// Changer mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    if (!empty($_POST['new_password'])) {
        $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
            ->execute([$new_pass, $id_user]);
        $message = "Mot de passe modifié avec succès.";
    } else {
        $error = "Veuillez saisir un nouveau mot de passe.";
    }
}

// Upload photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_photo']) && isset($_FILES['photo'])) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/ECE-Cine/uploads/photos/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024;
    $file_type = $_FILES['photo']['type'];
    $file_size = $_FILES['photo']['size'];
    $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    $filename = $id_user . "_photo_" . time() . "." . $extension;
    $target_file = $target_dir . $filename;

    if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $pdo->prepare("UPDATE users SET photo = ? WHERE id = ?")
                ->execute([$filename, $id_user]);
            $message = "Photo mise à jour avec succès.";
            $user['photo'] = $filename;
        } else {
            $error = "Erreur lors de l'upload de la photo.";
        }
    } else {
        $error = "Type de fichier non autorisé ou fichier trop volumineux.";
    }
}

// Changement fond écran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_background'])) {
    $background = htmlspecialchars($_POST['background']);
    $pdo->prepare("UPDATE users SET fond_ecran = ? WHERE id = ?")
        ->execute([$background, $id_user]);
    $message = "Fond d’écran mis à jour.";
    $user['fond_ecran'] = $background;
}

// Mise à jour nom + prénom
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $pdo->prepare("UPDATE users SET nom = ?, prenom = ? WHERE id = ?")
        ->execute([$nom, $prenom, $id_user]);
    $message = "Informations mises à jour.";
    $user['nom'] = $nom;
    $user['prenom'] = $prenom;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Etudiant</title>
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>
    <div class="container mt-4">
        <h1>Bienvenue sur ECE Ciné</h1>
        <p>Vous etes actuellement connecté comme enseignant.</p>
    </div>

<!-- ------------------------------------------------------------------------------------------------------------------------ -->
<div class="container mt-4">
    <h3>Mon compte</h3>
    <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <div class="card p-3" style="background-image: url('<?= BASE_URL ?>uploads/backgrounds/<?= htmlspecialchars($user['fond_ecran'] ?? 'default.jpg') ?>'); background-size: cover;">
        <div class="d-flex align-items-center">
            <img src="<?= BASE_URL ?>uploads/photos/<?= htmlspecialchars($user['photo'] ?? 'default.png') ?>" class="rounded-circle me-3" width="100" height="100" alt="Photo de profil">
            <div>
                <h5><?= htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) ?> (<?= htmlspecialchars($user['username']) ?>)</h5>
                <p>Type : <strong><?= htmlspecialchars($user['role']) ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Formulaire infos nom/prenom -->
    <form method="POST" class="mt-3">
        <label>Nom :</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom'] ?? '') ?>">
        <label>Prénom :</label>
        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>">
        <button type="submit" name="update_info" class="btn btn-success mt-2">Mettre à jour</button>
    </form>

    <!-- Formulaire upload photo -->
    <form method="POST" enctype="multipart/form-data" class="mt-3">
        <label>Changer ma photo de profil :</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <button type="submit" name="upload_photo" class="btn btn-primary mt-2">Mettre à jour</button>
    </form>

    <!-- Formulaire changement mot de passe -->
    <form method="POST" class="mt-3">
        <label>Nouveau mot de passe :</label>
        <input type="password" name="new_password" class="form-control" required>
        <button type="submit" name="change_password" class="btn btn-warning mt-2">Changer</button>
    </form>

    <!-- Formulaire fond d’écran -->
    <form method="POST" class="mt-3">
        <label>Choisir un fond d’écran :</label>
        <select name="background" class="form-control">
            <option value="assets/images/default.jpg" <?= ($user['fond_ecran'] ?? '') === 'assets/images/default.jpg' ? 'selected' : '' ?>>Par défaut</option>
            <option value="assets/images/cinema1.jpg" <?= ($user['fond_ecran'] ?? '') === 'assets/images/cinema1.jpg' ? 'selected' : '' ?>>Cinéma 1</option>
            <option value="assets/images/cinema2.jpg" <?= ($user['fond_ecran'] ?? '') === 'assets/images/cinema2.jpg' ? 'selected' : '' ?>>Cinéma 2</option>
        </select>
        <button type="submit" name="change_background" class="btn btn-info mt-2">Appliquer</button>
    </form>
</div>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>