<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('sqlite:SQL.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Redirection si les champs sont vides
if (empty($username) || empty($password)) {
    header('Location: login.php?error=empty');
    exit;
}

// Requête sécurisée pour récupérer l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM Users WHERE Nom_users = ?');
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification du mot de passe
if ($user && password_verify($password, $user['Password'])) {
    // Stockage des infos dans la session
    $_SESSION['id_users'] = $user['Id_users'];
    $_SESSION['username'] = $user['Nom_users'];
    $_SESSION['perm'] = $user['Perm']; // 'admin' ou autre

    // Redirection vers le page du compte
    header('Location: dashboard.php');
} else {
    // Identifiants incorrects
    header('Location: login.php?error=invalid_credentials');
    exit;
}
?>
