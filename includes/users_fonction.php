<?php
//on recupere l'utilisateur par son mail
function getUserByEmail($email){

    if (empty($email)) return false;// si l'email est vide, on retourne false

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
//fonction pour recuperer un utilisateur par son id
function getUserById($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}
function UsersExists($email){
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT (*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0; // retourne true si l'utilisateur existe, false dans le cas contraire
}
?>