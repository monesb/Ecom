<?php
session_start();
ob_start(); // Active le tampon de sortie pour éviter les erreurs de headers

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Initialisation des messages d'erreur
    $errors = [];

    // Vérification de la complétion de tous les champs
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // Si aucun message d'erreur, continuer avec la vérification
    if (empty($errors)) {
        // Connexion à la base de données
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "informatique";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Requête SQL pour vérifier les informations de connexion
            $stmt = $conn->prepare("SELECT * FROM client WHERE nom = :nom");
            $stmt->bindValue(':nom', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
                header("Location: Stage.php"); // Redirection vers la page d'accueil après connexion
                exit();
            } else {
                $errors[] = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            // Journaliser l'erreur pour les développeurs, mais ne pas afficher à l'utilisateur
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
            $errors[] = "Une erreur interne est survenue. Veuillez réessayer plus tard.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom button style */
        .btn-primary {
            background-color: #028a0f;
            border-color: #028a0f;
        }

        .btn-primary:hover {
            background-color: #026f0c;
            border-color: #026f0c;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h1>Connexion</h1>

        <?php
        // Affichage des messages d'erreur
        if (!empty($errors)) {
            echo '<div class="alert alert-danger"><ul>';
            foreach ($errors as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul></div>';
        }
        ?>

        <form action="connection.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

    <?php include('footers.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
ob_end_flush(); // Vide le tampon et envoie la sortie
?>
