<?php
// Include config file
require_once "../../db/config.php";

// Define variables and initialize with empty values
$pseudo = $mail = $mdp = "";
$pseudo_err = $mail_err = $mdp_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_pseudo = trim($_POST["pseudo"]);
    if(empty($input_pseudo)){
        $pseudo_err = "Please enter a pseudo.";
    }else{
        $pseudo = $input_pseudo;
    }

    // Validate address address
    $input_mail = trim($_POST["mail"]);
    if(empty($input_mail)){
        $mail_err = "Please enter an email adress.";
    } else{
        $mail = $input_mail;
    }

    // Validate salary
    $input_mdp = trim($_POST["mdp"]);
    if(empty($input_mdp)){
        $mdp_err = "Please enter a password.";
    }else{
        $mdp = $input_mdp;
    }

    // Check input errors before inserting in database
    if(empty($pseudo_err) && empty($mail_err) && empty($mdp_err)){
        // Prepare an update statement
        $sql = "UPDATE user SET pseudo=:pseudo, mail=:mail, mdp=:mdp WHERE id=:id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":pseudo", $param_pseudo);
            $stmt->bindParam(":mail", $param_mail);
            $stmt->bindParam(":mdp", $param_mdp);
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_pseudo = $pseudo;
            $param_mail = $mail;
            $param_mdp = $mdp;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "CALL CRUD_USER_READ(:id)";
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
                    $pseudo = $row["pseudo"];
                    $mail = $row["mail"];
                    $mdp = $row["mdp"];
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
        unset($pdo);
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
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($pseudo_err)) ? 'has-error' : ''; ?>">
                            <label>Pseudo</label>
                            <input type="text" name="pseudo" class="form-control" value="<?php echo $pseudo; ?>">
                            <span class="help-block"><?php echo $pseudo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
                            <label>Adresse Mail</label>
                            <input type="text" name="mail" class="form-control" value=<?php echo $mail; ?> />
                            <span class="help-block"><?php echo $mail_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mdp_err)) ? 'has-error' : ''; ?>">
                            <label>Mot de passe</label>
                            <input type="text" name="mdp" class="form-control" value="<?php echo $mdp; ?>">
                            <span class="help-block"><?php echo $mdp_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../../home.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
