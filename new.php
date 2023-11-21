<?php

require "connection.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = $_POST['date'];

        try {
            $stmt = $bdd->prepare("INSERT INTO post_it (title, content, date) VALUES (:title, :content, :date)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date', $date);
            $stmt->execute();

            echo "Données enregistrées avec succès.";
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        
        echo "Erreur CSRF : Tentative de manipulation du formulaire détectée.";
    }
}
?>

<a href='loged.php' title='back'>Back</a><br>
<h1>Ajouter un post-it</h1>
<form method="POST" action="new.php">
    
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <div class="form-floating mb-3">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
    </div>
    <div class="form-floating">
        <label for="content">Content</label>
        <input type="text" name="content" class="form-control" id="content" placeholder="Content" required>
    </div>
    <div class="form-floating">
        <label for="date">Date</label>
        <input type="date" name="date" class="form-control" id="date" placeholder="Date" required>
    </div>
    <button type="submit" class="btn">Envoyer</button>
</form>


</body>
</html>
