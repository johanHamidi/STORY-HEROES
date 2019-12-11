<?php
//Config bdd
require_once("../../db/config.php");

//Déclaration de nos variables
$libelle = $destination = "";
$libelle_err = $destination_err = "";



//Vérification de nos champs
//Récupération POST des données de notre formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(!empty($_POST["etape"])){
    $etape = $_POST["etape"];
  }

  // Vérification + Récupération du champ libelle
  $input_libelle = trim($_POST["libelle"]);
  //Si le champ est vide
  if(empty($input_libelle)){
      //Message d'erreur
      $libelle_err = "Renseignez un libelle.";
  } else{
      //Création variable libelle contenant la valeur saisit
      $libelle = $input_libelle;
  }

  // Vérification + Récupération du champ libelle
  $input_destination = trim($_POST["lst_etape"]);
  //Si le champ est vide
  if(empty($input_destination)){
      //Message d'erreur
      $destination_err = "Veuiller sélectionner une étape.";
  } else{
      //Création variable libelle contenant la valeur saisit
      $destination = $input_destination;
  }



  //Vérification des messages d'erreur
  if(empty($libelle_err) && empty($destination_err)){

    //Si aucune erreur, on appel notre procédure stocké d'insertion
    $sql = "CALL CRUD_CHOIX_INSERT(:libelle, :destination, :Id_Etape)";

    //Si la procédure stocké existe
    if($stmt = $pdo->prepare($sql)){

      //Gestion des paramètres
      //Bind des paramètres
      $stmt->bindParam(":libelle", $param_libelle);
      $stmt->bindParam(":destination", $param_destination);
      $stmt->bindParam(":Id_Etape", $param_etape);

      //Renseignement des paramètre avec nos valeur saisit
      $param_libelle = $libelle;
      $param_destination = $destination;
      $param_etape = $etape;

      //Execution de la procédure
      if($stmt->execute()){
          header("location: ../..");
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
                        <h2>Ajouter un choix</h2>
                    </div>
                    <p>Seul les champs avec un * sont obligatoires</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($libelle_err)) ? 'has-error' : ''; ?>">
                            <label>Libelle*</label>
                            <input type="text" name="libelle" class="form-control" value="<?php echo $libelle; ?>">
                            <span class="help-block"><?php echo $libelle_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($destination_err)) ? 'has-error' : ''; ?>">
                            <label>Ce choix pointe vers l'étape :</label>
                            <select class="form-control" name="lst_etape">
                      <?php
                      $sql = "CALL CRUD_STORY_ETAPE_READ(" . $_GET['story'] . ")";
                      if($result = $pdo->query($sql)){
                          if($result->rowCount() > 0){
                          while($row = $result->fetch()){
                            echo "<option value=" . $row["id"] . ">";
                            echo $row["id"] . " - " . $row["titre"];
                            echo "</option>";
                          }
                        }
                      }
                      ?>
                      </select>
                            
                            <span class="help-block"><?php echo $destination_err;?></span>
                        </div>

                        
                        <input type="hidden" name="etape" value="<?php echo trim($_GET["id"]); ?>">

                        <input type="submit" class="btn btn-primary" value="Ajouter le choix">
                        <div class="btn btn-default" onclick="window.history.back()">Retour</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>
