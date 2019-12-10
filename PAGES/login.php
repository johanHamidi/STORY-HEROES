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
    		header('Location: index.php');
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
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="pseudo" placeholder="Username" id="pseudo" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="mdp" placeholder="Password" id="mdp" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>
