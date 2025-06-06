<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body> 
<header class="navbar">
    <div class="nav-left">
    <a href="main.php" style="color: #242124;">
      <i class="fa fa-home"></i>
</a> 
    </div>
    <div class="nav-center">
      <a href="main.php" class="logo-link">
      <img src="logo.png" alt="Logo" class="logo">
  </a>  
        </div>
    <div class="nav-right"> 
      <i class="fa fa-search" style="color: #242124;"></i> 
      <a href="panier.php" style="color: #242124;">
      <i class="fa fa-shopping-cart"></i>
</a>
      <a href="login.php" style="color: #242124;">
  <i class="fa fa-user-circle"></i>
</a>
    </div>
  </header>

  <div class="container_login"> 
    <main class="main">
    <form method="POST" action="script_login.php">
        <label>Login:</label>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Se connecter</button>

        <p>Pas encore de compte? <a href="register.php">Inscrivez-vous ici</a></p>
    </form>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">Identifiants incorrects.</p>
    <?php endif; ?>

  </div>
    </main>
    <br>

<!-- FOOTER CORRECTEMENT STRUCTURÉ -->

<footer class="rect-footer">
      <p>© 2025 Music.ia. Tous droits réservés.</p>
    </footer>

</body>
</html>