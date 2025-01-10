<?php
session_start();
ob_start(); // Tampon de sortie pour éviter les erreurs de headers

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = trim($_POST['mot_de_passe'] ?? '');
    $confirm_mot_de_passe = trim($_POST['confirm_mot_de_passe'] ?? '');

    // Initialisation des messages d'erreur
    $errors = [];

    // Vérification des champs
    if (empty($nom)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide.";
    }
    if (empty($mot_de_passe)) {
        $errors[] = "Le mot de passe est requis.";
    }
    if ($mot_de_passe !== $confirm_mot_de_passe) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, insérer l'utilisateur dans la base de données
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

            // Vérification si l'utilisateur existe déjà
            $stmt = $conn->prepare("SELECT COUNT(*) FROM client WHERE email = :email OR nom = :nom");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
            $stmt->execute();
            $userExists = $stmt->fetchColumn();

            if ($userExists) {
                $errors[] = "Un utilisateur avec cet email ou ce nom d'utilisateur existe déjà.";
            } else {
                // Hachage du mot de passe
                $hashedPassword = password_hash($mot_de_passe, PASSWORD_BCRYPT);

                // Insertion dans la base de données
                $stmt = $conn->prepare("INSERT INTO client (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)");
                $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':mot_de_passe', $hashedPassword, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $_SESSION['username'] = $nom; // Stocker le nom d'utilisateur dans la session
                    header("Location: Stage.php"); // Redirection vers la page d'accueil
                    exit();
                } else {
                    $errors[] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
                }
            }
        } catch (PDOException $e) {
            error_log("Erreur d'inscription : " . $e->getMessage());
            $errors[] = "Une erreur interne est survenue. Veuillez réessayer plus tard.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Boutons personnalisés */
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
        <h1>Inscription</h1>

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

        <form action="inscriptions.php" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="mb-3">
                <label for="confirm_mot_de_passe" class="form-label">Confirmer le mot de passe :</label>
                <input type="password" class="form-control" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

    <?php include('footers.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
ob_end_flush(); // Vide le tampon de sortie
?>
