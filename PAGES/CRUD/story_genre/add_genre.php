<?php
//Config bdd
require_once("../../db/config.php");

//Déclaration de nos variables
$fk_id_genre = "";
$fk_id_genre_err = "";



//Vérification de nos champs
//Récupération POST des données de notre formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(!empty($_POST["idStory"])){
    $story = $_POST["idStory"];
  }

  // Vérification + Récupération du champ titre
  $input_fk_id_genre = trim($_POST["Liste_Genre"]);
  //Si le champ est vide
  if(empty($input_fk_id_genre)){
      //Message d'erreur
      $fk_id_genre_err = "Renseignez un genre.";
  } else{
      //Création variable titre contenant la valeur saisit
      $fk_id_genre = $input_fk_id_genre;
  }


  //Vérification des messages d'erreur
  if(empty($fk_id_genre_err)){

    //Si aucune erreur, on appel notre procédure stocké d'insertion
    $sql = "CALL CRUD_STORY_GENRE_INSERT(:fk_id_story, :fk_id_genre)";

    //Si la procédure stocké existe
    if($stmt = $pdo->prepare($sql)){

      //Gestion des paramètres
      //Bind des paramètres
      $stmt->bindParam(":fk_id_story", $param_fk_id_story);
      $stmt->bindParam(":fk_id_genre", $param_fk_id_genre);



      //Renseignement des paramètre avec nos valeur saisit
      $param_fk_id_story = $story;
      $param_fk_id_genre = $fk_id_genre;

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

$story_libelle = "";
if(isset($_GET["idStory"]) && !empty($_GET["idStory"])){

  $IdStory = $_GET["idStory"];
  $sql = "CALL CRUD_STORY_READ($IdStory)";
  if($result = $pdo->query($sql)){
      if($result->rowCount() > 0){
      while($row = $result->fetch()){
        $story_libelle = $row["titre"];
      }
    }
    unset($result);
  }

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
                        <h2>Ajouter un genre à l'histoire : <?php echo "<br/>" . $story_libelle; ?></h2>
                    </div>
                    <p>Seul les champs avec un * sont obligatoires</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fk_id_genre_err)) ? 'has-error' : ''; ?>">
                            <label>Genre*</label>
                            <select class="form-control" name="Liste_Genre">
                              <?php
                              $sql = "CALL CRUD_GENRE_READ(0)";
                              if($result = $pdo->query($sql)){
                                  if($result->rowCount() > 0){
                                  while($row = $result->fetch()){
                                    echo "<option value=$row[id]>";
                                    echo $row["libelle"];
                                    echo "</option>";
                                  }
                                }
                              }
                              ?>
                      </select>
                            <span class="help-block"><?php echo $fk_id_genre_err;?></span>
                        </div>

                        <input type="hidden" name="idStory" value="<?php echo trim($_GET["idStory"]); ?>">

                        <input type="submit" class="btn btn-primary" value="Ajouter un genre">
                        <div class="btn btn-default" onclick="window.history.back()">Retour</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
