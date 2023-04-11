<?php
// Débute une session pour utiliser les variables
session_start();

// Intégration des fonctions de chiffrement et de déchiffrement
include_once "fonctions.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

// Récupérer les informations de l'utilisateur à partir de la base de données
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données soumises
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //Chiffrement des données du formulaire
    $usernameChif = chiffrement_cesar($username, 3);
    $emailChif = chiffrement_cesar($email, 3);
    $passwordChif = chiffrement_cesar($password, 3);

    // Vérifier si les champs sont vides
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Hasher le mot de passe avant de le sauvegarder dans la base de données
        $hashed_password = password_hash($passwordChif, PASSWORD_DEFAULT);

        // Mettre à jour les informations de l'utilisateur dans la base de données
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?');
        $stmt->execute([$usernameChif, $emailChif, $hashed_password, $user_id]);

        $_SESSION['username'] = dechiffrement_cesar($usernameChif, 3);
        $_SESSION['email'] = dechiffrement_cesar($emailChif, 3);

        // Rediriger l'utilisateur vers la page de profil mise à jour
        header('Location: index.php');
        exit();
    }
}
