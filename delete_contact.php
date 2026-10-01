<?php
require_once('database.php');

$contactID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($contactID) {
    $query = 'DELETE FROM contacts WHERE contactID = :contactID';
    $statement = $db->prepare($query);
    $statement->bindValue(':contactID', $contactID);
    $statement->execute();
    $statement->closeCursor();
}
header('Location: index.php');
exit();