<?php
// Gestion des messages d'erreur
if (isset($_GET['error'])) {
    $message = '';
    $style = 'color: red; font-weight: bold;';
    if ($_GET['error'] == 'empty') {
        $message = 'Veuillez remplir tous les champs.';
    } elseif ($_GET['error'] == 'password_mismatch') {
        $message = 'Les mots de passe ne correspondent pas.';
    } elseif ($_GET['error'] == 'username_taken') {
        $message = 'Nom d\'utilisateur déjà pris.';
    }
    
    echo "<p style='$style'>$message</p>";
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

  <div class="container">
    <div class="main">
    <?php if (!empty($message)) : ?>
    <p style="<?= $style ?>"><?= $message ?></p>
    <?php endif; ?>

    <form action="script_creation.php" method="post">
        <label>Nom d'utilisateur :
            <input type="text" name="username" required>
        </label><br><br>

        <label>Mot de passe :
            <input type="password" name="password" required>
        </label><br><br>

        <label>Confirmer le mot de passe :
            <input type="password" name="confirm_password" required>
        </label><br><br>

        <button type="submit">Créer le compte</button>
    </form>
    <p>Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
  </div>
</div>

 <!-- FOOTER CORRECTEMENT STRUCTURÉ -->
<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>

</body>
</html>