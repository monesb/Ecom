<?php
require_once "connexion.php";
$utilisateur = [];
$mdp = "";

// on récupère les données du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['SeConnecter'])) {
        $identifiant = filter_input(INPUT_POST, 'identifiant', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH,);
        $mdp = $_POST['mdp']; // ne pas filtrer votre mot de passe puisqu'il doit y avoir des caractères spéciaux, il faudrait un regex
        // petite sauvegarde... avec les cookies... c'est pour plus tard.
        setcookie('identifiant', $identifiant, time() + 3600, '/');
        setcookie('mdp', $mdp, time() + 3600, '/');
        // on récupère la connexion
        $connexion = getConnexion();
        // on prépare la requête
        $query = $connexion->prepare("SELECT identifiant, mdp FROM Utilisateur WHERE identifiant = ?");
        $query->execute([$identifiant]);
        // on récupère notre utilisateur
        $utilisateur = $query->fetch(PDO::FETCH_ASSOC);
        var_dump($utilisateur); // juste pour la démo ==> à enlever
    }
// on teste si les 2 mots de passe sont bons
if ($utilisateur && password_verify($mdp, $utilisateur['mdp']))
{
            ?>
            <!DOCTYPE html>
            <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <title>Devoir 5Bis : Connexion à la base de données avec mot de passe Hashé</title>
        </head>
        <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 text-center">
                    <h1>Youpi ! <?= $utilisateur['identifiant'] . " est connecté "; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="mx-auto" style="width: 500px;">
                    <div class="card text-white bg-danger" style="max-width: 200rem;">
                        <div class="card-header">PASSWORD() ou password_hash()</div>
                        <div class="card-body">
                            <h5 class="card-title">Que choisir ?</h5>
                            <p class="card-text text-left">
                                Il est mieux d'utiliser une fonction de hachage : <strong>password_hash()</strong> en PHP, pour
                                hacher les mots de passe côté serveur.
                                Le <strong>password_hash()</strong> utilise des algorithmes de hachage forts et s'occupe des
                                détails de mise en œuvre nécessaires pour assurer la sécurité.
                                Pour la vérification côté php, vous avez <strong>password_verify()</strong> pour
                                comparer le mot de passe saisi avec celui récupéré en base de données.
                            </p>
                            <p>Tandis que l'utilisation de la fonction <strong>PASSWORD()</strong> de MySQL est
                                obsolète et génère un hash insuffisamment sécurisé !</p>
                            <p class="text-center">
                                <button class="btn btn-success" type="button" onclick="accueil()">Retour au formulaire</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // retour à la page d'accueil avec JS
            function accueil()
            {
                window.location.href = "index.php";
            }
        </script>
        </body>
            <?php
        }
        else
        {
            $messageErreur = "L'utilisateur que vous avec saisi est introuvable ou le mot de passe est erroné !";
            header('Location: page_erreur.php?message=' . urlencode($messageErreur));
        }
}
?>