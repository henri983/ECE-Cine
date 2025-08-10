<?php require 'includes/header.php';?>
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
            <form method="post" class="d-line float-end">
                <input type="hidden" name="film_id" value="<?=$film['id'] ?>">
                <button name="action" value="valider" class="btn btn-success btn-sm">Valider</button>
                <button name="action" value="refuser" class="btn btn-success btn-sm">Refuser</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>