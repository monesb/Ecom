<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    
    <style>
        /* Réinitialisation globale des marges/paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .product-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            width: 100%; /* Pour occuper tout l'espace disponible horizontalement */
            background: #fff;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            text-align: center;
            margin-bottom: 20px; /* Espacement entre l'image et les détails */
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-details {
            text-align: center;
        }

        .product-details h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .product-details p {
            font-size: 16px;
            line-height: 1.6;
        }

        .product-details .price {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }

        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-container a {
            margin-right: 0; /* Suppression de l'espace indésirable */
        }
    </style>
</head>
<body>


    <div class="product-container">
        <div class="product-image">
            <img src="<?= htmlspecialchars($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($produit['nom']); ?></h1>
            
            <p><?= nl2br(htmlspecialchars($produit['script'])); ?></p>
            <div class="price">Prix : €<?= htmlspecialchars($produit['prix']); ?></div>

            <form method="post" class="btn-container">
                <input type="hidden" name="produit_id" value="<?= htmlspecialchars($produit['produit_id']); ?>">
                <button type="submit" name="add_to_cart" class="btn btn-success">Ajouter au Panier</button>
                <a href="catalogue.php" class="btn btn-secondary">Retour a</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
