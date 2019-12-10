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