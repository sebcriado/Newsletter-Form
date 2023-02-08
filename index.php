<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';
// $interest = [];


// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $selectInterest = '';

    // On récupère l'origine
    $selectOrigin = $_POST['origine'];

    if (isset($_POST['interest'])) {
        $selectInterest = $_POST['interest'];
    }
    // Validation 
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    }

    if (!$firstname) {
        $errors['prenom'] = "Merci d'indiquer un prénom";
    }

    if (!$lastname) {
        $errors['nom'] = "Merci d'indiquer un nom";
    }

    if ($selectOrigin < 2) {
        $errors['origine'] = "Veuillez sélectionner au moins un champ";
    }

    if (!$selectInterest) {
        $errors['interest'] = "Veuillez sélectionner au moins une case";
    }

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addSubscriber($email, $firstname, $lastname, $selectOrigin, $selectInterest);

        // Message de succès
        $success  = 'Merci de votre inscription';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();

// Sélection de la liste des intérêts
$interests = getAllInterest();

// Vérification si l'email existe
$mailExist = emailExist($email, $errors);


// Inclusion du template
include 'index.phtml';
