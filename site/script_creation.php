<?php
// Connexion à la base de données
$pdo = new PDO('sqlite:SQL.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupère les données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Vérifie les champs
if (empty($username) || empty($password) || empty($confirm_password)) {
    header('Location: register.php?error=empty');
    exit;
}

if ($password !== $confirm_password) {
    header('Location: register.php?error=password_mismatch');
    exit;
}

// Vérifie si l'utilisateur existe déjà
$stmt = $pdo->prepare('SELECT * FROM Users WHERE Nom_users = ?');
$stmt->execute([$username]);
$existingUser = $stmt->fetch();

if ($existingUser) {
    header('Location: register.php?error=username_taken');
    exit;
}

// Hachage du mot de passe avant de l'enregistrer
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion de l'utilisateur avec la valeur par défaut pour `Perm`
$stmt = $pdo->prepare('INSERT INTO Users (Nom_users, Password, Perm) VALUES (?, ?, ?)');
$stmt->execute([$username, $hashedPassword, 'user']); // 'user' est une valeur par défaut pour Perm

// Redirige vers la page login après la création du compte
header('Location: login.php?success=1');
exit;
?>
