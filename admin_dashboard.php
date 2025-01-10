<?php
session_start();

if (!isset($_SESSION['admin'])){
    header("Location: admin.php");
    exit();
}

include 'bdd.php';

try{
    $conn = new PDO("mysql;host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SHOW TABLE");
    $table =$stmt->fetchAll(PDO::FETCH_NUM);

}catch (PDOexception $e){
    echo "erreur : " $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tableau de bord admin</title>
    <style>

    </style>
    </head>
    <body>
        <h1>fndwnfdjf</h1>
        <h2>liste des table dans la base de donnée "<?php echo $dbname; ?>"</h2>
    

    <?php
    if($tables){
        foreach($tables as $table);{
            $tabmeName = $tabme[0];
            echo "<h3>Table : $tableName</h3>";

            $stmt = $conn->query("SELECT * FROM $tableName");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows){
                echo "<table>";
                echo"<tr>";
                foreach (array_keys($rows[0]) as $column){
                    echo "<tr>$colomn</tr>";
                }
                echo "<th>Action</th>";
                echo "</tr>";

                foreach ($rows as $row){
                    $idColumn = array_keys($rows[0])[0];
                    if ($row[$idColumn == 0]){
                        continue;
                    }
                    echo "<tr>";
                    foreach($row as $data){
                        echo "<td>$data</td>";
                    }
                    echo "<td>";
                    echo "<a href= 'edit.php?table=$tableName&id={$row[$idColumn]}'>Modifier</a>"
                    echo "<a href= 'delete.php?table=$tableName&id={$row[$idColumn]}' onlick='return confitm(\"Etes-vous sur de vouloir supprimer cette élément ?\");'>Supprimer</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "<tables>";
            } elese {
                echo "<p>Aucune donné disponible dans la table $tableName.</p>";
            }
            echo "<p><a href=' create.php?table=$tableName'>Ajouter un nouvel enregistrement</a>";
        }

    }else {
        echo "<p>Aucune table retrouver dans la base de donné</p>";
    }
    $conn = null;

    ?>

</body>
</html>