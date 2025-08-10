<?php
// ici ce sont les fonctions liees aux films
function getTopFilms(PDO $pdo, int $limit = 10): array {
    $sql = "
        SELECT f.id, f.titre, f.realisateur, f.url_affiche, COUNT(l.id) AS nb_likes
        FROM film f
        LEFT JOIN likes l ON f.id = l.id_film
        GROUP BY f.id
        ORDER BY nb_likes DESC
        LIMIT ?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>