<?php
session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $produit_id = (int)$_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM produit WHERE produit_id = :id");
        $stmt->execute(['id' => $produit_id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produit) {
            die("Produit introuvable.");
        }
    } else {
        die("ID de produit non spécifié.");
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom']); ?> - Votre Boutique Informatique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-details {
            text-align: center;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #007BFF;
            margin: 10px 0;
        }

        .stock {
            font-size: 16px;
            color: #666;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="product-details">
            <h1><?= htmlspecialchars($produit['nom']); ?></h1>
            
            <img src="<?= htmlspecialchars($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">

            <p><strong>Description :</strong> <?= htmlspecialchars($produit['description']); ?></p>
            <p><strong>Détails :</strong> <?= htmlspecialchars($produit['script']); ?></p>
            <p class="price">Prix : <?= number_format($produit['prix'], 2, ',', ' '); ?> €</p>
            <p class="stock">Stock disponible : <?= htmlspecialchars($produit['stock']); ?></p>
        </div>
        <a class="back-link" href="catalogue.php">Retour au catalogue</a>
    </div>
</body>
</html>
