<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
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
<head>
    <title>Tableau de bord</title>
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
      <a href="catalogue.php" style="color: #242124;"><i class="fa fa-search"></i></a>  
      <a href="panier.php" style="color: #242124;"><i class="fa fa-shopping-cart"></i></a>
      <a href="login.php" style="color: #242124;"><i class="fa fa-user-circle"></i></a>
    </div>
  </header>
  <div class="container">
    <div class="main">
  <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <p>Vous êtes connecté.</p>
    <?php if ($_SESSION['perm'] === 'admin'): ?>
      <a href="lst_produit.php">Gestionnaire de produit</a>
    <?php endif; ?>
    <a href="logout.php">Se déconnecter</a>
      
    </div>
  </div>
  <div class="footer_dashboard">
  <footer class="rect-footer">
      <p>© 2025 Music.ia. Tous droits réservés.</p>
    </footer>
    </div>

</body>
</html>