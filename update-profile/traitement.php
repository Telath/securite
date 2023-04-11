<?php
// Débute une session pour utiliser les variables
session_start();

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

    // Vérifier si les champs sont vides
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Hasher le mot de passe avant de le sauvegarder dans la base de données
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Mettre à jour les informations de l'utilisateur dans la base de données
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?');
        $stmt->execute([$username, $email, $hashed_password, $user_id]);

        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // Rediriger l'utilisateur vers la page de profil mise à jour
        header('Location: index.php');
        exit();
    }
}
