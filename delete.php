<?php
require 'connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: loged.php');
    exit();
}

// Récupérer les données du post-it pour afficher la confirmation
$query = "SELECT * FROM post_it WHERE id=:id";
$response = $bdd->prepare($query);
$response->execute(['id' => $_GET['id']]);
$data = $response->fetch();

// Vérifier si le formulaire de confirmation a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // Supprimer l'enregistrement
    $deleteQuery = "DELETE FROM post_it WHERE id=:id";
    $deleteResponse = $bdd->prepare($deleteQuery);
    $deleteResponse->execute(['id' => $_GET['id']]);

    header('location: loged.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le post-it</title>
</head>
<body>
    <a href='loged.php' title='back'>Retour</a><br>
    <h2>Confirmation de suppression</h2>
    <p>Confirmez-vous la suppression du post-it suivant ?</p>
    
    <strong>Titre:</strong> <?= $data['title'] ?><br>
    <strong>Content:</strong> <?= $data['content'] ?><br>
    <strong>Date:</strong> <?= $data['date'] ?><br>

    <form method="post" action="">
        <input type="submit" name="confirm" value="Confirmer la suppression">
    </form>
</body>
</html>