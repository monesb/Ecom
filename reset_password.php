<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbars.php'); ?>

    <div class="container mt-5">
        <h1>Nouveau mot de passe</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $errors = [];

            if (empty($password)) {
                $errors[] = "Le mot de passe est requis.";
            }
            if (empty($confirm_password)) {
                $errors[] = "La confirmation du mot de passe est requise.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }

            if (empty($errors)) {
                $servername = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbname = "informatique";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT * FROM client WHERE reset_token = :reset_token AND reset_token_expiry > NOW()");
                    $stmt->bindParam(':reset_token', $token);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $stmt = $conn->prepare("UPDATE client SET mot_de_passe = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :reset_token");
                        $stmt->bindParam(':password', $password_hash);
                        $stmt->bindParam(':reset_token', $token);
                        $stmt->execute();

                        echo '<div class="alert alert-success">Votre mot de passe a été réinitialisé avec succès.</div>';
                    } else {
                        $errors[] = "Le lien de réinitialisation est invalide ou a expiré.";
                    }
                } catch(PDOException $e) {
                    $errors[] = "Erreur : " . $e->getMessage();
                }
                $conn = null;
            }

            if (!empty($errors)) {
                echo '<div class="alert alert-danger"><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . htmlspecialchars($error) . '</li>';
                }
                echo '</ul></div>';
            }
        } else {
            if (isset($_GET['token'])) {
                $token = $_GET['token'];
            } else {
                die('Token manquant.');
            }
        }
        ?>

        <form action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
        </form>
    </div>

    <?php include('footers.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
