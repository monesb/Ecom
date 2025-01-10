<?php
$host = "127.0.0.1";
$dbname = "informatique";
$username = "root";
$password = "";

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

// Récupération des paramètres
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Recherche de produits
$sql = "SELECT * FROM produit WHERE nom LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css">
    <title>Résultats de recherche</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="catalogue.php">Catalogue</a></li>
                <li class="nav-item"><a class="nav-link" href="inscriptions.php">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="connection.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="mon_panier.php">Panier</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Résultats de recherche pour <?php echo htmlspecialchars($query); ?></h1>
        <div class="row mt-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nom']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nom']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="card-text">Prix: <?php echo htmlspecialchars($row['prix']); ?> €</p>
                                <form action="mon_panier.php" method="post">
                                    <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($row['produit_id']); ?>">
                                    <button type="submit" name="add_to_cart" class="btn btn-primary">Ajouter au Panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Aucun produit trouvé pour "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Produits similaires</h2>
        <select class="form-select">
            <?php
            // Produits similaires
            $similar_sql = "SELECT * FROM produit WHERE nom NOT LIKE ?";
            $stmt = $conn->prepare($similar_sql);
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $similar_result = $stmt->get_result();
            while ($row = $similar_result->fetch_assoc()):
            ?>
                <option value="<?php echo htmlspecialchars($row['produit_id']); ?>">
                    <?php echo htmlspecialchars($row['nom']); ?> - <?php echo htmlspecialchars($row['prix']); ?> €
                </option>
            <?php endwhile; ?>
        </select>
    </div>
</body>
</html>
<?php
$conn->close();
?>
