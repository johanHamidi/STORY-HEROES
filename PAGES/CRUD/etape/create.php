<?php
//Config bdd
require_once("../../db/config.php");

//Déclaration de nos variables
$titre = $description = $image = $est_une_fin = $story = "";
$titre_err = $description_err = $image_err = $est_une_fin_err = "";



//Vérification de nos champs
//Récupération POST des données de notre formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(!empty($_POST["story"])){
    $story = $_POST["story"];
  }

  // Vérification + Récupération du champ titre
  $input_titre = trim($_POST["titre"]);
  //Si le champ est vide
  if(empty($input_titre)){
      //Message d'erreur
      $titre_err = "Renseignez un titre.";
  } else{
      //Création variable titre contenant la valeur saisit
      $titre = $input_titre;
  }

  // Vérification + Récupération du champ description
  $input_description = $_POST["description"];
  //Si le champ est vide
  if(empty($input_description)){
      //Message d'erreur
      $description_err = "Renseignez une description.";
  } else{
      //Création variable titre contenant la valeur saisit
      $description = $input_description;
  }

  //TODO : Vérification du type de fichier + message d'erreur
  $input_image = trim($_POST["image"]);
  $image = $input_image;

  //Récupération du champ description
  $input_est_une_fin = trim($_POST["est_une_fin"]);
  $est_une_fin = $input_est_une_fin;



  //Vérification des messages d'erreur
  if(empty($titre_err) && empty($description_err) && empty($image_err) && empty($est_une_fin_err)){

    //Si aucune erreur, on appel notre procédure stocké d'insertion
    $sql = "CALL CRUD_ETAPE_INSERT(:titre, :description, :image, :est_une_fin, :fk_id_story)";

    //Si la procédure stocké existe
    if($stmt = $pdo->prepare($sql)){

      //Gestion des paramètres
      //Bind des paramètres
      $stmt->bindParam(":titre", $param_titre);
      $stmt->bindParam(":description", $param_description);
      $stmt->bindParam(":image", $param_image);
      $stmt->bindParam(":est_une_fin", $param_est_une_fin);

      //Pas propre : A revoir
      $stmt->bindParam(":fk_id_story", $param_fk_id_story);


      //Renseignement des paramètre avec nos valeur saisit
      $param_titre = $titre;
      $param_description = $description;
      $param_image = $image;

      //Pas propre : A revoir
      $param_fk_id_story = $story;

      //Convertion de la chaîne "true" en valeur booléenne true
      if ($est_une_fin == "true") {
        $est_une_fin = 1;
      }else {
        $est_une_fin = 0;
      }
      $param_est_une_fin = $est_une_fin;

      //Execution de la procédure
      if($stmt->execute()){
          // Si la procédure c'est exécutée correctement, on redirige sur l'histoire à laquelle appartient notre étape
          $redirect = "location: ../story/update.php?id=$story";
          //echo"<meta http-equiv='refresh' content='durée;URL=../story/update?id=$story'>";
          header($redirect);
          // exit();
      } else{
          echo "Erreur lors de l'execution de la procédure d'insertion";
      }
    }
    //Fermeture de la requête
    unset($stmt);
  }
  // Fermeture de la connexion
  unset($pdo);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Créer une étape</title>
    <link rel="stylesheet" href="../style/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Créer une étape</h2>
                    </div>
                    <p>Seul les champs avec un * sont obligatoires</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($titre_err)) ? 'has-error' : ''; ?>">
                            <label>Titre*</label>
                            <input type="text" name="titre" class="form-control" value="<?php echo $titre; ?>">
                            <span class="help-block"><?php echo $titre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Description*</label>
                            <textarea name="description" class="form-control" maxlength="500"><?php echo $description; ?></textarea>
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" title="Ajouter une image">
                            <span class="help-block"><?php echo $image_err;?></span>
                        </div>
                        <div class="form-group">
                          <label>Cette étape est-elle une fin de l'histoire ?</label><br/>
                          <label style="font-weight : normal;"><input type="radio" name="est_une_fin" value="true">Oui</label>
                          <label style="font-weight : normal;"><input type="radio" name="est_une_fin" value="false" checked>Non</label>
                          <span class="help-block"><?php echo $est_une_fin_err;?></span>
                        </div>

                        <input type="hidden" name="story" value="<?php echo trim($_GET["story"]); ?>">

                        <input type="submit" class="btn btn-primary" value="Ajouter cette étape">
                        <div class="btn btn-default" onclick="window.history.back()">Retour</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
