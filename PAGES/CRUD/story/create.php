<?php
// Include config file
require_once "../../db/config.php";

// Define variables and initialize with empty values
$titre = $resume = $est_publie = $auteur = "";
$titre_err = $resume_err = $est_publie_err = $auteur_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate titre
    $input_titre = trim($_POST["titre"]);
    if(empty($input_titre)){
        $titre_err = "Renseignez un titre.";
    } else{
        $titre = $input_titre;
    }

    // Validate resume
    $input_resume = trim($_POST["resume"]);
    if(empty($input_resume)){
        $resume_err = "Un résumé de l'histoire est requis";
    } else{
        $resume = $input_resume;
    }

    // Liste auteur
    $input_auteur = trim($_POST["auteur"]);
    if(empty($input_auteur)){
        $titre_err = "Sélectionnez un auteur";
    } else{
        $auteur = $input_auteur;
    }

    //$image = $_POST["Image"];
    $image = "null";

    // Validate est_publie
    // $input_est_publie = trim($_POST["est_publie"]);
    // if(empty($input_est_publie)){
    //     $est_publie_err = "Please enter the salary amount.";
    // }else{
    //     $est_publie = $input_est_publie;
    // }

    // Validate auteur
    // $input_auteur = trim($_POST["fk_id_auteur"]);
    // if(empty($input_auteur)){
    //     $auteur_err = "Auteur de l'histoire";
    // } else{
    //     $auteur = $input_auteur;
    // }



    // Check input errors before inserting in database
    if(empty($titre_err) && empty($resume_err) && empty($est_publie_err)){
        // Prepare an insert statement
        $sql = "CALL CRUD_STORY_INSERT(:titre, :resume, :est_publie, :image, :fk_id_auteur)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":titre", $param_titre);
            $stmt->bindParam(":resume", $param_resume);
            $stmt->bindParam(":est_publie", $param_est_publie);
            $stmt->bindParam(":image", $param_image);
            $stmt->bindParam(":fk_id_auteur", $param_auteur);

            // Set parameters
            $param_titre = $titre;
            $param_resume = $resume;
            $param_est_publie = 0;
            //$param_auteur = $auteur;
            $param_image = $image;
            $param_auteur = $auteur;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: ../../home.php");
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Créer une histoire</title>
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
                        <h2>Créer une histoire</h2>
                    </div>
                    <p>Complété tous les champs pour ajouter une histoire</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($titre_err)) ? 'has-error' : ''; ?>">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control" value="<?php echo $titre; ?>">
                            <span class="help-block"><?php echo $titre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($resume_err)) ? 'has-error' : ''; ?>">
                            <label>Résumé de l'histoire</label>
                            <textarea name="resume" class="form-control" placeholder="500 caractères max"><?php echo $resume; ?></textarea>
                            <span class="help-block"><?php echo $resume_err;?></span>
                        </div>

                        <!-- Liste des auteurs -->
                        <div class="form-group <?php echo (!empty($auteur_err)) ? 'has-error' : ''; ?>">
                            <label>Auteur de l'histoire</label>
                            <select class="form-control" name="auteur">

                          <?php
                          $sql = "CALL CRUD_USER_READ(0)";
                          if($result = $pdo->query($sql)){
                              if($result->rowCount() > 0){
                              while($row = $result->fetch()){
                                echo "<option value=$row[id]>";
                                echo $row["pseudo"];
                                echo "</option>";
                              }
                            }
                          }
                          ?>

                          </select>
                            <span class="help-block"><?php echo $auteur_err;?></span>
                        </div>






                       <!-- <form enctype="multipart/form-data" method="post" action="ajoutPostuler.php">
                        </form>!-->





                        <input type="submit" class="btn btn-primary" value="Ajouter l'histoire">
                        <a href="../../home.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
