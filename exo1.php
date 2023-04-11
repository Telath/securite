<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice 1</title>
</head>

<body>
    <?php

    include './connxion-db.php';
    if (!empty($_GET['username']) && !empty($_GET['password'])) {
        $username = $_GET['username'];
        $password = $_GET['password'];

        $query =
            "SELECT * FROM users WHERE username = '" . $username . " AND password = '" . $password . "'";
        $rs = mysqli_query($conn, $query);

        if ($rs) {
            $user = mysqli_fetch_assoc($rs);

            echo
            "Bienvenue " . $user['username'];
            // htmlspecialchars($user['username']);
        } else {
            echo
            "Mauvais nom d'utilisateur et/ou mot de passe !";
        }

        mysqli_free_result($rs);
        mysqli_close($conn);
    }
    ?>

    <form action="exo1.php" method="GET">
        <b>Nom d'utilisateur :</b> <input type="text" name="username" />
        <b>Mot de passe :</b> <input type="text" name="password" />
        <input type="submit" value="Connexion" />
    </form>
</body>

</html>