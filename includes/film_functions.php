<?php
function getUnvalidatedFilms(PDO $pdo): array{
    $stmt = $pdo->prepare("SELECT * FROM film WHERE valide = 0");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
// Fonction pour valider un film
// elle met a jour le champ 'valide' a 1 pour le film avec l'ID donné
//retourne true si la validation a réusi, au cas contraire false
function validateFilm(PDO $pdo, int $filmId): bool{
    $stmt = $pdo->prepare("UPDATE films SET valide = 1 WHERE id = ?");
    return $stmt->execute([$filmId]);
}

// fonction pour rejeter un film
// elle met a jour le champ 'valide' a 2 pour le film avec l'ID donné
// retourne true si le rejet est réussi, au cas contraire false
function rejectFilm(PDO $pdo, int $filmId): bool{
    $stmt = $pdo->prepare("UPDATE film SET valide = 2 WHERE id = ?");
    return $stmt->execute([$filmId]);
}
?>