<?php
//on recupere l'utilisateur par son mail
function getUserByEmail($email){

    global $pdo;// declarer dans le fichier db.php
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//fonction pour creer un utilisateur
function createUser($name, $email, $hashedPassword, $role){
    global $pdo;
    $stmt =$pdo->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?,?,?,?) ");
    try {
        return
        $stmt->execute([$name, $email, $hashedPassword, $role]);
    } catch (PDOException $e) {
        return false;
    }
}
?>