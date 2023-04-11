<?php
// Intégration des fonctions de chiffrement et de déchiffrement
include_once "fonctions.php";

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Récupération des données du formulaire
$username = $_POST['username'];
$email = $_POST['email'];

//Chiffrement des données du formulaire
$usernameChif = chiffrement_cesar($username, 3);
$emailChif = chiffrement_cesar($email, 3);
$passwordChif = chiffrement_cesar($_POST['password'], 3);

$password = password_hash($passwordChif, PASSWORD_BCRYPT);


// Vérification si l'utilisateur existe déjà dans la base de données
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) {
    // L'utilisateur existe déjà, affichage d'un message d'erreur
    echo 'L\'adresse e-mail est déjà utilisée.';
} else {
    // Insertion des données dans la base de données
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    if ($stmt->execute([$usernameChif, $emailChif, $password])) {
        echo 'Inscription réussie.';
    } else {
        echo 'Une erreur est survenue lors de l\'inscription.';
    }
}
