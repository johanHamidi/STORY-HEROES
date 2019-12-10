<?php
// Process delete operation after confirmation
if(isset($_POST["story"]) && !empty($_POST["story"]) && isset($_POST["genre"]) && !empty($_POST["genre"])){
    // Include config file
    require_once "../../db/config.php";

    // Prepare a delete statement
    $sql = "CALL CRUD_STORY_GENRE_DELETE(:story,:genre)";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":story", $param_story);
        $stmt->bindParam(":genre", $param_genre);

        // Set parameters
        $param_story = trim($_POST["story"]);
        $param_genre = trim($_POST["genre"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: ../story/update.php?id=".$param_story);
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["story"]))){
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
    <title>Supprimer un genre de cette histoire</title>
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
                        <h1>Supprimer un genre de cette histoire</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="story" value="<?php echo trim($_GET["story"]); ?>"/>
                            <input type="hidden" name="genre" value="<?php echo trim($_GET["genre"]); ?>"/>

                            <p>Etes vous sur de vouloir supprimer ce genre</p><br>
                            <p>
                                <input type="submit" value="Oui" class="btn btn-danger">
                                <a href="../../home.php" class="btn btn-default">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
