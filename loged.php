<?php

require 'connection.php';



if (!isset($_SESSION['islog'])) {
    
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>Memento</title>
</head>
<body>
    <header>
        <nav class="navi">
            <div><h3>memento</h3></div>
            <div>
                <?php
                

                if (isset($_SESSION['islog'])) {
                    
                    echo '<span>Bonjour, ' . $_SESSION['name'] . '</span>';
                    echo '<a href="index.php">Déconnexion</a>';
                } 
                ?>
            </div>
            

        </nav>
        <hr>
    </header>
    
    <main>
    <h2 class="little_title">Memento</h2>
<a href="new.php" class="button">Ajouter un post-it</a>

<container class="container_un">

<?php
$query = "SELECT * FROM post_it";
$response = $bdd->query($query);
$datas = $response->fetchAll();

foreach ($datas as $data) {
?>
    <div class="post-it">
        <h4><?= $data['title'] ?></h4>
        <p><?= $data['content'] ?><br><?= $data['date'] ?></p>
        <div><a href='delete.php?id=<?= $data['id'] ?>' title='<?= $data['title'] ?>'>Supprimer</a></div>
    </div>
<?php
}
?>
</container>
    </main>
</body>
</html>