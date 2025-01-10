<?php
session_start();

if (!isset($_SESSION['username'])){
    header("Location: connexion.php");
    exit();
}

if (!isset($_POST['logout'])){
    session_destroy();
    header("location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceuil</title>
        <link rel="stylesheet" href="style.css">
    </head>
<body>

    <?php include 'navbars.php'; ?>