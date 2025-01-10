<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations de livraison
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $codePostal = $_POST['codePostal'];

    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "informatique";

    try {
        // Établir une connexion à la base de données avec PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insérer les informations de livraison dans la table des commandes
        $stmt = $conn->prepare("INSERT INTO commandes (nom, prenom, adresse, ville, code_postal) VALUES (:nom, :prenom, :adresse, :ville, :code_postal)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code_postal', $codePostal);
        $stmt->execute();

        // Récupérer l'ID de la commande insérée
        $commandeId = $conn->lastInsertId();

        // Insérer les produits de la commande dans la table des produits commandés
        foreach ($_SESSION['panier'] as $productId) {
            $stmt = $conn->prepare("INSERT INTO produits_commandes (commande_id, produit_id) VALUES (:commande_id, :produit_id)");
            $stmt->bindParam(':commande_id', $commandeId);
            $stmt->bindParam(':produit_id', $productId);
            $stmt->execute();
        }

        // Vider le panier
        unset($_SESSION['panier']);

        // Message de confirmation
        $message = "Votre commande a été passée avec succès. Merci pour votre achat !";

    } catch(PDOException $e) {
        // En cas d'erreur, afficher un message
        $message = "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $conn = null;
} else {
    // Rediriger vers la page de commande si le formulaire n'a pas été soumis
    header('Location: commande.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stage.css">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/slate/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Confirmation de commande</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="index.php" class="btn btn-primary">Retour à la page d'accueil</a>
    </div>
</body>
</html>
