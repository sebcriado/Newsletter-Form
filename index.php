<?php
session_start();

// Message de succès
if (!empty($_POST)) {
    $_SESSION['message'] = $_POST;
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

if (isset($_SESSION['message'])) {
    $_POST = $_SESSION['message'];
    unset($_SESSION['message']);
}
// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$success = null;
$email = '';
$firstname = '';
$lastname = '';
$selectOrigin = '';
// $selectInterest = '';
// $interest = [];
$errors = [];
// $errors = errors($errors, $email, $firstname, $lastname, $selectOrigin, $selectInterest);


// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $selectInterest = [];

    // On récupère l'origine
    $selectOrigin = $_POST['origine'];

    if (isset($_POST['interest'])) {
        $selectInterest = $_POST['interest'];
    }

    // Validation 
    $errors = errors($errors, $email, $firstname, $lastname, $selectOrigin, $selectInterest);

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        $subscriberId = addSubscriber($email, $firstname, $lastname, $selectOrigin, $selectInterest);
        getAllInterestId($subscriberId, $selectInterest);

        $success = "Votre inscription est prise en compte";
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();

// Sélection de la liste des intérêts
$interests = getAllInterest();



// Inclusion du template
include 'index.phtml';
