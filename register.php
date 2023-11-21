<?php
require 'connection.php';

unset($_SESSION["name"]);




function validationEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $first_Name = $_POST['first_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $password_confirmation = $_POST['password_confirmation'];

    if (!empty($email) && !empty($password) && !empty($name) && !empty($password_confirmation)) {
        if (validationEmail($email) && strlen($password) >= 8) {
            if ($password !== $password_confirmation) {
                echo 'Les mots de passe ne correspondent pas.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insérer les données dans la base de données
                try {
                    $stmt = $bdd->prepare("INSERT INTO admin (first_name, name, email, password) VALUES (:first_name, :name, :email, :password)");
                    $stmt->bindParam(':first_name', $first_Name);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->execute();
                    $_SESSION['islog'] = true;

                    echo "Données enregistrées avec succès.";
                    $_SESSION["name"] = $name;
                    // Rediriger après l'insertion des données
                    header("Location: loged.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
        } else {
            echo 'Email invalide ou mot de passe trop court (minimum 8 caractères).';
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
} else {
        
    echo "Erreur CSRF : Tentative de manipulation du formulaire détectée.";
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
</head>
<body>

<form action="register.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="first-name">Prénom :</label>
    <input type="text" id="first_name" name="first_name"><br>

    <label for="name">Nom :</label>
    <input type="text" id="name" name="name"><br>

    <label for="email">Email :</label>
    <input type="text" id="email" name="email"><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password"><br>

    <label for="password_confirmation">Confirmer le mot de passe :</label>
    <input type="password" id="password_confirmation" name="password_confirmation"><br>

    <input type="submit" value="S'inscrire">

</form>
    
</body>
</html>
