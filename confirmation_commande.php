<?php
session_start();

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

    // Récupère les informations du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $codePostal = $_POST['codePostal'];
    $client_id = $_SESSION['client_id']; // ID du client connecté

    // Vérifie si l'adresse existe déjà
    $stmt = $conn->prepare("SELECT adresse_id FROM client_adresse WHERE client_id = :client_id AND ville = :ville AND code_postal = :codePostal");
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':codePostal', $codePostal);
    $stmt->execute();
    $adresse_id = $stmt->fetchColumn();

    // Si l'adresse n'existe pas, l'ajoute à la table client_adresse
    if (!$adresse_id) {
        $stmt = $conn->prepare("INSERT INTO client_adresse (client_id, ville, code_postal) VALUES (:client_id, :ville, :codePostal)");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->execute();
        $adresse_id = $conn->lastInsertId();
    }

    // Insère la commande dans la table commande
    $stmt = $conn->prepare("INSERT INTO commande (client_id, adresse_id) VALUES (:client_id, :adresse_id)");
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':adresse_id', $adresse_id);
    $stmt->execute();
    $commande_id = $conn->lastInsertId();

    // Insère les produits de la commande dans la table commande_produit
    foreach ($_SESSION['panier'] as $productId) {
        // Récupère les détails du produit
        $stmt = $conn->prepare("SELECT prix FROM produit WHERE produit_id = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $prix = $row['prix'];

        // Insère le produit dans la table commande_produit
        $stmt = $conn->prepare("INSERT INTO commande_produit (commande_id, produit_id, quantite, prix) VALUES (:commande_id, :produit_id, 1, :prix)");
        $stmt->bindParam(':commande_id', $commande_id);
        $stmt->bindParam(':produit_id', $productId);
        $stmt->bindParam(':prix', $prix);
        $stmt->execute();
    }

    // Efface le panier après avoir passé la commande
    unset($_SESSION['panier']);

    // Redirige vers une page de confirmation ou de remerciement
    header('Location: confirmation_commande.php');
    exit();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Ferme la connexion à la base de données
$conn = null;
?>
