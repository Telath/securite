<?php
session_start();
var_dump($_SESSION);
?>

<h2>Inscription</h2>
<form method="post" action="register.php">
    <label for="username">Nom d'utilisateur:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="email">Adresse e-mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="S'inscrire">
</form>

<h2>Connexion</h2>
<form method="post" action="login.php">
    <label for="email">Adresse e-mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Se connecter">
</form>