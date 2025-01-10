<?php
// Database connection settings
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "cheyssoi";

$showModal = false;

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_entreprise = $conn->real_escape_string($_POST["nom_entreprise"]);
    $prenom_pro = $conn->real_escape_string($_POST["prenom_pro"]);
    $nom_pro = $conn->real_escape_string($_POST["nom_pro"]);
    $intitule_poste = $conn->real_escape_string($_POST["intitule_poste"]);
    $secteur_activite = $conn->real_escape_string($_POST["secteur_activite"]);
    $email_pro = $conn->real_escape_string($_POST["email_pro"]);
    $numero_telephone = $conn->real_escape_string($_POST["numero_telephone"]);
    $siret = $conn->real_escape_string($_POST["siret"]);
    $pays_region = $conn->real_escape_string($_POST["pays_region"]);

    $sql = "INSERT INTO professionnel (nom_entreprise, prenom_pro, nom_pro, intitule_poste, secteur_activite, email_pro, numero_telephone, siret, pays_region) 
            VALUES ('$nom_entreprise', '$prenom_pro', '$nom_pro', '$intitule_poste', '$secteur_activite', '$email_pro', '$numero_telephone', '$siret', '$pays_region')";
    if ($conn->query($sql) === TRUE) {
        $showModal = true;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleses.css">
</head>
<body>

<div class="container mt-5">
    <form method="post">
        <div class="row">
            <div class="col-md-6">
                <label for="nom_entreprise">Nom de l'Entreprise:</label>
                <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="prenom_pro">Prénom:</label>
                <input type="text" id="prenom_pro" name="prenom_pro" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="nom_pro">Nom:</label>
                <input type="text" id="nom_pro" name="nom_pro" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="intitule_poste">Intitulé du Poste:</label>
                <input type="text" id="intitule_poste" name="intitule_poste" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="secteur_activite">Secteur d'Activité:</label>
                <input type="text" id="secteur_activite" name="secteur_activite" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="email_pro">Email:</label>
                <input type="email" id="email_pro" name="email_pro" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="numero_telephone">Numéro de Téléphone:</label>
                <input type="tel" id="numero_telephone" name="numero_telephone" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="siret">SIRET:</label>
                <input type="text" id="siret" name="siret" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="pays_region">Pays / Région:</label>
                <input type="text" id="pays_region" name="pays_region" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
    </form>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" <?= $showModal ? 'data-backdrop="static"' : ''; ?>>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p>Votre demande a bien été envoyée.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
<?php if ($showModal): ?>
    $(document).ready(function(){
        $('#confirmationModal').modal('show');
    });
<?php endif; ?>
</script>

</body>
</html>
