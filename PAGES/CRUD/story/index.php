<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./CRUD/style/bootstrap.css">
    <script src="./CRUD/style/jquery.min.js"></script>
    <script src="./CRUD/style/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 90%;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Histoire</h2>
                        <a href="create.php" class="btn btn-success pull-right">Ajouter une histoire</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../../db/config.php";

                    // Attempt select query execution
                    $sql = "CALL SPEC_STORY_INDEX(0)";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Titre</th>";
                                        echo "<th>Auteur</th>";
                                        echo "<th>Image</th>";
                                        echo "<th>Publiée</th>";
                                        echo "<th></th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){

                                  if($row['est_publie'] == 1){$class = "bg-success"; $contenu = "En ligne";}else{$class = "bg-danger"; $contenu = "Hors ligne";}

                                    echo "<tr>";

                                        echo "<td>" . $row['titre'] . "</td>";
                                        echo "<td>" . $row['pseudo'] . "</td>";
                                        echo "<td>" . $row['image'] . "</td>";

                                        echo "<td>" . utf8_decode($row['titre']) . "</td>";
                                        echo "<td>" . utf8_decode($row['pseudo']) . "</td>";

                                        echo "<td class=$class>" . $contenu . "</td>";
                                        echo "<td>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Modifier cette histoire' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Supprimer cette histoire' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>Aucune histoires trouvées</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }

                    // Close connection
                    unset($pdo);
                    ?>

                    <a href="../" class="btn btn-default pull-right">Retour au menu</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
