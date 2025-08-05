<?php
// Connexion à la base (si ce n'est pas déjà fait dans ce fichier)
if (!isset($pdo)) {
    require_once 'includes/db.php';
}

// Récupération de l’admin principal
$stmtAdmin = $pdo->prepare("SELECT nom, prenom, email FROM utilisateurs WHERE statut = 'admin' LIMIT 1");
$stmtAdmin->execute();
$admin = $stmtAdmin->fetch();
?>

<footer class="bg-dark text-light mt-5 pt-3 pb-3">
    <div class="container text-center">
        <?php if ($admin): ?>
            <p class="mb-1">
                📩 <strong>Administrateur principal :</strong><br>
                <?= htmlspecialchars($admin['prenom']) . ' ' . htmlspecialchars($admin['nom']) ?> – 
                <a class="text-info" href="mailto:<?= htmlspecialchars($admin['email']) ?>">
                    <?= htmlspecialchars($admin['email']) ?>
                </a>
            </p>
        <?php endif; ?>
        <small>&copy; <?= date('Y') ?> ECE Ciné – Tous droits réservés</small>
    </div>
</footer>

