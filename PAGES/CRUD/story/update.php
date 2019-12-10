<?php
// Include config file
require_once "../../db/config.php";

// Define variables and initialize with empty values
$titre = $resume = $est_publie =  "";
$titre_err = $resume_err = $est_publie_err ="";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_titre = trim($_POST["titre"]);
    if(empty($input_titre)){
        $titre_err = "Please enter a pseudo.";
    }else{
        $titre = $input_titre;
    }

    // Validate address address
    $input_resume = trim($_POST["resume"]);
    if(empty($input_resume)){
        $resume_err = "Please enter an email adress.";
    } else{
        $resume = $input_resume;
    }

    //Validate salary
    $input_est_publie = trim($_POST["est_publie"]);
    if(empty($input_est_publie)){
        $est_publie_err = "Please enter a password.";
    }else{
        $est_publie = $input_est_publie;
    }

    // Check input errors before inserting in database
    if(empty($titre_err) && empty($resume_err) && empty($est_publie_err)){
        // Prepare an update statement
        $sql = "CALL CRUD_STORY_UPDATE(:id, :titre, :resume, :est_publie)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":titre", $param_titre);
            $stmt->bindParam(":resume", $param_resume);
            $stmt->bindParam(":est_publie", $param_est_publie);
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_titre = $titre;
            $param_resume = $resume;
            if ($est_publie == "true") {
              $est_publie = true;
            }else {
              $est_publie = false;
            }

            $param_est_publie = $est_publie;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "CALL CRUD_STORY_READ(:id)";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    $titre = $row["titre"];
                    $resume = $row["resume"];
                    $est_publie = $row["est_publie"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        //unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier une histoire</title>
    <link rel="stylesheet" href="../style/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 50%;
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
                        <h2>Modifier une histoire</h2>
                    </div>
                    <p>Modifier puis valider pour enregistrer les modifications</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($titre_err)) ? 'has-error' : ''; ?>">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control" value="<?php echo $titre; ?>">
                            <span class="help-block"><?php echo $titre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($resume_err)) ? 'has-error' : ''; ?>">
                            <label>Résumé de l'histoire</label>
                            <textarea class="form-control"  name="resume" rows="7" cols="80" maxlength="500"><?php echo $resume; ?></textarea>
                            <span class="help-block"><?php echo $resume_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($est_publie_err)) ? 'has-error' : ''; ?>">
                            <label class="<?php if($est_publie){echo "bg-success";}else{echo "bg-danger";} ?>">
                              Histoire Publiée : <?php if($est_publie){echo "OUI";}else{echo "NON";} ?>
                            </label>
                            <div class="form-group">
                              <input type="radio" name="est_publie" value="true" <?php if($est_publie){echo "checked";}?>>Oui
                              <input type="radio" name="est_publie" value="false" <?php if(!$est_publie){echo "checked";}?>>Non
                              <span class="help-block"><?php echo $est_publie_err;?></span>
                            </div>


                        </div>


                        <!-- Gestion des genres -->
                        <div class="form-group">
                            <a href="../story_genre/add_genre.php?idStory=<?php echo $_GET["id"]; ?>" class="btn btn-success pull-right">Ajouter un genre</a>

                            <?php

                            //Afiichage des étape de l'histoire
                            $sql = "CALL SPEC_STORY_GENRE($id)";

                            if($result = $pdo->query($sql)){
                              if($result->rowCount() > 0){
                            ?>
                                <table class="table">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th scope="col">Genre(s) de l'histoire</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                            <?php
                                while($row = $result->fetch()){
                                  echo "<tr>";
                                  echo "<td>";
                                  echo $row["libelle"];
                                  echo "<a href='../story_genre/delete.php?story=". $row['fk_id_story'] . "&genre=" . $row['fk_id_genre'] . "' title='Supprimer ce genre' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                  echo "</td>";
                                  echo "</tr>";
                                }
                            ?>
                                    </tbody>
                                </table>
                            <?php
                              }else{
                                  echo "<p class='lead'><em>Aucun genre attibué à cet histoire</em></p>";
                              }
                              unset($result);
                            }
                            else{
                                echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                            }

                            ?>
                        </div>
                        <!-- Gestion des étapes -->
                        <div class="form-group">
                            <a href="../etape/create.php?story=<?php echo $id; ?>" class="btn btn-success pull-right">Ajouter une étape</a>


                                  <!-- <th scope="row">1</th>
                                  <td>Mark</td> -->
                                  <?php

                                  //Afiichage des étape de l'histoire

                                  $sql = "CALL CRUD_STORY_ETAPE_READ($id)";

                                  if($result = $pdo->query($sql)){
                                    if($result->rowCount() > 0){
                                  ?>
                                      <table class="table">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Étape</th>
                                            <th scope="col">Titre</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                  <?php
                                      while($row = $result->fetch()){
                                        echo "<tr id=" . $row["num_etape"] . ">";
                                        echo "<th scope='row'>";
                                        echo "<input type='text' value='". $row["num_etape"] ."'></input>";
                                        echo "</th>";

                                        echo "<td>";
                                        echo $row["titre"];
                                        echo "<a href='delete.php?id=". $row["id"] ."&story = ' title='Supprimer cette étape' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";

                                        echo "</td>";
                                        echo "</tr>";
                                      }
                                  ?>
                                          </tbody>
                                      </table>
                                  <?php
                                      unset($result);
                                    }else{
                                        echo "<p class='lead'><em>Aucune étapes trouvées</em></p>";
                                    }
                                  }
                                  else{
                                      echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                                  }

                                  ?>

                        </div>


                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enregistrer les modifications">
                        <a href="index.php" class="btn btn-default">Retour</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
