<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: Index.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Bienvenue sur la page d'accueil<br>Accès autorisé !</h1>
    <p>Vous êtes connecté en tant que <b><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></b>.</p>
    <a href="Deconnexion.php">Déconnexion</a>
</body>
</html>