<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Récupération des données du formulaire
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Vérification si l'utilisateur existe déjà dans la base de données
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) {
    // L'utilisateur existe déjà, affichage d'un message d'erreur
    echo 'L\'adresse e-mail est déjà utilisée.';
} else {
    // Insertion des données dans la base de données
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $email, $password])) {
        echo 'Inscription réussie.';
    } else {
        echo 'Une erreur est survenue lors de l\'inscription.';
    }
}
