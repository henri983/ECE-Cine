<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/init.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/cine_db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/users_fonction.php';
// Vérification de la connexion à la base de données

$message = '';
$error = '';
//token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim(strip_tags($_POST['username'], FILTER_SANITIZE_STRING));
    $role = in_array($_POST['type'], ['etudiant', 'enseignant', 'administrateur']) ? $_POST['type'] : 'etudiant';
    $email = trim(strip_tags($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifications
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!strip_tags($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifie si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Un compte avec cet email existe déjà.";
        } else {
            // Hashage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insère l'utilisateur avec rôle 'etudiant' et approuve = 0
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, role, approuve) VALUES (?, ?, ?, ?, 0)");
            if ($stmt->execute([$username, $email, $hashed_password, $role])) {
            $_SESSION['message'] = "Inscription réussie ! En attente d'approbation par un administrateur.";
            header('Location: login.php');
            exit;
            }else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
    }

    $_SESSION['error'] = $error;
    header('Location: register.php');
    exit;
}

// Affichage des messages
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
     <link rel="stylesheet" href="assets/style/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/header.php'; ?>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Créer un Compte</h2>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                       <div class="form-check-inline"> 
                         
                        <label class="form-check-label" >Veuillez choisir votre type</label> <br>
                        <input class="form-check-input" type="radio"  id="radioDefault1" name="type" value="etudiant" checked>
                        <label class="form-check-label" for="radioDefault1">Etudiant</label> 

                        <input class="form-check-input" type="radio"  id="radioDefault2" name="type" value="enseignant">
                        <label class="form-check-label" for="radioDefault2">Enseignant</label>

                       <input class="form-check-input" type="radio"  id="radioDefault3" name="type" value="administrateur">
                        <label class="form-check-label" for="radioDefault3">Administrateur</label>
                       </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="register" class="btn btn-success">S'inscrire</button>
                        </div>
                        <p class="text-center mt-3">Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ECE-Cine/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>     
</body>
</html>
