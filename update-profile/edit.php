<?php
// Débute une session pour utiliser les variables
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<form id="profil-form" action="traitement.php" method="post" onsubmit="return validateForm()">
    <label for="username">Username :</label>
    <input type="text" id="username" name="username" value="<?= $_SESSION['username'] ?>">
    <span id="usernameError" class="error"></span><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= $_SESSION['email'] ?>">
    <span id="emailError" class="error"></span><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password">
    <span id="passwordError" class="error"></span><br>

    <input type="submit" value="Enregistrer">

    <div id="errors"></div>
</form>


<script>
    const form = document.getElementById('profil-form');
    form.addEventListener('submit', function(event) {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        let isValid = true;

        // Vérifier si tous les champs sont remplis
        if (username === '') {
            document.getElementById('usernameError').textContent = 'Le champ Nom d\'utilisateur est vide';
            isValid = false;
        } else {
            document.getElementById('usernameError').textContent = '';
        }

        if (email === '') {
            document.getElementById('emailError').textContent = 'Le champ Email est vide';
            isValid = false;
        } else {
            document.getElementById('emailError').textContent = '';
        }

        if (password === '') {
            document.getElementById('passwordError').textContent = 'Le champ Mot de passe est vide';
            isValid = false;
        } else {
            document.getElementById('passwordError').textContent = '';
        }

        if (!isValid) {
            event.preventDefault();
            return;
        }

        // Demander confirmation avant d'envoyer le formulaire
        if (!confirm('Êtes-vous sûr de modifier votre profil?')) {
            event.preventDefault();
            return;
        }
    });
</script>