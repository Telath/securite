<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Débute une session pour utiliser les variables
session_start();

// Récupération du code OTP et de l'utilisateur
$otp = $_POST['otp'];
$user_id = $_SESSION['user_id'];

// Vérification du code OTP dans la base de données
$stmt = $pdo->prepare('SELECT * FROM otp_tokens WHERE user_id = ? AND token = ? AND expires_at >= NOW()');
$stmt->execute([$user_id, $otp]);
$token = $stmt->fetch();

if ($token) {
    // Le code OTP est valide, suppression du token de la base de données
    $stmt = $pdo->prepare('DELETE FROM otp_tokens WHERE id = ?');
    $stmt->execute([$token['id']]);

    // Connexion réussie, redirection vers la page d'accueil
    header('Location: index.php');
} else {
    // Le code OTP est invalide, affichage d'un message d'erreur
    echo 'Code OTP invalide ou expiré.';
}
