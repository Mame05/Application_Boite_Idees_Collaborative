<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Inclure le fichier */
require_once "config.php";
 
/* Definir les variables */
$titre = $description = $date_soumission = $id_catégorie = "";
$titre_err = $description_err = $date_soumission_err = $id_categorie_err = "";
/* verifier la valeur id dans le post pour la mise à jour */
if(isset($_POST["id"]) && !empty($_POST["id"])){
    /* recuperation du champ caché */
    $id = $_POST["id"];
    /* Validation du titre */
    $input_titre = trim($_POST["titre"]);
     if(empty($input_titre)){
         $titre_err = "Veuillez entrez un titre.";
     } elseif(!filter_var($input_titre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-ZÀ-ÿ\s.,!?()'-]+$/u")))){
         $titre_err = "Veuillez entrez un nom de titre valide.";
    } else{
        $titre = $input_titre;
    }
    /* Validation de la description */
    $input_description = trim($_POST["description"]);
     if(empty($input_description)){
         $description_err = "Veuillez entrez la description.";     
     }  elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-ZÀ-ÿ\s.,!?()'-]+$/u")))){
         $description_err = "Veuillez entrez un text correct.";
     }else{
        $description = $input_description;
      }
      /* Validation de la date de soumission */
      $input_date_soumission = trim($_POST["date_soumission"]);
      if(empty($input_date_soumission)){
          $date_soumission_err = "Veuillez entrez la date de soumission.";     
      }  else{
          $date_soumission = $input_date_soumission;
     }
     $input_id_categorie = trim($_POST["id_categorie"]);
     if(empty($input_id_categorie)){
         $id_categorie_err = "Veuillez donnez l'identifiant du categorie.";     
     } else{
         $id_categorie = $input_id_categorie;
      }
    /* verifier les erreurs avant modification */
    if(empty($titre_err) && empty($description_err) && empty($date_soumission_err) && empty($id_categorie_err)){
        $sql = "UPDATE Idee SET titre=?, description=?, date_soumission=?, id_categorie=?  WHERE id=?";
         
        if($stmt = mysqli_prepare($connexion, $sql)){
            mysqli_stmt_bind_param($stmt, "sssii", $param_titre, $param_description, $param_date_soumission, $param_id_categorie, $param_id);
             $param_titre = $titre;
             $param_description = $description;
             $param_date_soumission = $date_soumission;
             $param_id_categorie = $id_categorie;
             $param_id = $id;
            if(mysqli_stmt_execute($stmt)){
                /* enregistremnt modifié, retourne */
                header("location: index.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
    }
} else{
    /* si il existe un paramettre id */
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        $sql = "SELECT id, titre, description, date_soumission, id_categorie FROM Idee WHERE id = ?";
        if($stmt = mysqli_prepare($connexion, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 1){
                    /* recupere l'enregistremnt */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    /* recupere les champs */
                    $titre = $row["titre"];
                    $description = $row["description"];
                    $date_soumission = $row["date_soumission"];
                    $id_categorie = $row["id_categorie"];
                } else{   
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
    }  else{
        /* pas de id parametter valid, retourne erreur */
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistremnt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Mise à jour de l'enregistrement</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="" method="post">   <?php //echo htmlspecialchars(basename($_SERVER['REQUEST_URI']));?>
                    <div class="form-group">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control <?php echo (!empty($titre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titre; ?>">
                            <span class="invalid-feedback"><?php echo $titre_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date de soumission</label>
                            <input type="date" name="date_soumission" class="form-control <?php echo (!empty($date_soumission_err))? 'is-invalid' : ''; ?>" value="<?php echo $date_soumission; ?>">
                            <span class="invalid-feedback"><?php echo $date_soumission_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>L'identité du catégorie</label>
                            <input type="number" name="id_categorie" class="form-control <?php echo (!empty($id_categorie_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id_categorie; ?>">
                            <span class="invalid-feedback"><?php echo $id_categorie_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
 