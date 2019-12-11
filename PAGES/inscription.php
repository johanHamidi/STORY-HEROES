<?php

// parametre de la BDD
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'story_heroes';

// Test de connexion avec la BDD
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Si le formulaire a été rempli, on continu
if (isset($_POST['pseudo'], $_POST['mail'], $_POST['mdp'])) {

    // On cherche si le pseudo existe déjà.
    if ($stmt = $con->prepare('SELECT id, mdp FROM user WHERE pseudo = ?')) {

    	$stmt->bind_param('s', $_POST['pseudo']);
    	$stmt->execute();
    	$stmt->store_result();

    	if ($stmt->num_rows > 0) {
    		// Le pseudo existe déjà
    		echo 'Le Pseudo existe déjà :(';
    	} else {
            // Le pseudo n'existe pas, on insert donc le nouvel utilisateur
            if ($stmt = $con->prepare('INSERT INTO user (pseudo, mdp, mail) VALUES (?, ?, ?)')) {
            	// Encodage du mdp
            	$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            	$stmt->bind_param('sss', $_POST['pseudo'], $mdp, $_POST['mail']);
            	$stmt->execute();
            	echo 'Inscription Réussi !';
                header('Location: connexion.php');
            } else {
            	// Erreur lors de la requête
            	echo 'requete SQL error';
            }
    	}
    	$stmt->close();
    } else {
    	// Erreur lors de la requete ou la connexion
    	echo 'requete or connexion SQL error';
    }
    $con->close();

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
                    <input type="text" name="pseudo" id="pseudo" required/>
                </div>
                <div class="flexForm">
                    <label>
                            Votre adresse mail

                    </label>
                    <input  type="email" name="mail" id="mail" required/>
                </div>

                <div class="flexForm">
                        <label>
                                Votre mot de passe

                        </label>
                        <input type="password" name="mdp" id="mdp" required />
                    </div>
            <button class="btnConnexion" type="submit">Inscription</button>
            <p>Vous êtes déjà inscrit ? <a href="connexion.php" class="rejoindre">Connectez-vous</a></p>
            </form>
        </div>
    </div>
</body>
</html>
