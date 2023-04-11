<?php

// informations de connexion à la base de données
$host = "localhost"; // ou "127.0.0.1"
$user = "root";
$password = "";
$database = "securite";

// connexion à la base de données
$conn = mysqli_connect($host, $user, $password, $database);

// vérification de la connexion
if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}

echo "Connexion réussie à la base de données !";
