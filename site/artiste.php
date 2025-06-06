<?php
// Connexion à la base de données SQLite
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération de l'ID du produit depuis l'URL (ex: produit.php?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer le produit depuis la base
$requete = $db->prepare('SELECT * FROM Artiste WHERE Id_artiste = :id');
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
$artiste = $requete->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas
if (!$artiste) {
    die('Artiste non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($artiste['Nom_artiste']); ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body { font-family: Arial, sans-serif; }
        .artiste { background-color: white; width: 300px; margin: 50px auto; border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        img { max-width: 100%; height: auto; }
    </style>
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
    <div class="artiste">
        <h2><?php echo htmlspecialchars($artiste['Nom_artiste']); ?></h2>
        <img src="img_art/<?php echo htmlspecialchars($artiste['Id_artiste']); ?>.png" alt="<?php echo htmlspecialchars($artiste['Nom_artiste']); ?>">
        <p><?php echo htmlspecialchars($artiste['Description']); ?></p>
    </div>
<!-- FOOTER CORRECTEMENT STRUCTURÉ -->
<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>
