<!DOCTYPE html>
<html>

<head>
    <title>Formulaire sécurisé contre les attaques XSS</title>
</head>

<body>

    <form method="POST" action="">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom">
        <br>
        <label for="commentaire">Commentaire:</label>
        <textarea name="commentaire" id="commentaire"></textarea>
        <br>
        <input type="submit" name="submit" value="Envoyer">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $commentaire = htmlspecialchars($_POST['commentaire'], ENT_QUOTES, 'UTF-8');

        // Affichage du commentaire
        echo "<p>Commentaire de $nom : $commentaire</p>";
    }
    ?>

</body>

</html>