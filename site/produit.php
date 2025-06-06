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
$requete = $db->prepare('SELECT * FROM Music WHERE Id_music = :id');
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
$produit = $requete->fetch(PDO::FETCH_ASSOC);

$requete = $db->prepare('SELECT * FROM Artiste WHERE Id_artiste = :id');
$requete->bindParam(':id', $produit['Id_artiste'], PDO::PARAM_INT);
$requete->execute();
$artiste = $requete->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas
if (!$produit) {
    die('Produit non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produit['Nom_music']); ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body { font-family: Arial, sans-serif; }
        .produit { background-color: white; width: 300px; margin: 50px auto; border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        img { max-width: 100%; height: auto; }
        .prix { font-size: 24px; color: green; }
        .bouton-panier { background-color: #28a745; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; }
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
    <a href="catalogue.php" style="color: #242124;"><i class="fa fa-search"></i></a> 
      <a href="panier.php" style="color: #242124;"><i class="fa fa-shopping-cart"></i></a>
      <a href="login.php" style="color: #242124;"><i class="fa fa-user-circle"></i></a>
    </div>
  </header>     
    <div class="produit">
        <h2><?php echo htmlspecialchars($produit['Nom_music']); ?> - <a href="artiste.php?id=<?php echo $produit['Id_artiste']; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($artiste['Nom_artiste']); ?></a></h2>
        <img src="img_music/<?php echo htmlspecialchars($produit['Id_music']); ?>.png" alt="<?php echo htmlspecialchars($produit['Nom_music']); ?>">
        <p><?php echo htmlspecialchars($produit['Description']); ?></p>
        <audio controls src="song/<?php echo htmlspecialchars($produit['Id_music']); ?>.mp3"></audio>
        <p class="prix"><?php echo htmlspecialchars($produit['Prix'], 2); ?>€</p>
        <form method="post" action="ajouter_panier.php?id=<?= $produit['Id_music'] ?>">
            <input type="hidden" name="produit_id" value="<?php echo $produit['Id_music']; ?>">
            <button type="submit" class="bouton-panier">Ajouter au panier</button>
        </form>
    </div>
<!-- FOOTER CORRECTEMENT STRUCTURÉ -->
<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>
