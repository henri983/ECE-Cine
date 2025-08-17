<?php
session_start();
// Générer token CSRF si pas déjà présent
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/film_functions.php';

// Vérification connexion
if (!isset($_SESSION['id_users'])) {
    $_SESSION['error'] = "Accès non autorisé.";
    header('Location: ../login.php');
    exit;
}

// Vérification du rôle admin
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id_users']]);
$role = $stmt->fetchColumn();

if ($role !== 'administrateur') {
    $_SESSION['error'] = "Accès réservé à l'admin istrateur.";
    header('Location: ../index.php');
    exit;
}

$admin_message = '';

function flashMessae()
{
    if (!empty($_SESSION['message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
        unset($_SESSION['message']);
    }
    if (!empty($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
}

// Gestion des actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['manage_products'])) {
        header('Location: admin_products.php');
        exit;
    } elseif (isset($_POST['view_orders'])) {
        header('Location: admin_orders.php');
        exit;
    } elseif (isset($_POST['manage_users'])) {
        header('Location: admin_users.php');
        exit;
    } elseif (isset($_POST['approuver_utilisateur'])) {
        $id_user = (int) $_POST['id_users'];
        $stmt = $pdo->prepare("UPDATE users SET approuve = 1 WHERE id = ?");
        $stmt->execute([$id_user]);
        $admin_message = "Utilisateur approuvé avec succès.";
    } elseif (isset($_POST['valider_film'])) {
        $film_id = (int) $_POST['film_id'];
        if (validateFilm($pdo, $film_id)) {
            $_SESSION['message'] = 'Film validé.';
        }
    } elseif (isset($_POST['rejeter_film'])) {
        $film_id = (int) $_POST['film_id'];
        if (rejectFilm($pdo, $film_id)) {
            $_SESSION['message'] = 'Film rejeté.';
        }
    }
}

// Récupération des utilisateurs non approuvés
$stmt_pending = $pdo->query("SELECT * FROM users WHERE role = 'etudiant' AND approuve = 0");
$utilisateurs_non_valides = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

// Récupération des films non validés
$filmsNonValides = getUnvalidatedFilms($pdo);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panneau d'administration</title>
    <link rel="stylesheet" href="assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Panneau d'Administration</h1>
        <p class="text-center text-muted mb-4">Bienvenue, <?= htmlspecialchars($_SESSION['username'] ?? 'administrateur') ?>.</p>

        <?php if ($admin_message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($admin_message) ?></div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Gestion des Produits</h5>
                        <p class="card-text text-muted">Ajouter, modifier ou supprimer des articles du menu.</p>
                        <form method="post">
                            <button type="submit" name="manage_products" class="btn btn-primary mt-3">Gérer les produits</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Visualisation des Commandes</h5>
                        <p class="card-text text-muted">Consulter et gérer les commandes passées.</p>
                        <form method="post">
                            <button type="submit" name="view_orders" class="btn btn-success mt-3">Voir les commandes</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm text-cente
                <form method=" post" action="admin_valider_utilisateurs.php">
                    <button class="btn btn-secondary">Valider Utilisateurs</button>
                    </form>