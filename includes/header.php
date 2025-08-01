<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a href="./dashboard/parcourir.php" class="nav-link active">Parcourir</a></li>
        <li class="nav-item"><a href="./dashboard/recherche.php" class="nav-link">Recherche</a></li>
        <!-- <li class="nav-item"><a href="inscription.php" class="nav-link">Inscription</a></li> -->
      </ul>
      <ul class="navbar-nav">
        
        <li class="nav-item">
        <a class="nav-link" href="./dashboard/compte.php">Compte</a>
    </li>
    <?php if (isset($_SESSION['user_id'])): ?>
    <li class="nav-item">
        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
    </li>
<?php endif; ?>
      </ul>
    </div>
  </div>
</nav>