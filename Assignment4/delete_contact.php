<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header('Location: login_form.php');
    exit();
}

require_once("database.php");


    // get data from the form
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    // get current contact record
    
$queryContacts = "SELECT * FROM contacts
                  WHERE contactID = :contact_id
                  AND userID = :userID";


    $statement = $db->prepare($queryContacts);
    $statement->bindValue(':contact_id', $contact_id);

$statement->bindValue(':userID', $_SESSION['userID'], PDO::PARAM_INT);

    $statement->execute();
    $contact = $statement->fetch();
    $statement->closeCursor();

if (!$contact) {
    http_response_code(404);
    exit('Contact not found or access denied.');
}


    // delete contact from database
    
$queryDelete = "DELETE FROM contacts
                WHERE contactID = :contact_id
                AND userID = :userID";


    $statement = $db->prepare($queryDelete);
    $statement->bindValue(':contact_id', $contact_id);

$statement->bindValue(':userID', $_SESSION['userID'], PDO::PARAM_INT);

    $statement->execute();
    
    $statement->closeCursor();

    // reload the index page
    $url = "index.php";
    header("Location: " . $url);
    die();

?>