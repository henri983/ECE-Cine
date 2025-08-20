<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<?php require __DIR__ . '/../includes/header.php';?>
<h2>Validation des films partagés</h2>
<?php if(empty($films)): ?>
<p>Aucun film en attente de validation.</p>
<?php else: ?>
<ul class="list-group">
    <?php foreach($films as $film): ?>
        <li class="list-group-item">
            <strong>
                <?= htmlspecialchars($film['titre']) ?> (<?= htmlspecialchars($film['annee']) ?>)
                par <?= htmlspecialchars($film['realisateurs']) ?> 
            </strong>
            <form method="post" class="d-inline float-end">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="film_id" value="<?=$film['id'] ?>">
                <button name="action" value="valider" class="btn btn-success btn-sm">Valider</button>
                <button name="action" value="refuser" class="btn btn-danger btn-sm">Refuser</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>