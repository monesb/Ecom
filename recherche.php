<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de produits</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container">
        <h1>Recherche de produits</h1>

        <form action="recherche.php" method="get">
            <input type="text" name="query" placeholder="Rechercher des produits..." required>
            <input type="submit" value="Rechercher">
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
