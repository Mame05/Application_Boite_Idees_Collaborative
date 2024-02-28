
<?php

// Informations de connexion à la base de données
$serveur_db = 'localhost';
$utilisateur_db = 'root';
$mot_de_passe_db = '';
$nom_db = 'Projet_ITS';

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur_db;dbname=$nom_db", $utilisateur_db, $mot_de_passe_db);

    // Paramétrage de la connexion pour afficher les erreurs en cas de problème
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion à la base de données réussie.";
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>
