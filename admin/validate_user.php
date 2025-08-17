<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';

// 🔐 Vérification connexion & rôle
if (!isset($_SESSION['id_users'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id_users']]);
$role = $stmt->fetchColumn();

if (strtolower($role) !== 'administrateur') {
    $_SESSION['error'] = "Accès refusé.";
    header("Location: ../index.php");
    exit;
}

// 🔒 CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Traitement validation utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF");
    }

    $user_id = (int) $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'approuver') {
        $pdo->prepare("UPDATE users SET approuve = 1 WHERE id = ?")->execute([$user_id]);
        $_SESSION['message'] = "Utilisateur approuvé.";
    } elseif ($action === 'refuser') {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);
        $_SESSION['message'] = "Utilisateur supprimé.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 📦 Récupérer utilisateurs en attente
$pending_users = $pdo->query("SELECT * FROM users WHERE approuve = 0 ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des utilisateurs</title>
    <link rel="stylesheet" href="/ECE-Cine/assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>

<div class="container mt-5">
    <h2>Utilisateurs en attente de validation</h2>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (count($pending_users) === 0): ?>
        <div class="alert alert-info">Aucun utilisateur en attente.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($pending_users as $user): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']) ?></strong>
                        <br><small><?= htmlspecialchars($user['email']) ?> - <?= htmlspecialchars($user['role']) ?></small>
                    </div>
                    <form method="post" class="d-flex gap-2">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button name="action" value="approuver" class="btn btn-success btn-sm">Approuver</button>
                        <button name="action" value="refuser" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">Refuser</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>