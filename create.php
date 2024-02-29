<?php
/* Inclure le fichier config */
require_once "config.php";
 
/* Definir les variables */
$titre = $description = $date_soumission = $etat = $date_etat = $est_validee = $date_validation = $id_utilisateur = $id_categorie = "";
$titre_err = $description_err = $date_soumission_err = $etat_err = $date_etat_err = $est_validee_err = $date_validation_err = $id_utilisateur_err = $id_categorie_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    /* Validation du titre */
    $input_titre = trim($_POST["titre"]);
    if(empty($input_titre)){
        $titre_err = "Veuillez entrez un titre.";
    } elseif(!filter_var($input_titre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $titre_err = "Veuillez entrez un nom de titre valide.";
    } else{
        $titre = $input_titre;
    }
    /* Validation de la description */
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Veuillez entrez la description.";     
    }  elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $description_err = "Veuillez entrez un text correct.";
    }  else{
        $description = $input_description;
    }
    /* Validation de la date de soumission */
    $input_date_soumission = trim($_POST["date_soumission"]);
    if(empty($input_date_soumission)){
        $date_soumission_err = "Veuillez entrez la date de soumission.";     
    }  elseif(!ctype_digit($input_date_soumission)){
        $date_soumission_err = "Veuillez entrez des chiffres positives.";
    } else{
        $date_soumission = $input_date_soumission;
    }
    /* Validation de l'etat*/
    $input_etat = trim($_POST["etat"]);
    if(empty($input_etat)){
        $etat_err = "Veuillez donner l'état de votre idée.";     
    } else{
        $etat = $input_etat;
    }
    /* Validation de la date de l'état */
    $input_date_etat = trim($_POST["date_etat"]);
    if(empty($input_date_etat)){
        $date_etat_err = "Veuillez entrez la date de que vous avez mis votre idée dans cette état.";     
    }  elseif(!ctype_digit($input_date_etat)){
        $date_etat_err = "Veuillez entrez des chiffres positives.";
    } else{
        $date_etat = $input_date_etat;
    }

    /* Validation du status*/
    $input_est_validee = trim($_POST["est_validee"]);
    if(empty($input_est_validee)){
        $est_validee_err = "Veuillez donnez le statu.";     
    } else{
        $est_validee = $input_est_validee;
    }
    /* Validation de la date de l'état */
    $input_date_validation = trim($_POST["date_validation"]);
    if(empty($input_date_validation)){
        $date_validation_err = "Veuillez entrez la date de où vous avez validé votre idée.";     
    }  elseif(!ctype_digit($input_date_validation)){
        $date_validation_err = "Veuillez entrez des chiffres positives.";
    } else{
        $date_validation = $input_date_validation;
    }
    /* Validation de l'identifiant de l'utilisateur*/
    $input_id_utilisateur = trim($_POST["id_utilisateur"]);
    if(empty($input_id_utilisateur)){
        $id_utilisateur_err = "Veuillez donnez l'identifiant de l'utilisateur.";     
    } else{
        $id_utilisateur = $input_id_utilisateur;
    }
    /* Validation de l'identifiant du categorie*/
    $input_id_categorie = trim($_POST["id_categorie"]);
    if(empty($input_id_categorie)){
        $id_categorie_err = "Veuillez donnez l'identifiant du categorie.";     
    } else{
        $id_categorie = $input_id_categorie;
    }
    /* verifiez les erreurs avant enregistrement */
    if(empty($titre_err) && empty($description_err) && empty($date_soumission_err) && empty($etat_err) && empty($date_etat_err) && empty($est_validee_err) && empty($date_validation_err) && empty($id_utilisateur_err) && empty($id_categorie_err)){
        /* Préparer une instruction d'insertion*/
        $sql = "INSERT INTO Idee (titre, description,  date_soumission, etat, date_etat, est_validee, date_validation, id_utilisateur, id_categorie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            /* lier les variables à la requette preparée */
            mysqli_stmt_bind_param($stmt, "ssd", $param_titre, $param_description, $param_date_soumission, $param_etat, $param_date_etat, $param_est_validee, $param_date_validation, $param_id_utilisateur, $param_id_categorie);
            
            /* Définition des paramètres*/
            $param_titre = $titre;
            $param_description = $description;
            $param_date_soumission = $date_soumiussion;
            $param_etat = $etat;
            $param_date_etat = $date_etat;
            $param_est_validee = $est_validee;
            $param_date_validation = $date_validation;
            $param_id_utilisateur = $id_utilisateur;
            $param_id_categorie = $id_categorie;
            /* executer la requette */
            if(mysqli_stmt_execute($stmt)){
                /* opération effectuée, retour */
                header("location: index.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        /* Close statement */
        mysqli_stmt_close($stmt);
    }
    
    /* Close connection */
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Créer un enregistrement</h2>
                    <p>Remplir le formulaire pour enregistrer l'idée dans la base de donnée</p>


                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control <?php echo (!empty($titre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titre; ?>">
                            <span class="invalid-feedback"><?php echo $titre_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($dsecription_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date de soumission</label>
                            <input type="date" name="date_soumission" class="form-control <?php echo (!empty($date_soumission_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_soumission; ?>">
                            <span class="invalid-feedback"><?php echo $date_soumission_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Etat</label>
                            <input type="text" name="etat" class="form-control <?php echo (!empty($etat_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $etat; ?>">
                            <span class="invalid-feedback"><?php echo $etat_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date de la mise en cet etat</label>
                            <input type="date" name="date_etat" class="form-control <?php echo (!empty($date_etat_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_etat; ?>">
                            <span class="invalid-feedback"><?php echo $date_etat_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Statu (validée ou non)</label>
                            <input type="text" name="est_validee" class="form-control <?php echo (!empty($est_validee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $est_validee; ?>">
                            <span class="invalid-feedback"><?php echo $est_validee_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date de la validation</label>
                            <input type="date" name="date_validation" class="form-control <?php echo (!empty($date_validation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_validation; ?>">
                            <span class="invalid-feedback"><?php echo $date_validation_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>L'identité de l'utilisateur</label>
                            <input type="number" name="id_utilisateur" class="form-control <?php echo (!empty($id_utilisateur_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id_utilisateur; ?>">
                            <span class="invalid-feedback"><?php echo $id_utilisateur_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>L'identité du catégorie</label>
                            <input type="number" name="id_categorie" class="form-control <?php echo (!empty($id_categorie_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id_categorie; ?>">
                            <span class="invalid-feedback"><?php echo $id_categorie_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>