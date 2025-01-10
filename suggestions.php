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

$query = isset($_GET['q']) ? $_GET['q'] : '';

$sql = "SELECT nom FROM produit WHERE nom LIKE ? LIMIT 5";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row;
}

echo json_encode($suggestions);

$conn->close();
