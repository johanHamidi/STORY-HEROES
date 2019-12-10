<?php
// Include config file
require_once "../../db/config.php";

// Define variables and initialize with empty values
$pseudo = $mail = $mdp = "";
$pseudo_err = $mail_err = $mdp_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_pseudo = trim($_POST["pseudo"]);
    if(empty($input_pseudo)){
        $pseudo_err = "Please enter a pseudo.";
    } else{
        $pseudo = $input_pseudo;
    }

    // Validate address
    $input_mail = trim($_POST["mail"]);
    if(empty($input_mail)){
        $mail_err = "Please enter a mail.";
    } else{
        $mail = $input_mail;
    }

    // Validate salary
    $input_mdp = trim($_POST["mdp"]);
    if(empty($input_mdp)){
        $mdp_err = "Please enter the salary amount.";
    }else{
        $mdp = $input_mdp;
    }

    // Execution procédure stockée
     if(empty($pseudo_err) && empty($mail_err) && empty($mdp_err)){
        // Prepare an insert statement
        $sql = "CALL CRUD_USER_INSERT(:pseudo, :mdp, :mail)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":pseudo", $param_pseudo);
            $stmt->bindParam(":mdp", $param_mdp);
            $stmt->bindParam(":mail", $param_mail);


            // Set parameters
            $param_pseudo = $pseudo;
            $param_mdp = md5($mdp);
            $param_mail = $mail;


            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($pseudo_err)) ? 'has-error' : ''; ?>">
                            <label>Pseudo</label>
                            <input type="text" name="pseudo" class="form-control" value="<?php echo $pseudo; ?>">
                            <span class="help-block"><?php echo $pseudo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
                            <label>Adresse Mail</label>
                            <textarea name="mail" class="form-control"><?php echo $mail; ?></textarea>
                            <span class="help-block"><?php echo $mail_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mdp_err)) ? 'has-error' : ''; ?>">
                            <label>Mot de Passe</label>
                            <input type="text" name="mdp" class="form-control" value="<?php echo $mdp; ?>">
                            <span class="help-block"><?php echo $mdp_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
