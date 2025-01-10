<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stage.css">
    <title>commande.net</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-[hash]" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-[hash]" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/5/slate/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Finalisez votre commande</h2>
        <h3>Produits dans votre panier :</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix (€)</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                // Informations de connexion à la base de données
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "informatique";

                // Initialise les variables pour le total de la commande
                $totalQuantite = 0;
                $totalPrix = 0;

                // Initialise une variable pour stocker les détails des produits du panier
                $panierDetails = array();

                try {
                    // Établit une connexion à la base de données avec PDO
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Configure PDO pour générer des exceptions en cas d'erreur
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Parcourt chaque ID de produit dans le panier
                    foreach ($_SESSION['panier'] as $productId => $quantite) {
                        // Requête SQL pour récupérer les détails du produit à partir de son ID
                        $stmt = $conn->prepare("SELECT * FROM produit WHERE produit_id = :productId");
                        $stmt->bindParam(':productId', $productId);
                        $stmt->execute();
                        // Récupère les détails du produit sous forme de tableau associatif
                        $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
                        // Vérifie si $productDetails est un tableau avant de l'ajouter à $panierDetails
                        if ($productDetails) {
                            $productDetails['quantite'] = $quantite;
                            $productDetails['total'] = $productDetails['prix'] * $quantite;
                            $panierDetails[] = $productDetails;

                            // Ajoute la quantité et le prix total du produit aux totaux
                            $totalQuantite += $quantite;
                            $totalPrix += $productDetails['total'];
                        }
                    }
                } catch(PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }

                // Boucle sur les détails des produits du panier
                foreach ($panierDetails as $product) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product['nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['prix']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['quantite']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['total']) . "</td>";
                    echo '<td><img src="' . htmlspecialchars($product['image']) . '" width="100px" height="100px"></td>';
                    echo "</tr>";
                }

                // Ferme la connexion à la base de données
                $conn = null;
                ?>
            </tbody>
        </table>
        <h4>Quantité totale : <?php echo $totalQuantite; ?></h4>
        <h4>Prix total : <?php echo $totalPrix; ?> €</h4>
        <h3>Informations de livraison :</h3>
        <form action="submit_commande.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse :</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ville">Ville :</label>
                        <input type="text" class="form-control" id="ville" name="ville" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="codePostal">Code Postal :</label>
                        <input type="text" class="form-control" id="codePostal" name="codePostal" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Passer la commande</button>
        </form>
    </div>
</body>
</html>
