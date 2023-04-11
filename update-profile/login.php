<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Pour ne pas avoir de problème de décalage horaire
date_default_timezone_set('Europe/Paris');

// Débute une session pour utiliser les variables
session_start();

// Récupération des données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Récupération des informations de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Les informations de connexion sont valides, création d'un token OTP, stocke l'ID de l'utilisateur dans $_SESSION
    $token = bin2hex(random_bytes(16));
    $expiresAtTimestamp = time() + 300;
    $expiresAt = date('Y-m-d H:i:s', $expiresAtTimestamp);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

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
