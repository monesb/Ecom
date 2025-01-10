<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    include 'bdd.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM client WHERE email = :email AND id = 0");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = $admin['username'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p style='color: red;'>Mot de passe incorrect</p>";
            }
        } else {
            echo "<p style='color: red;'>Compte admin non trouvé ou identifiant incorrect</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur interne, veuillez réessayer plus tard.</p>";
        // Vous pouvez aussi journaliser l'erreur pour le débogage
        // error_log($e->getMessage());
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stage.css">
    <title>Connexion Admin</title>
</head>
<body>
<div class="login-container">
    <div class="form-container">
        <h2>Connexion Admin</h2>
        <form action="admin.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Se connecter">
        </form>
    </div>
</div>
</body>
</html>
