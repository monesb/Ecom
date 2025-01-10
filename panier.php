<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stage.css">
    <title>Panier</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/slate/bootstrap.min.css">
    <style>
        .navbar-nav .nav-item .nav-link {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Stage.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscriptions.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connection.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">Panier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Votre Panier</h2>

        <form action="panier.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix (€)</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Image</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();

                    if (!isset($_SESSION['panier'])) {
                        $_SESSION['panier'] = [];
                    }

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "informatique";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        if (!empty($_SESSION['panier'])) {
                            $placeholders = implode(',', array_fill(0, count(array_keys($_SESSION['panier'])), '?'));
                            $stmt = $conn->prepare("SELECT * FROM produit WHERE produit_id IN ($placeholders)");
                            $stmt->execute(array_keys($_SESSION['panier']));
                            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($produits as $produit) {
                                $produitId = $produit['produit_id'];
                                $quantite = $_SESSION['panier'][$produitId];
                                $total = $produit['prix'] * $quantite;

                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($produit['nom']) . "</td>";
                                echo "<td>" . htmlspecialchars($produit['description']) . "</td>";
                                echo "<td>" . htmlspecialchars($produit['prix']) . "</td>";
                                echo '<td>
                                        <input type="hidden" name="ids[]" value="' . htmlspecialchars($produitId) . '">
                                        <input type="number" name="quantites[]" value="' . htmlspecialchars($quantite) . '" min="1" style="width: 60px;">
                                      </td>';
                                echo "<td>" . htmlspecialchars($total) . "</td>";
                                echo '<td><img src="' . htmlspecialchars($produit['image']) . '" width="100px" height="100px"></td>';
                                echo '<td>
                                        <button type="submit" class="btn btn-danger" name="action" value="remove-' . htmlspecialchars($produitId) . '">Supprimer</button>
                                      </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo '<tr><td colspan="7">Votre panier est vide.</td></tr>';
                        }
                    } catch(PDOException $e) {
                        echo "<tr><td colspan='7'>Erreur : " . $e->getMessage() . "</td></tr>";
                    }

                    // Gestion des modifications du panier (supprimer ou mettre à jour)
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset($_POST['action'])) {
                            if (strpos($_POST['action'], 'remove-') === 0) {
                                // Suppression d'un produit
                                $productIdToRemove = str_replace('remove-', '', $_POST['action']);
                                if (isset($_SESSION['panier'][$productIdToRemove])) {
                                    unset($_SESSION['panier'][$productIdToRemove]);
                                }
                            }
                        } elseif (isset($_POST['ids'], $_POST['quantites'])) {
                            // Mise à jour des quantités
                            foreach ($_POST['ids'] as $index => $id) {
                                $newQuantite = (int)$_POST['quantites'][$index];
                                if ($newQuantite > 0) {
                                    $_SESSION['panier'][$id] = $newQuantite;
                                }
                            }
                        }
                        // Redirection pour éviter le rechargement du formulaire
                        header('Location: panier.php');
                        exit();
                    }
                    ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Mettre à jour le panier</button>
        </form>

        <form id="commandeForm" action="commande.php" method="post">
            <button type="submit" class="btn btn-success">Passer la commande</button>
        </form>
    </div>

    <script>
        document.getElementById('commandeForm').addEventListener('submit', function(event) {
            var panierVide = <?php echo empty($_SESSION['panier']) ? 'true' : 'false'; ?>;
            if (panierVide) {
                alert("Erreur : Votre panier est vide. Veuillez ajouter des produits pour passer la commande.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
