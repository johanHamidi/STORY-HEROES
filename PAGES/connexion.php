<?php
session_start();

//Parametre de la base de donnée
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'story_heroes';

// Tentative de connexion à la base de donnée
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Affichage d'un message d'erreur si la connexion échoue
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// On vérifie si les informations du formulaire ont été remplies
if ( isset($_POST['pseudo'], $_POST['mdp']) ) {

    // Préparation de la requête SQL
    if ($stmt = $con->prepare('SELECT id, mdp FROM user WHERE pseudo = ?')) {
    	$stmt->bind_param('s', $_POST['pseudo']);
    	$stmt->execute();
        // On garde l'information pour vérifier si l'utilisateur existe dans la base de donnée
    	$stmt->store_result();
    }
    if ($stmt->num_rows > 0) {
    	$stmt->bind_result($id, $mdp);
    	$stmt->fetch();
    	// L'utilisateur existe, vérification du mdp
    	// PS: Penser à utiliser password_hash pour encoder avec les parametres par defaut
        // lors de l'inscription : password_hash("mdp", PASSWORD_DEFAULT);
    	if (password_verify($_POST['mdp'], $mdp)) {
    		// Mdp correct
    		// Creation de la session
    		session_regenerate_id();
    		$_SESSION['loggedin'] = TRUE;
    		$_SESSION['name'] = $_POST['pseudo'];
    		$_SESSION['id'] = $id;
    		header('Location: home.php');
    	} else {
    		echo 'Incorrect password!';
    	}
    } else {
    	echo 'Incorrect username!';
    }
    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="fond">
        <div class="cadre">
            <div>
                <div class="flexConnexion">
                    <img src="img/logo.png" alt="logo" />
                    <h1>Story Heroes</h1>
                </div>
            </div >
            <form class="centerForm" action="" method="POST">
                <div class="flexForm">
                    <label>
                            Votre nom d'héros   
                    </label>
                    <input type="text" name="pseudo" id="pseudo" required />
                </div>
                <div class="flexForm">
                    <label>
                            Votre mot de passe
                            
                    </label>
                    <input type="password" name="mdp" id="mdp" required/>
                </div>
            <button class="btnConnexion" type="submit">Connexion</button>
            <p>Vous n'est pas encore inscris ? <a href="inscription.php" class="rejoindre">Rejoignez-nous</a></p>
            </form>
        </div> 
    </div>
</body>
</html>