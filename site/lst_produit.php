<?php
session_start();

// Connexion à la base SQLite
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Traitement suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_id']) && isset($_SESSION['perm']) && $_SESSION['perm'] === 'admin') {
    $id = (int)$_POST['supprimer_id'];

    // Supprimer fichiers (image + audio)
    foreach (['img_music', 'song'] as $folder) {
        foreach (glob("$folder/$id.*") as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    // Supprimer de la base
    $stmt = $db->prepare("DELETE FROM Music WHERE Id_music = :id");
    $stmt->execute([':id' => $id]);
    $message = "Produit supprimé avec succès.";
}

// Requête principale
$sql = 'SELECT * FROM Music ORDER BY Nom_music ASC';

$stmt = $db->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <title>Catalogue</title>
</head>
<body>
<header class="navbar">
    <div class="nav-left">
        <a href="main.php" style="color: #242124;"><i class="fa fa-home"></i></a> 
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

<div class="page">
<main class="main">
    <h1 style="text-align:center;">Liste produits</h1>

    <?php if (!empty($message)): ?>
        <p style="color: green; text-align: center;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- AFFICHAGE DES PRODUITS -->
    <div class="catalogue">
    <?php foreach ($produits as $produit): ?>
        <div class="carte-produit">
            <a href="produit.php?id=<?= $produit['Id_music'] ?>">
                <img src="img_music/<?= htmlspecialchars($produit['Id_music']) ?>.png" alt="Image musique">
            </a>
            <div class="nom-produit"><?= htmlspecialchars($produit['Nom_music']) ?></div>
            <div class="prix"><?= htmlspecialchars($produit['Prix'], 2) ?>€</div>

            <!-- Bouton Supprimer -->
            <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] === 'admin'): ?>
                <form method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                    <input type="hidden" name="supprimer_id" value="<?= $produit['Id_music'] ?>">
                    <button type="submit" class="btn-supprimer">Supprimer</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!-- CARTE D'AJOUT DE PRODUIT -->
    <?php if (isset($_SESSION['perm']) && $_SESSION['perm'] === 'admin'): ?>
        <div class="ajouter-produit">
            <a style="text-decoration: none; color: inherit;" href="ajout_produit.php" class="ajouter-lien">
                <div>
                    <div style="font-size: 50px;">+</div>
                    <div>Ajouter un produit</div>
                </div>
            </a>
        </div>
    <?php endif; ?>
</div>

</main>
</div>

<footer class="rect-footer">
    <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>