<?php

require 'config.php';

require 'functions.php';


$filename = $argv[1];


if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit; // On arrête l'exécution du script
}

$file = fopen($filename, "r");


// $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdoStatement = $pdo->prepare('INSERT INTO subscriber (firstname, lastname, email, dateCreate) VALUES (?,?,?,?)');


while ($row = fgetcsv($file)) {

    /**
     * $row représente une ligne du fichier CSV, les données sont récupérées dans un tableau
     * La première colone est le nom du produit
     * La deuxième colone est son prix sous forme d'une chaîne de caractères
     */
    $firstname = $row[0];
    $lastname = $row[1];
    $email = $row[2];
    $date = new DateTime();
    $newDate = $date->format('Y-m-d H:i:s');

    $firstname = strtolower($firstname);
    $firstname = ucwords($firstname, ' -');
    $lastname = strtolower($lastname);
    $lastname = ucwords($lastname, ' -');
    $email = strtolower($email);
    $email = str_replace(" ", "", $email);
    if (emailExist($email) === false) {
        $pdoStatement->execute([$firstname, $lastname, $email, $newDate]);
    } else {
        echo $email . " existe déjà \n";
    }
}

echo 'Import terminé!';
