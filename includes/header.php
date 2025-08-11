
<div class="logo">
  <!-- <a class="#" href="<?= BASE_URL ?>index.php">ECE CINE</a> -->
<h2>ECE CINE</h2>
</div>

//pour charger l'utilisateur
<?php if (isset($_SESSION['role'])): ?>
<?php if ($_SESSION['role'] === 'etudiant'): ?>
  <li> <a href="etudiant/espace.php">Espace etudiant</a></li>
  <?php elseif ($_SESSION['role'] === 'enseignant'): ?>
    <li> <a href="enseignant/espace.php">Espace enseignant</a>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
      <li><a href="admin/espace.php">Espace administif</a></li>
  <?php endif; ?>
<?php endif; ?>  

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
   <!-- <a class="navbar-brand" href="<?= BASE_URL ?>dashboard/etudiant/home.php">Accueil</a>

     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/home.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/parcourir.php">Parcours</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/share.php">Partage</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>dashboard/etudiant/notification.php">Notification</a></li>
        <!-- <li class="nav-item"><a href="inscription.php" class="nav-link">Inscription</a></li> -->
      </ul>
      <ul class="navbar-nav">
        
        <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>login.php">Compte</a>
    </li>
    <?php if (isset($_SESSION['user_id'])): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>logout.php">Déconnexion</a>
    </li>
<?php endif; ?>
      </ul>
    </div>
  </div>
</nav>