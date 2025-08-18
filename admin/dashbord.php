<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php';

// Vérifier si admin connecté
if (!isset($_SESSION['id_users'])) {
    header("Location: ../login.php");
    exit;
}

// =============================
// SUPPRESSION
// =============================
if (isset($_POST['delete_user'])) {
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$_POST['delete_user']]);
}
if (isset($_POST['delete_film'])) {
    $pdo->prepare("DELETE FROM film WHERE id = ?")->execute([$_POST['delete_film']]);
}
if (isset($_POST['delete_comment'])) {
    $pdo->prepare("DELETE FROM commentaires WHERE id = ?")->execute([$_POST['delete_comment']]);
}
if (isset($_POST['delete_like'])) {
    $pdo->prepare("DELETE FROM likes WHERE id = ?")->execute([$_POST['delete_like']]);
}

// =============================
// AJOUT SIMPLE
// =============================
if (isset($_POST['add_user'])) {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, approuve, created_at) 
                           VALUES (?, ?, ?, 'etudiant', 1, NOW())");
    $stmt->execute([$_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
}
if (isset($_POST['add_film'])) {
    $stmt = $pdo->prepare("INSERT INTO film (titre, realisateur, url_affiche) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['titre'], $_POST['realisateur'], $_POST['url_affiche']]);
}
if (isset($_POST['add_comment'])) {
    $stmt = $pdo->prepare("INSERT INTO commentaires (id_users, id_film, contenu, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['id_users'], $_POST['id_film'], $_POST['contenu']]);
}

// =============================
// MODIFICATION DU ROLE UTILISATEUR
// =============================
if (isset($_POST['update_role'])) {
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$_POST['new_role'], $_POST['update_role']]);
}

// =============================
// RÉCUPÉRATION DES DONNÉES
// =============================
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
$films = $pdo->query("SELECT * FROM film ORDER BY titre ASC")->fetchAll();
$comments = $pdo->query("SELECT * FROM commentaires ORDER BY created_at DESC")->fetchAll();
$likes = $pdo->query("SELECT * FROM likes ORDER BY id_film ASC, id_users ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4">📊 Tableau de Bord Admin</h1>

    <!-- UTILISATEURS -->
    <h2>👤 Utilisateurs</h2>
    <form method="post" class="mb-3 d-flex gap-2">
        <input type="text" name="username" placeholder="Nom" class="form-control" required>
        <input type="email" name="email" placeholder="Email" class="form-control" required>
        <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
        <button type="submit" name="add_user" class="btn btn-success">Ajouter</button>
    </form>

    <table class="table table-striped">
        <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Inscription</th><th>Actions</th></tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <!-- Formulaire pour changer le rôle -->
                <form method="post" class="d-flex gap-2">
                    <select name="new_role" class="form-select form-select-sm">
                        <option value="etudiant" <?= $u['role'] === 'etudiant' ? 'selected' : '' ?>>Étudiant</option>
                        <option value="enseignant" <?= $u['role'] === 'enseignant' ? 'selected' : '' ?>>Enseignant</option>
                        <option value="administratif" <?= $u['role'] === 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                       
                    </select>
                    <button type="submit" name="update_role" value="<?= $u['id'] ?>" class="btn btn-sm btn-warning">Changer</button>
                </form>
            </td>
            <td><?= $u['created_at'] ?></td>
            <td>
                <form method="post" class="d-inline">
                    <button type="submit" name="delete_user" value="<?= $u['id'] ?>" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- FILMS -->
    <h2>🎬 Films</h2>
    <form method="post" class="mb-3 d-flex gap-2">
        <input type="text" name="titre" placeholder="Titre" class="form-control" required>
        <input type="text" name="realisateur" placeholder="Réalisateur" class="form-control" required>
        <input type="text" name="url_affiche" placeholder="URL affiche" class="form-control">
        <button type="submit" name="add_film" class="btn btn-success">Ajouter</button>
    </form>
    <table class="table table-striped">
        <tr><th>ID</th><th>Titre</th><th>Réalisateur</th><th>Affiche</th><th>Action</th></tr>
        <?php foreach ($films as $f): ?>
        <tr>
            <td><?= $f['id'] ?></td>
            <td><?= htmlspecialchars($f['titre']) ?></td>
            <td><?= htmlspecialchars($f['realisateur']) ?></td>
            <td><?= htmlspecialchars($f['url_affiche']) ?></td>
            <td>
                <form method="post" class="d-inline">
                    <button type="submit" name="delete_film" value="<?= $f['id'] ?>" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- COMMENTAIRES -->
    <h2>💬 Commentaires</h2>
    <form method="post" class="mb-3 d-flex gap-2">
        <input type="number" name="id_film" placeholder="ID Film" class="form-control" required>
        <textarea name="contenu" placeholder="Commentaire" class="form-control" required></textarea>
        <button type="submit" name="add_comment" class="btn btn-success">Ajouter</button>
    </form>
    <table class="table table-striped">
        <tr><th>ID</th><th>User</th><th>Film</th><th>Contenu</th><th>Date</th><th>Action</th></tr>
        <?php foreach ($comments as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['id_users'] ?></td>
            <td><?= $c['id_film'] ?></td>
            <td><?= htmlspecialchars($c['contenu']) ?></td>
            <td><?= $c['created_at'] ?></td>
            <td>
                <form method="post" class="d-inline">
                    <button type="submit" name="delete_comment" value="<?= $c['id'] ?>" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- LIKES -->
    <h2>👍 Likes</h2>
    <table class="table table-striped">
        <tr><th>ID</th><th>User</th><th>Film</th><th>Action</th></tr>
        <?php foreach ($likes as $l): ?>
        <tr>
            <td><?= $l['id'] ?></td>
            <td><?= $l['id_users'] ?></td>
            <td><?= $l['id_film'] ?></td>
            <td>
                <form method="post" class="d-inline">
                    <button type="submit" name="delete_like" value="<?= $l['id'] ?>" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
