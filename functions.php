<?php

/**
 * Récupère tous les enregistrements de la table origins
 */
function getAllOrigins()
{
    $pdo = dataBaseConnect();

    $sql = 'SELECT *
            FROM origins
            ORDER BY origineLabel';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}


/**
 * Ajoute un abonné à la liste des emails
 */
function addSubscriber(string $email, string $firstname, string $lastname, int $originId)
{
    $pdo = dataBaseConnect();

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscriber
            (email, firstname, lastname, idOrigin, dateCreate) 
            VALUES (?,?,?,?, NOW())';

    $query = $pdo->prepare($sql);
    $query->execute([$email, $firstname, $lastname, $originId]);

    $subscriberId = $pdo->lastInsertId();
    return $subscriberId;
}


/**
 * Récupère tous les enregistrements de la table interest
 */
function getAllInterest()
{
    $pdo = dataBaseConnect();

    $sql = 'SELECT *
            FROM interest
            ORDER BY interestLabel';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}


function getAllInterestId(int $subscriberId, array $interests)
{
    $pdo = dataBaseConnect();

    foreach ($interests as $interest_id) {
        $sql = 'INSERT INTO subscriberInterest
        (subscriberId, interestId) 
        VALUES (?,?)';


        $query = $pdo->prepare($sql);
        $query->bindParam('subscriberId', $subscriberId);
        $query->bindParam('interestId', $interest_id);

        $query->execute([$subscriberId, $interest_id]);
    }
}

function emailExist($email)
{
    $pdo = dataBaseConnect();

    $reqMail = $pdo->prepare("SELECT * FROM subscriber WHERE email=?");
    $reqMail->execute(array($email));
    $mailExist = $reqMail->rowCount();

    if ($mailExist == 1) {
        return true;
    } else {
        return false;
    }
}


function dataBaseConnect()
{

    // Construction du Data Source Name
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    return $pdo;
}


function errors($errors, $email, $firstname, $lastname, $selectOrigin, $selectInterest)
{

    $errors = [];

    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    }


    if (emailExist($email)) {
        $errors['email'] = "Le mail existe déjà";
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
    return $errors;
}
