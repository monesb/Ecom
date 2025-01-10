<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recherche.css">
    <title>Informatique.com</title>
</head>
<body>
    <div class="contenu">
        <?php
        // Vérifie si le paramètre 'query' a été envoyé via la méthode GET
        if (isset($_GET['query'])) {
            // Récupère la requête de recherche
            $query = $_GET['query'];

            // Informations de connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "informatique";

            try {
                // Établit une connexion à la base de données avec PDO
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // Configure PDO pour générer des exceptions en cas d'erreur
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prépare une requête SQL pour rechercher les produits correspondant à la requête
                $stmt = $conn->prepare("SELECT * FROM produit WHERE nom LIKE :query OR description LIKE :query");
                // Lie la valeur de la requête de recherche au paramètre ':query' avec des caractères joker
                $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
                // Exécute la requête SQL
                $stmt->execute();
                // Récupère tous les résultats sous forme de tableau associatif
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Affiche le titre des résultats de recherche
                echo "<h2>Résultats de la recherche pour '" . htmlspecialchars($query) . "':</h2>";
                // Vérifie s'il y a des résultats
                if ($results) {
                    // Commence un tableau HTML pour afficher les résultats
                    echo "<table>";
                    echo "<thead><tr><th>Nom</th><th>Description</th><th>Prix (€)</th></tr></thead>";
                    echo "<tbody>";
                    // Parcourt chaque produit dans les résultats
                    foreach ($results as $product) {
                        // Affiche chaque produit avec son nom, sa description et son prix
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($product['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['prix']) . "€</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    // Termine le tableau HTML
                    echo "</table>";
                } else {
                    // Affiche un message si aucun résultat n'est trouvé
                    echo "<p>Aucun résultat trouvé pour '" . htmlspecialchars($query) . "'.</p>";
                }
            } catch(PDOException $e) {
                // Affiche un message d'erreur en cas de problème avec la base de données
                echo "Erreur : " . $e->getMessage();
            }

            // Ferme la connexion à la base de données
            $conn = null;
        } else {
            // Affiche un message si aucune requête de recherche n'a été soumise
            echo "<p>Veuillez entrer une requête de recherche.</p>";
        }
        ?>
    </div>
</body>
</html>
