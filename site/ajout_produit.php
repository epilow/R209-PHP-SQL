<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Vérification des droits
if (!isset($_SESSION['username']) || $_SESSION['perm'] !== 'admin') {
    header('Location: login.php');
    exit("Accès refusé. Vous devez être administrateur pour ajouter un produit.");
}

// Connexion à la base de données SQLite
function connectDB(): PDO {
    try {
        $db = new PDO('sqlite:SQL.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        exit("Erreur de connexion : " . $e->getMessage());
    }
}

// Récupère ou crée l'artiste et retourne son ID
function getOrCreateArtist(PDO $db, string $nomArtiste): int {
    $query = "SELECT Id_artiste FROM Artiste WHERE Nom_artiste = :nom";
    $stmt = $db->prepare($query);
    $stmt->execute([':nom' => $nomArtiste]);
    $artiste = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($artiste) {
        return $artiste['Id_artiste'];
    }

    $query = "INSERT INTO Artiste (Nom_artiste, Description) VALUES (:nom, :desc)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nom' => $nomArtiste,
        ':desc' => 'Aucune description'
    ]);

    return (int)$db->lastInsertId();
}

// Enregistre la musique dans la base
function ajouterMusique(PDO $db, string $titre, float $prix, string $description, string $style, int $idArtiste): int {
    $query = "INSERT INTO Music (Nom_music, Prix, Description, Style, Id_artiste) VALUES (:nom, :prix, :desc, :style, :id_artiste)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nom' => $titre,
        ':prix' => $prix,
        ':desc' => $description,
        ':style' => $style,
        ':id_artiste' => $idArtiste
    ]);
    return (int)$db->lastInsertId();
}

// Gère l’upload de fichier avec validation des extensions
function uploadFichier(array $file, string $destinationDir, int $id, array $extensions): ?string {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $extensions)) {
            throw new Exception("Extension de fichier non autorisée : .$ext");
        }
        if (!is_dir($destinationDir)) {
            if (!mkdir($destinationDir, 0755, true)) {
                throw new Exception("Impossible de créer le dossier $destinationDir");
            }
        }
        $path = "$destinationDir/$id.$ext";
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            throw new Exception("Échec de l'upload vers $path. Vérifie les permissions du dossier.");
        }
        return $path;
    }
    return null;
}


// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['nom'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $style = trim($_POST['style'] ?? '');
    $nomArtiste = trim($_POST['artiste'] ?? '');

    try {
        // Validation simple
        if ($titre === '') {
            throw new Exception("Le titre est requis.");
        }
        if ($nomArtiste === '') {
            throw new Exception("Le nom de l'artiste est requis.");
        }
        if ($prix <= 0) {
            throw new Exception("Le prix doit être un nombre positif.");
        }


        $db = connectDB();

        $idArtiste = getOrCreateArtist($db, $nomArtiste);
        $idMusic = ajouterMusique($db, $titre, $prix, $description, $style, $idArtiste);

        // Uploads avec extensions acceptées
        uploadFichier($_FILES['image'], 'img_music', $idMusic, ['png']);
        uploadFichier($_FILES['fichier'], 'song', $idMusic, ['mp3']);

        $message = "Musique ajoutée avec succès !";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<pre>";
        var_dump($_POST);
        var_dump($_FILES);
        echo "</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une musique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <h1>Ajouter une musique</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Titre : <input type="text" name="nom" required></label><br><br>
        <label>Artiste : <input type="text" name="artiste" required></label><br><br>
        <label>Prix : <input type="number" name="prix" step="0.1" required></label><br><br>
        <label>Style : <input type="text" name="style" required></label><br><br>
        <label>Description : <textarea name="description"></textarea></label><br><br>
        <label>Image : <input type="file" class="filtre" name="image" accept="image/*" required></label><br><br>
        <label>Fichier audio : <input type="file" class="filtre" name="fichier" accept="audio/*" required></label><br><br>
        <input type="submit"  class="filtre" value="Ajouter">
    </form>
    <?php if (!empty($message)): ?>
        <p style='color: green; text-align: center;'><?=htmlspecialchars($message) ?></p>
    <?php endif; ?>   
</main>
</div>

<footer>
    <p>© 2025 Music.ia. Tous droit réservé</p>
</footer>
</body>
</html>
