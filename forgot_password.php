<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbars.php'); ?>

    <div class="container mt-5">
        <h1>Réinitialisation du mot de passe</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'] ?? '';
            $errors = [];

            if (empty($email)) {
                $errors[] = "L'email est requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            }

            if (empty($errors)) {
                $servername = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbname = "informatique";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT * FROM client WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        $resetToken = bin2hex(random_bytes(16));
                        $resetTokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                        $stmt = $conn->prepare("UPDATE client SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE email = :email");
                        $stmt->bindParam(':reset_token', $resetToken);
                        $stmt->bindParam(':reset_token_expiry', $resetTokenExpiry);
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();

                        $resetLink = "http://yourwebsite.com/reset_password.php?token=$resetToken";
                        $subject = "Réinitialisation de votre mot de passe";
                        $message = "Bonjour,\n\nPour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant : $resetLink\n\nCe lien est valide pendant 1 heure.\n\nMerci.";
                        $headers = "From: no-reply@yourwebsite.com";

                        mail($email, $subject, $message, $headers);

                        echo '<div class="alert alert-success">Un email de réinitialisation a été envoyé à votre adresse email.</div>';
                    } else {
                        $errors[] = "Aucun utilisateur trouvé avec cet email.";
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
        }
        ?>

        <form action="forgot_password.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>
        </form>
    </div>

    <?php include('footers.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
