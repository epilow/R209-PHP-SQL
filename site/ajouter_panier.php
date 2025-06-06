<?php
session_start();

// Connexion à la base de données
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die('Vous devez être connecté pour ajouter un article au panier.');
}

$id_utilisateur = $_SESSION['id_users'];

// Vérifie que l'ID du produit est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de produit invalide.');
}

$id_music = (int) $_GET['id'];

// Vérifie si l'article est déjà dans le panier
$stmt = $db->prepare('SELECT * FROM Panier WHERE Id_users = :user AND Id_music = :music');
$stmt->execute([
    ':user' => $id_utilisateur,
    ':music' => $id_music
]);
$ligne = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ligne) {
    // S'il existe, on incrémente la quantité
    $update = $db->prepare('UPDATE Panier SET QTE = QTE + 1 WHERE Id_panier = :id');
    $update->execute([':id' => $ligne['Id_panier']]);
} else {
    // Sinon, on insère une nouvelle ligne
    $insert = $db->prepare('INSERT INTO Panier (Id_users, Id_music, QTE) VALUES (:user, :music, 1)');
    $insert->execute([
        ':user' => $id_utilisateur,
        ':music' => $id_music
    ]);
}

// Redirige vers le panier ou la page précédente
header('Location: panier.php');
exit;
?>