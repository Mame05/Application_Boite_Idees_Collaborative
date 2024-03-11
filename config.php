
<?php

// Informations de connexion à la base de données
$serveur_db = 'localhost';
$utilisateur_db = 'root';
$mot_de_passe_db = '';
$nom_db = 'Projet_ITS';
// Créer une connexion à la base de données
$connexion = new mysqli($serveur_db, $utilisateur_db, $mot_de_passe_db, $nom_db);

// Vérifier la connexion
/*if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

echo "Connexion à la base de données réussie.";

// ... Vous pouvez maintenant effectuer des opérations sur la base de données ...

// Fermer la connexion (ceci est facultatif car la connexion sera automatiquement fermée à la fin du script)
$connexion->close();*/

?>