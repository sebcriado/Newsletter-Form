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

    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    $reqMail = $pdo->prepare("SELECT * FROM subscriber WHERE email=?");
    $reqMail->execute(array($email));
    $mailExist = $reqMail->rowCount();

    if ($mailExist == 1) {
        $errors['email'] = "L'adresse mail existe déjà";
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

// Vérification si l'email existe



// Inclusion du template
include 'index.phtml';
