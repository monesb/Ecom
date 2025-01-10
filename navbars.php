<nav>
    <ul class="navbar">
        <li><a href="Stage.php">Accueil</a></li>
        <?php
        if (isset($_SESSION['username'])){
            echo '<li><a href="#">Bonjour, ' . htmlspecialchars($_SESSION['username']) . '</a></li>';
            echo '<li><a href="logouts.php">Déconnexion</a></li>';
        } else {
            echo '<li><a href="connection.php">Connexion</a></li>';
            echo '<li><a href="inscriptions.php">Inscription</a></li>';
            echo '<li><a href="mon_panier.php">Panier</a></li>';
        }
        ?>
    </ul>
</nav>

