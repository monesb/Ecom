
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Accueil ou info</title>
</head>
<body><div>
    <nav><ul><li><a href="Stage">Accueil</a></li></ul></nav>
</div>
<h1>Connecté ou Accueil</h1>
<p>Normalement, on affiche plutôt le prénom et ou le nom.</p>
<?php
// Afficher le message
if (isset($_GET['message'])) {

    $utilisateur = $_SESSION['identifiant'];

    echo 'Bienvenue '. $utilisateur .'<br>';
    echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
}
?>
</body>
</html>