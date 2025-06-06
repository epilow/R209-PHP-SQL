<?php
// Connexion à la base SQLite
$db = new PDO('sqlite:SQL.db');

// Préparer et exécuter la requête pour récupérer 3 produits aléatoires
$stmt = $db->query('SELECT * FROM Music ORDER BY RANDOM() LIMIT 3');
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="catalogue.php" style="color: #242124;"><i class="fa fa-search"></i></a>       
    <a href="panier.php" style="color: #242124;"><i class="fa fa-shopping-cart"></i></a>
      <a href="login.php" style="color: #242124;"><i class="fa fa-user-circle"></i></a>
    </div>
  </header>

 
    <main class="main">
     <!-- Top Vente -->
 <h1 style="text-align:center;">Meilleurs Ventes</h1> 
    <div class="catalogue">
        <?php foreach ($produits as $produit): ?>
            <a class="carte-produit" href="produit.php?id=<?php echo $produit['Id_music']; ?>">
                <h3 class="nom-produit"><?= htmlspecialchars($produit['Nom_music']) ?></h3>
                <img src="img_music/<?= htmlspecialchars($produit['Id_music']) ?>.png" alt="<?= htmlspecialchars($produit['Nom_music']) ?>">
                <p class="prix"><?= htmlspecialchars($produit['Prix']) ?>€</p>
            </a>
        <?php endforeach; ?>
    </div>

<div class="bouton-container">
  <a href="catalogue.php" class="bouton">Voir plus</a>

</div>
    </main>
<br>

    <footer class="rect-footer">
      <p>© 2025 Music.ia. Tous droits réservés.</p>
    </footer>
</body>
</html>