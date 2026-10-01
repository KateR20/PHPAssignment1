<?php
require_once('database.php');

$contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$email = filter_input(INPUT_POST, 'email');
$phone = filter_input(INPUT_POST, 'phone');
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$image = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $image = basename($_FILES['image']['name']);
    $target = 'uploads/' . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}
if ($image) {
    $query = 'UPDATE contacts
              SET firstName = :firstName,
                  lastName = :lastName,
                  email = :email,
                  phone = :phone,
                  category_id = :category_id,
                  image = :image
              WHERE contactID = :contactID';
} else {
    $query = 'UPDATE contacts
              SET firstName = :firstName,
                  lastName = :lastName,
                  email = :email,
                  phone = :phone,
                  category_id = :category_id
              WHERE contactID = :contactID';
}

$statement = $db->prepare($query);
$statement->bindValue(':firstName', $firstName);
$statement->bindValue(':lastName', $lastName);
$statement->bindValue(':email', $email);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':category_id', $category_id);
if ($image) {
    $statement->bindValue(':image', $image);
}
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$statement->closeCursor();

header('Location: index.php');
exit();