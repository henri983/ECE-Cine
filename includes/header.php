<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
?>

<header>
    <div class="logo text-center py-3">
        <h2><a href="<?= BASE_URL ?>index.php" class="text-decoration-none text-dark">ECE CINE</a></h2>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>index.php">Accueil</a>
            <a class="navbar-brand" href="<?= BASE_URL ?>includes/research.php">Recherche</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">

                    <!-- Étudiant -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'etudiant'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/parcourir.php"> Parcourir</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/share.php">Partage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/notification.php"> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>etudiant/espace.php"> Mon espace</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/home.php">Accueil étudiant</a>
                        </li> -->
                    

                    <!-- Enseignant -->
                    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'enseignant'): ?>
                         <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>enseignant/cours.php"> Mes cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>enseignant/gestion_etudiants.php"> Étudiants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>enseignant/partage.php"> Partage</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>enseignant/espace.php"> Mon espace</a>
                        </li>
                       
                    <!-- Administrateur -->
                    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/dashbord.php"> Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/validate_user.php"> Gestion des utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/espace.php"> Paramètres</a>
                        </li>
                    <?php endif; ?>

                </ul>

                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['id_users'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>login.php"> Connexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php"> Déconnexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
