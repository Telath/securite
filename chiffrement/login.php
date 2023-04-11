<?php
// Intégration des fonctions de chiffrement et de déchiffrement
include_once "fonctions.php";

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Pour ne pas avoir de problème de décalage horaire
date_default_timezone_set('Europe/Paris');

// Débute une session pour utiliser les variables
session_start();

// Récupération des données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

//Chiffrement des données du formulaire
$emailChif = chiffrement_cesar($email, 3);
$passwordChif = chiffrement_cesar($password, 3);

// Récupération des informations de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$emailChif]);
$user = $stmt->fetch();

if ($user && password_verify($passwordChif, $user['password'])) {
    // Les informations de connexion sont valides, création d'un token OTP, stocke l'ID de l'utilisateur dans $_SESSION
    $token = bin2hex(random_bytes(16));
    $expiresAtTimestamp = time() + 300;
    $expiresAt = date('Y-m-d H:i:s', $expiresAtTimestamp);


    // Insertion des variables dans les SESSIONS avec le déchiffrement
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = dechiffrement_cesar($user['username'], 3);
    $_SESSION['email'] = dechiffrement_cesar($user['email'], 3);

    // Insertion du token dans la base de données
    $stmt = $pdo->prepare('INSERT INTO otp_tokens (user_id, token, expires_at) VALUES (?, ?, ?)');
    $stmt->execute([$user['id'], $token, $expiresAt]);

    // Envoi de l'e-mail contenant le token OTP
    $to = $user['email'];
    $subject = 'Votre code OTP pour vous connecter';
    $message = 'Votre code OTP est : ' . $token;
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);

    // Redirection vers la page de validation du code OTP
    header('Location: validateToken.php');
} else {
    // Les informations de connexion sont invalides, affichage d'un message d'erreur
    echo 'Adresse e-mail ou mot de passe incorrect.';
}
