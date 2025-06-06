<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$userId = $_SESSION['id_users'];

// Traitement modification de quantité
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantite'], $_POST['id_music'])) {
    $id_music = intval($_POST['id_music']);
    $quantite = intval($_POST['quantite']);

    if ($quantite <= 0) {
        // Supprimer l'article
        $delete = $db->prepare("DELETE FROM Panier WHERE Id_users = :user_id AND Id_music = :id_music");
        $delete->execute([
            ':user_id' => $userId,
            ':id_music' => $id_music
        ]);
    } else {
        // Modifier la quantité
        $update = $db->prepare("UPDATE Panier SET QTE = :quantite WHERE Id_users = :user_id AND Id_music = :id_music");
        $update->execute([
            ':quantite' => $quantite,
            ':user_id' => $userId,
            ':id_music' => $id_music
        ]);
    }

    header('Location: panier.php');
    exit;
}


// Récupère les articles du panier
$sql = "SELECT Music.Id_music, Music.Nom_music, Music.Prix, Artiste.Nom_artiste, Panier.QTE FROM Panier JOIN Music ON Panier.Id_music = Music.Id_music JOIN Artiste ON Music.Id_artiste = Artiste.Id_artiste WHERE Panier.Id_users = :user_id";

$stmt = $db->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($articles as $article) {
    $total += $article['Prix'] * $article['QTE'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon Panier</title>
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

<div class="container">
    <main class="main">
        <h1 style="text-align:center;">Mon Panier</h1>

        <?php if (count($articles) === 0): ?>
            <p style="text-align:center;">Vous n'avez pas encore ajouté de produits à votre panier.</p>
        <?php else: ?>
            <div class="static-part">
                <h3>Produits dans votre panier</h3>
            </div>
            <div class="dynamic-part">
                <?php foreach ($articles as $article): ?>
                    <div class="widget">
                        <strong><?php echo htmlspecialchars($article['Nom_music']); ?></strong><br>
                        Artiste : <?php echo htmlspecialchars($article['Nom_artiste']); ?><br>
                        Prix : <?php echo number_format($article['Prix']); ?><br>
                        <form method="post" class="quantite-form">
                          <input type="hidden" name="id_music" value="<?php echo $article['Id_music']; ?>">
                          <label>Quantité :
                            <input type="number" name="quantite" value="<?php echo intval($article['QTE']); ?>" min="0" style="width: 60px;" onchange="this.form.submit()">
                          </label>
                        </form>
                        Sous-total : <?php echo number_format($article['Prix'] * $article['QTE'], 2); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total">
                <h3 style="text-align:center;">Total : <?php echo number_format($total, 2); ?> €</h3>
            </div>
        <?php endif; ?>
    </main>
</div>

<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>
