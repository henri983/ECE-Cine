<?php
// ici ce sont les fonctions liees aux films
function getTopFilms(PDO $pdo, int $limit =10): array{
    $stmt = $pdo->prepare("SELECT titre, realisateurs, affiche FROM films WHERE valide = 1 ORDER BY nb_likes DESC LIMIT ? ");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>